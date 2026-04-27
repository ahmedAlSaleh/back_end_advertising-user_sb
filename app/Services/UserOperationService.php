<?php

namespace App\Services;

use App\Models\Advertisement;
use App\Models\Block;
use App\Models\Favorite;
use App\Models\Image;
use App\Models\Post;
use App\Models\Rate;
use App\Models\RechargeCode;
use App\Models\RechargeOperation;
use App\Models\Store;
use App\Models\Trader;
use App\Models\Wallet;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SubCategory;

class UserOperationService
{
    protected $viewService;
    protected $storeHoursService;

    public function __construct(ViewService $viewService, StoreHoursService $storeHoursService)
    {
        $this->viewService = $viewService;
        $this->storeHoursService = $storeHoursService;
    }

    public function getPost($request)
    {
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);
        $keyword = $request->input('keyword');  // search


        $query = Post::with([
            'image',
            'trader.store'
        ])
            ->orderBy('created_at', 'desc');


        if (!is_null($keyword)) {
            $query->where('title', 'like', '%' . $keyword . '%');
        }


        $posts = $query->paginate($perPage, ['*'], 'page', $page);


        $posts->each(function ($post) {
            $post->likes_count = $post->likesCount();
            $post->dislikes_count = $post->dislikesCount();
            $post->city = $post->trader->city;
        });

