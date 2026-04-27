<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddRateRequest;
use App\Services\UserOperationService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserOperationController extends Controller
{
    protected $userOperation ;


    public function __construct(UserOperationService $userOperationService) {
        $this->userOperation = $userOperationService;

    }


    /**
     * @group Post Management
     *
     * Get list of posts.
     *
     * Retrieves a paginated list of posts from stores. Users can view all available posts.
     *
     * @authenticated
     *
     * @queryParam per_page integer optional Number of items per page. Example: 15
     * @queryParam page integer optional Page number. Example: 1
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "id": 1,
     *         "title": "New Product Launch",
     *         "images": ["image1.jpg", "image2.jpg"],
     *         "store_id": 5,
     *         "likes_count": 25,
     *         "created_at": "2024-01-15T10:30:00.000000Z"
     *       }
     *     ],
     *     "total": 50,
     *     "per_page": 15
     *   }
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     */
    public function getPost(Request $request)
    {
        $res = $this->userOperation->getPost($request);
        return $res ;
    }
    /**
     * @group Advertisement Management
     *
     * Get list of advertisements.
     *
     * Retrieves a paginated list of advertisements filtered by category and type.
     * Advertisements can be either normal or special (promoted).
     *
     * @authenticated
     *
     * @queryParam category_id integer optional Filter by store category ID. Example: 5
     * @queryParam type string required Advertisement type (normal or special). Example: normal
     * @queryParam per_page integer optional Number of items per page. Example: 20
     * @queryParam page integer optional Page number. Example: 1
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "id": 1,
     *         "title": "Summer Sale",
     *         "description": "50% off on all items",
     *         "price": 99.99,
     *         "images": ["ad1.jpg", "ad2.jpg"],
     *         "type": "normal",
     *         "store_id": 5,
     *         "rating": 4.5,
     *         "created_at": "2024-01-15T10:30:00.000000Z"
     *       }
     *     ],
     *     "total": 100,
     *     "per_page": 20
     *   }
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     *
     * @response 422 {
     *   "status": false,
     *   "message": "Validation errors",
     *   "errors": {
     *     "type": ["The type field is required."]
     *   }
     * }
     */
    public function getAds(Request $request)
    {

        $validated = $request->validate([
            'category_id' => 'nullable|integer|exists:stores,category_id',
            'type' => 'required|in:normal,special',
            'per_page' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $res = $this->userOperation->getAds($request);
        return $res ;
    }
    /**
     * @group Interactions
     *
     * Toggle favorite advertisement.
     *
     * Adds or removes an advertisement from the authenticated user's favorites list.
     * If the advertisement is already favorited, it will be unfavorited and vice versa.
     *
     * @authenticated
     *
     * @urlParam request integer required Advertisement ID to toggle favorite status. Example: 15
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Advertisement added to favorites"
     * }
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Advertisement removed from favorites"
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "Advertisement not found"
     * }
     */
    public function toggleFavorite($request)
    {
        $res = $this->userOperation->toggleFavorite($request);
        return $res ;
    }
    /**
     * @group Interactions
     *
     * Toggle favorite store.
     *
     * Adds or removes a store from the authenticated user's favorites list.
     * If the store is already favorited, it will be unfavorited and vice versa.
     *
     * @authenticated
     *
     * @urlParam request integer required Store ID to toggle favorite status. Example: 8
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Store added to favorites"
     * }
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Store removed from favorites"
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "Store not found"
     * }
     */
    public function toggleStoreFavorite($request)
    {
        $res = $this->userOperation->toggleStoreFavorite($request);
        return $res ;
    }
    /**
     * @group Interactions
     *
     * Toggle block store.
     *
     * Blocks or unblocks a store for the authenticated user. Blocked stores and their
     * advertisements will be hidden from the user's feed.
     *
     * @authenticated
     *
     * @urlParam request integer required Store ID to toggle block status. Example: 12
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Store has been blocked"
     * }
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Store has been unblocked"
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "Store not found"
     * }
     */
    public function toggleStoreBlock($request)
    {
        $res = $this->userOperation->toggleStoreBlock($request);
        return $res ;
    }
    /**
     * @group Interactions
     *
     * Get blocked stores.
     *
     * Retrieves a paginated list of all stores that the authenticated user has blocked.
     *
     * @authenticated
     *
     * @queryParam per_page integer optional Number of items per page. Example: 15
     * @queryParam page integer optional Page number. Example: 1
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "id": 12,
     *         "store_name": "Blocked Store",
     *         "category_id": 3,
     *         "blocked_at": "2024-01-15T10:30:00.000000Z"
     *       }
     *     ],
     *     "total": 5,
     *     "per_page": 15
     *   }
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     */
    public function getBlockedStores(Request $request)
    {
        $res = $this->userOperation->getBlockedStores($request);
        return $res ;
    }
    /**
     * @group Search & Analytics
     *
     * Search advertisements.
     *
     * Searches for advertisements based on keywords and filters.
     *
     * @authenticated
     *
     * @queryParam keyword string optional Search keyword for advertisement title or description. Example: laptop
     * @queryParam category_id integer optional Filter by category. Example: 5
     * @queryParam per_page integer optional Number of items per page. Example: 20
     * @queryParam page integer optional Page number. Example: 1
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "id": 1,
     *         "title": "Gaming Laptop Sale",
     *         "description": "High performance laptop",
     *         "price": 1299.99,
     *         "images": ["laptop1.jpg"]
     *       }
     *     ],
     *     "total": 15,
     *     "per_page": 20
     *   }
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     */
    public function search(Request $request)
    {
        $res = $this->userOperation->search($request);
        return $res ;
    }
    /**
     * @group Search & Analytics
     *
     * Search stores.
     *
     * Searches for stores based on keywords and filters.
     *
     * @authenticated
     *
     * @queryParam keyword string optional Search keyword for store name or description. Example: electronics
     * @queryParam category_id integer optional Filter by category. Example: 3
     * @queryParam city string optional Filter by city. Example: New York
     * @queryParam per_page integer optional Number of items per page. Example: 20
     * @queryParam page integer optional Page number. Example: 1
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "id": 8,
     *         "store_name": "Electronics Hub",
     *         "city": "New York",
     *         "category_id": 3,
     *         "rating": 4.5
     *       }
     *     ],
     *     "total": 10,
     *     "per_page": 20
     *   }
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     */
    public function searchStore(Request $request)
    {
        $res = $this->userOperation->searchStore($request);
        return $res ;
    }

    public function GetStore($categoryId)
    {
        $res = $this->userOperation->Getsrote($categoryId);
        return $res ;
    }
    public function getStorePosts(Request $request ,$storeId)
    {
        $res = $this->userOperation->getStorePosts($request , $storeId);
        return $res ;
    }

    public function getStoreAds(Request $request ,$storeId)
    {
        $res = $this->userOperation->getStoreAds($request , $storeId);
        return $res ;
    }


        public function getStoreByAdv(Request $request, $advId)
    {
        $res = $this->userOperation->getStoreByAdv($request, $advId);
        return $res ;
    }

    public function show(Request $request, $storeID)
    {
        $res = $this->userOperation->show($request, $storeID);
        return $res ;
    }
    public function showfavorite(Request $request)
    {
        $res = $this->userOperation->showfavorite($request);
        return $res ;
    }
    public function showfavoriteStore(Request $request)
    {
        $res = $this->userOperation->showfavoriteStore($request);
        return $res ;
    }
    public function rate(AddRateRequest $request)
    {
        $res = $this->userOperation->rate($request);
        return $res ;
    }
    public function getRates($advId)
    {
        $res = $this->userOperation->getRates($advId);
        return $res ;
    }
}
