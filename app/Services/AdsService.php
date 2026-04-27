<?php

namespace App\Services;


use App\Models\Advertisement;
use App\Models\Image;
use App\Models\Post;
use App\Models\Trader;
use App\Traits\ApiResponse;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdsService
{
    use ImageTrait, ApiResponse;

    protected $schedulingService;

    public function __construct(AdSchedulingService $schedulingService)
    {
        $this->schedulingService = $schedulingService;
    }

    public function create_ads($request)
    {
        $trader = Auth::user();

        // Determine initial status based on scheduling dates
        $status = $this->schedulingService->determineInitialStatus(
            $request->scheduled_at,
            $request->expires_at
        );

        $ads = Advertisement::create([
            'title' => request('title'),
            'description' => request('description'),
            'notes' => request('notes'),
            'price' => request('price'),
            'type' => request('type'),
            'trader_id' => $trader->id,
            'scheduled_at' => request('scheduled_at'),
            'expires_at' => request('expires_at'),
            'status' => $status,
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // use trait
                $imagePath = $this->addImage($image, 'postImage');
                // create image
                Image::create([
                    'url' => $imagePath,
                    'related_id' => $ads->id,
                    'related_type' => Advertisement::class,
                ]);
            }
        }
        return $this->success($ads->load('image'), 'Ads created successfully', 201);
    }

    public function get_my_ads(Request $request)
    {
        $trader = Auth::user();
        // Get the number of posts per page from the request, default to 5
        $perPage = $request->input('per_page', 5);

        $page = $request->input('page', 1);
        // Paginate the posts belonging to the authenticated trader
        $adv = Advertisement::where('trader_id', $trader->id)
            ->with([
                'image',
                'rates' => function ($q) {
                    $q->select('id', 'rated_id', 'rated_type', 'user_id', 'rate', 'comment', 'created_at');
                },
            ])

            ->paginate($perPage, ['*'], 'page', $page);

        $adv->getCollection()->each(function ($adv) {
            $adv->city = $adv->trader->city;
        });
        // Format response with paginated posts and trader's store information
        return $this->success($adv);
    }

    public function delete_ads($request)
    {
        $adv = $request;
        $trader = Auth::user();
        $adv = Advertisement::where('id', $adv)
            ->where('trader_id', $trader->id)
            ->first();

        if (!$adv) {
            return $this->error('Ads not found or unauthorized', 404);
        }
        $adv->delete();
        return $this->success(null, 'Ads deleted successfully');
    }
}