        return response()->json([
            "status" => true,
            "posts" => $posts,
        ], 200);
    }

    public function getAds(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);
        $categoryId = $request->input('category_id');
        $type = $request->input('type');

        $user = auth()->user();

        $query = Advertisement::with(['image', 'trader.store'])
            ->where('status', 'active')
            ->orderByRaw('CASE WHEN is_featured = 1 AND featured_until > NOW() THEN 0 ELSE 1 END')
            ->orderByRaw('CASE WHEN feature_type = "premium" THEN 0 WHEN feature_type = "basic" THEN 1 ELSE 2 END')
            ->orderBy('created_at', 'desc');


        if (!is_null($categoryId)) {
            $query->whereHas('trader.store', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        if (!is_null($type)) {
            $query->where('type', $type);
        }

        $adv = $query->paginate($perPage, ['*'], 'page', $page);
        // Hide trader and store after filtering
        $adv->getCollection()->each(function ($advertisement) use ($user) {
            //  user has favorited this advertisement
            if (Auth::check()) {
                $isFavorite = Favorite::where('favorite_id', $advertisement->id)
                    ->where('favorite_type', "advertisements")
                    ->where('user_id', $user->id)
                    ->exists();


                $advertisement->is_favorite = $isFavorite;
            } else {
                $advertisement->is_favorite = false;
            }

            // Add featured tag
            $advertisement->is_featured_tag = $advertisement->is_featured && $advertisement->featured_until > now();

            $advertisement->makeHidden(['trader']);
            $advertisement->city = $advertisement->trader->city;
        });

        return response()->json([
            "status" => true,
            "data" => $adv,
        ], 200);
    }
    public function toggleFavorite($advertisementId)
    {

        $user = auth()->user();

        $advertisement = Advertisement::findOrFail($advertisementId);


        $existingFavorite = Favorite::where('favorite_id', $advertisement->id)
            ->where('favorite_type', "advertisements")
            ->where('user_id', $user->id)
            ->first();

        if ($existingFavorite) {
            //  remove it from the favorites
            $existingFavorite->delete();
            return response()->json([
                'status' => false,
                'message' => 'Advertisement removed from favorites'
            ], 200);
        } else {
            //  add it to the favorites
            Favorite::create([
                'user_id' => $user->id,
                'favorite_id' => $advertisement->id,
                'favorite_type' => "advertisements",
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Advertisement added to favorites'
            ], 200);
        }
    }

    public function toggleStoreFavorite($storeId)
    {

        $user = auth()->user();

        $store = Store::findOrFail($storeId);


        $existingFavorite = Favorite::where('favorite_id', $store->id)
            ->where('favorite_type', "stores")
            ->where('user_id', $user->id)
            ->first();

        if ($existingFavorite) {
            //  remove it from the favorites
            $existingFavorite->delete();
            return response()->json([
                'status' => false,
                'message' => 'Store removed from favorites'
            ], 200);
        } else {
            //  add it to the favorites
            Favorite::create([
                'user_id' => $user->id,
                'favorite_id' => $store->id,
                'favorite_type' => "stores",
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Store added to favorites'
            ], 200);
        }
    }

    public function toggleStoreBlock($storeId)
    {

        $user = auth()->user();

        $store = Store::findOrFail($storeId);


        $existingBlock = Block::where('blocked_id', $store->id)
            ->where('blocked_type', "store")
            ->where('user_id', $user->id)
            ->first();

        if ($existingBlock) {
            //  remove it from the favorites
            $existingBlock->delete();
            return response()->json([
                'status' => false,
                'message' => 'Store removed from blocked'
            ], 200);
        } else {
            //  add it to the favorites
            Block::create([
                'user_id' => $user->id,
                'blocked_id' => $store->id,
                'blocked_type' => "store",
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Store added to blocked'
            ], 200);
        }
    }


    public function getBlockedStores(Request $request)
    {
        $userId = auth()->id();

        // 1) Collect blocked store IDs (unique, non-null)
        $storeIds = Block::where('blocked_type', 'store')
            ->where('user_id', $userId)
            ->pluck('blocked_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // Pagination settings
        $perPage = 5;
        $page    = $request->input('page', 1);

        // 2) Get the Store models for those IDs with pagination + relations
        $stores = Store::with(['traders', 'subCategories'])
            ->whereIn('id', $storeIds)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        // 3) Shape each store (add city, is_favorite, trim subcategories)
        $stores->getCollection()->transform(function ($store) {
            // Blocked stores are not favorites (you can keep or remove this flag as you like)
            $store->is_favorite = false;

            // city from first related trader
            $trader      = $store->traders->first();
            $store->city = $trader->city ?? null;

            // limit subCategories to id, name, image
            $mappedSubCats = $store->subCategories->map(function ($sub) {
                return [
                    'id'    => $sub->id,
                    'name'  => $sub->name,
                    'image' => $sub->image,
                ];
            })->values();

            // overwrite relation so JSON has only these fields
            $store->setRelation('subCategories', $mappedSubCats);

            return $store;
        });

        return response()->json([
            'status' => true,
            'stores' => $stores, // includes data + pagination info
        ], 200);
    }


    public function search(Request $request)
    {
        $categoryId = $request->input('category_id');
        $minPrice   = $request->input('min_price');
        $maxPrice   = $request->input('max_price');
        $keyword    = $request->input('keyword');

        $user = auth()->user();

        $query = Advertisement::with(['image', 'trader.store'])
            ->where('status', 'active')
            ->orderByRaw('CASE WHEN is_featured = 1 AND featured_until > NOW() THEN 0 ELSE 1 END')
            ->orderByRaw('CASE WHEN feature_type = "premium" THEN 0 WHEN feature_type = "basic" THEN 1 ELSE 2 END')
            ->orderBy('created_at', 'desc');

        if (!is_null($categoryId)) {
            $query->whereHas('trader.store', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        if (!is_null($keyword)) {
            $query->where('title', 'like', '%' . $keyword . '%');
        }

        if (!is_null($minPrice) && !is_null($maxPrice)) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif (!is_null($minPrice)) {
            $query->where('price', '>=', $minPrice);
        } elseif (!is_null($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }

        // Pagination: 5 items per page
        $perPage = 5;
        $page    = $request->input('page', 1);

        $advertisements = $query->paginate($perPage, ['*'], 'page', $page);

        if (Auth::check()) {
            $advertisements->getCollection()->each(function ($advertisement) use ($user) {
                $isFavorite = Favorite::where('favorite_id', $advertisement->id)
                    ->where('favorite_type', "advertisements")
                    ->where('user_id', $user->id)
                    ->exists();

                $advertisement->is_favorite = $isFavorite;
                $advertisement->city        = $advertisement->trader->city ?? null;
                $advertisement->makeHidden(['trader']);
            });
        } else {
            $advertisements->getCollection()->each(function ($advertisement) {
                $advertisement->is_favorite = false;
                $advertisement->city        = $advertisement->trader->city ?? null;
                $advertisement->makeHidden(['trader']);
            });
        }

        return response()->json([
            "status" => true,
            "data"   => $advertisements, // includes data + pagination meta (current_page, last_page, etc.)
        ], 200);
    }


    public function searchStore(Request $request)
    {
        $keyword = $request->input('name');
        $city    = $request->input('city');

        $user = auth()->user();

        // Eager load traders + subCategories
        $query = Store::with(['traders', 'subCategories'])
            ->orderBy('created_at', 'desc');

        if (!is_null($keyword)) {
            $query->where('store_name', 'like', '%' . $keyword . '%');
        }

        if (!is_null($city)) {
            $query->whereHas('traders', function ($q) use ($city) {
                $q->where('city', $city);
            });
        }

        // Pagination: 5 stores per page
        $perPage = 5;
        $page    = $request->input('page', 1);

        $stores = $query->paginate($perPage, ['*'], 'page', $page);

        // Prepare favorite ids once (if logged in)
        $favoriteIds = [];
        if ($user) {
            $favoriteIds = Favorite::where('user_id', $user->id)
                ->where('favorite_type', 'stores')
                ->pluck('favorite_id')
                ->all();
        }

        // Transform each store in the paginated collection
        $stores->getCollection()->transform(function ($store) use ($favoriteIds, $user) {
            // is_favorite
            if ($user) {
                $store->is_favorite = in_array($store->id, $favoriteIds, true);
            } else {
                $store->is_favorite = false;
            }

            // city from first related trader
            $trader     = $store->traders->first();
            $store->city = $trader->city ?? null;

            // limit subCategories fields: id, name, image
            $mappedSubCats = $store->subCategories->map(function ($sub) {
                return [
                    'id'    => $sub->id,
                    'name'  => $sub->name,
                    'image' => $sub->image,
                ];
            })->values();

            // overwrite relation so JSON only has these fields
            $store->setRelation('subCategories', $mappedSubCats);

            return $store;
        });

        return response()->json([
            'status' => true,
            // $stores includes items + pagination meta
            'data'   => $stores,
        ], 200);
    }


    public function Getsrote($subCategoryId)
    {
        $user = Auth::user();

        // Base query: stores that are linked to this subcategory + load their subCategories
        $query = Store::with('subCategories')->whereHas('subCategories', function ($q) use ($subCategoryId) {
            $q->where('sub_categories.id', $subCategoryId);
        });

        // If logged in, exclude blocked stores
        if ($user) {
            $blockedIds = Block::where('user_id', $user->id)
                ->where('blocked_type', 'store')
                ->pluck('blocked_id');

            if ($blockedIds->isNotEmpty()) {
                $query->whereNotIn('id', $blockedIds);
            }
        }

        $stores = $query->get();

        // Mark favorites + limit subcategories fields
        if ($user) {
            $favoriteIds = Favorite::where('user_id', $user->id)
                ->where('favorite_type', 'stores')
                ->pluck('favorite_id')
                ->all();

            $stores->each(function ($store) use ($favoriteIds) {
                // favorite flag
                $store->is_favorite = in_array($store->id, $favoriteIds, true);

                // map subcategories (id, name, image only)
                $mappedSubCats = $store->subCategories->map(function ($sub) {
                    return [
                        'id'    => $sub->id,
                        'name'  => $sub->name,
                        'image' => $sub->image,
                    ];
                })->values();

                // overwrite relation so JSON has only these fields
                $store->setRelation('subCategories', $mappedSubCats);
            });
        } else {
            $stores->each(function ($store) {
                $store->is_favorite = false;

                $mappedSubCats = $store->subCategories->map(function ($sub) {
                    return [
                        'id'    => $sub->id,
                        'name'  => $sub->name,
                        'image' => $sub->image,
                    ];
                })->values();

                $store->setRelation('subCategories', $mappedSubCats);
            });
        }

        return response()->json([
            'status' => true,
            'data'   => $stores,
        ], 200);
    }





    public function getStorePosts(Request $request, $storeId)
    {
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $posts = Post::with(['image', 'trader.store'])
            ->whereHas('trader', function ($query) use ($storeId) {
                $query->where('store_id', $storeId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $posts->getCollection()->each(function ($post) {

            $post->likes_count = $post->likesCount();
            $post->dislikes_count = $post->dislikesCount();
            $post->city = $post->trader->city;


            $post->makeHidden(['trader']);
        });


        return response()->json([
            "status" => true,
            "posts" => $posts,
        ], 200);
    }

    public function getStoreByAdv(Request $request, $advId)
    {
        $adv = Advertisement::where('id', $advId)
            ->where('status', 'active')
            ->with(['trader.store'])
            ->first();

        if ($adv) {
            // Record advertisement view
            $this->viewService->recordView('advertisement', $advId, $request);

            $trader = $adv['trader'];
            return response()->json([
                "status" => true,
                "data" => $trader,
            ], 200);
        }

        return response()->json([
            "status" => true,
            "data" => [],
        ], 200);
    }


    public function show(Request $request, $storeID)
    {
        // 1) Get store with subcategories
        $store = Store::with('subCategories')->findOrFail($storeID);

        // Record store view
        $this->viewService->recordView('store', $storeID, $request);

        // 2) Favorite flag for current user
        $user = Auth::user();
        $store->is_favorite = false;

        if ($user) {
            $store->is_favorite = Favorite::where('user_id', $user->id)
                ->where('favorite_type', 'stores')
                ->where('favorite_id', $store->id)
                ->exists();
        }

        // 3) Get trader
        $trader = Trader::where('store_id', $storeID)->first();

        if (!$trader) {
            return response()->json([
                'status'  => false,
                'message' => 'Store has no trader assigned.',
            ], 422);
        }

        $traderId = $trader->id;

        // 4) Get ads with rates
        $advertisements = Advertisement::where('trader_id', $traderId)
            ->with([
                'image',
                'rates:id,rated_id,rate,comment,user_id,created_at',
            ])
            ->get();

        // 5) Compute average rate across ALL ads of this trader
        $allRates  = $advertisements->flatMap(fn($adv) => $adv->rates->pluck('rate'));
        $storeRate = $allRates->isNotEmpty() ? round($allRates->avg(), 2) : null;

        // 6) Attach extra info (not saved in DB)
        $store->store_rate = $storeRate;
        $store->city       = $trader->city;

        // 7) Limit subcategories fields (id, name, image)
        $mappedSubCats = $store->subCategories->map(function ($sub) {
            return [
                'id'    => $sub->id,
                'name'  => $sub->name,
                'image' => $sub->image,
            ];
        })->values();

        // overwrite the relation so JSON only has these fields
        $store->setRelation('subCategories', $mappedSubCats);

        // 8) Get store hours, is_open_now, and next_opening
        $hours = $this->storeHoursService->getFormattedStoreHours($storeID);
        $isOpenNow = $this->storeHoursService->isStoreOpenNow($storeID);
        $nextOpening = $this->storeHoursService->getNextOpening($storeID);

        return response()->json([
            'status' => true,
            'store'  => $store,
            'hours' => $hours,
            'is_open_now' => $isOpenNow,
            'next_opening' => $nextOpening,
        ], 200);
    }

    public function showfavorite(Request $request)
    {
        $user = Auth::user();

        // Get IDs of favorite advertisements for this user
        $favoriteIds = Favorite::where('user_id', $user->id)
            ->where('favorite_type', "advertisements")
            ->pluck('favorite_id')
            ->toArray();

        // Pagination settings
        $perPage = 5;
        $page    = $request->input('page', 1);

        // Get paginated favorite advertisements
        $adv = Advertisement::whereIn('id', $favoriteIds)
            ->with('image')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            "status" => true,
            "data"   => $adv, // contains items + pagination info
        ], 200);
    }


    public function showfavoriteStore(Request $request)
    {
        $user = Auth::user();

        // Get IDs of favorite stores for this user
        $favoriteIds = Favorite::where('user_id', $user->id)
            ->where('favorite_type', "stores")
            ->pluck('favorite_id')
            ->toArray();

        // Pagination settings
        $perPage = 5;
        $page    = $request->input('page', 1);

        // Get paginated favorite stores, with traders + subCategories
        $stores = Store::with(['traders', 'subCategories'])
            ->whereIn('id', $favoriteIds)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        // Transform each store in the collection
        $stores->getCollection()->transform(function ($store) {
            // All of these are favorites by definition
            $store->is_favorite = true;

            // city from first related trader
            $trader      = $store->traders->first();
            $store->city = $trader->city ?? null;

            // limit subCategories fields: id, name, image
            $mappedSubCats = $store->subCategories->map(function ($sub) {
                return [
                    'id'    => $sub->id,
                    'name'  => $sub->name,
                    'image' => $sub->image,
                ];
            })->values();

            // overwrite relation so JSON only has these fields
            $store->setRelation('subCategories', $mappedSubCats);

            return $store;
        });

        return response()->json([
            "status" => true,
            "data"   => $stores, // contains items + pagination info
        ], 200);
    }


    public function getStoreAds(Request $request, $storeId)
    {
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $adv = Advertisement::with(['image', 'trader.store'])
            ->where('status', 'active')
            ->whereHas('trader', function ($query) use ($storeId) {
                $query->where('store_id', $storeId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $adv->getCollection()->each(function ($adv) {

            $adv->makeHidden(['trader']);
            $adv->city = $adv->trader->city;
        });


        return response()->json([
            "status" => true,
            "data" => $adv,
        ], 200);
    }

    public function rate(Request $request)
    {
        $request->validate([
            'adv_id' => 'required|integer',
            'rate'   => 'required|numeric|min:1|max:5', // adjust bounds as needed
            'comment' => 'nullable|string',
        ]);

        $user   = Auth::user();
        $advId  = (int) $request->input('adv_id');

        try {
            $rate = DB::transaction(function () use ($user, $advId, $request) {
                // 1) Remove any previous rating by this user for this advertisement
                Rate::where('user_id', $user->id)
                    ->where('rated_type', 'advertisement')
                    ->where('rated_id', $advId)
                    ->delete();

                // 2) Create the new rating
                return Rate::create([
                    'user_id'    => $user->id,
                    'rate'       => $request->input('rate'),
                    'comment'    => $request->input('comment'),
                    'rated_type' => 'advertisement',
                    'rated_id'   => $advId,
                ]);
            });

            return response()->json([
                'status'  => true,
                'message' => 'Your rate was submitted successfully.',
                'data'    => $rate, // optional: return the new rate
            ], 201);
        } catch (\Throwable $e) {
            // Log if you want: \Log::error($e);
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while submitting your rate.',
            ], 500);
        }
    }


    public function getRates(Request $request, $advId)
    {
        // Pagination settings
        $perPage = 5;
        $page    = $request->input('page', 1);

        $rates = Rate::where('rated_id', $advId)
            ->where('rated_type', 'advertisement')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'status' => true,
            'data'   => $rates, // includes items + pagination meta
        ], 200);
    }
}
