<?php

namespace App\Http\Controllers\Trader;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\TraderRegisterRequest;
use App\Services\TraderService;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTraderProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    protected $traderService;
    //    protected $verifyService ;

    public function __construct(TraderService $traderService)
    {
        $this->traderService = $traderService;
        //        $this->verifyService = $verifyService;
    }

    /**
     * @group Authentication
     *
     * Register a new trader account.
     *
     * Creates a new trader account with store details. Upon successful registration,
     * returns trader details along with an authentication token.
     *
     * @unauthenticated
     *
     * @bodyParam owner_contact_number string required Trader's phone number (must be unique). Example: +1234567890
     * @bodyParam password string required Trader's password (minimum 6 characters). Example: password123
     * @bodyParam city string optional City where the store is located. Example: New York
     * @bodyParam whatsapp_number string optional WhatsApp contact number. Example: +1234567890
     * @bodyParam telegram_number string optional Telegram contact number. Example: +1234567890
     * @bodyParam social_media_link string optional Social media profile link. Example: https://facebook.com/store
     * @bodyParam store_description string optional Description of the store (max 500 characters). Example: Best electronics store in town
     * @bodyParam fcm_token string optional Firebase Cloud Messaging token for push notifications. Example: fcm_token_here
     *
     * @response 201 {
     *   "status": true,
     *   "message": "Trader registered successfully",
     *   "data": {
     *     "trader": {
     *       "id": 1,
     *       "owner_contact_number": "+1234567890",
     *       "city": "New York",
     *       "store": {
     *         "id": 1,
     *         "store_name": "Electronics Store",
     *         "store_owner_name": "John Doe"
     *       }
     *     },
     *     "token": "1|abc123tokenxyz"
     *   }
     * }
     *
     * @response 422 {
     *   "status": false,
     *   "message": "Validation errors",
     *   "errors": {
     *     "owner_contact_number": ["The owner contact number has already been taken."]
     *   }
     * }
     */
    public function register(TraderRegisterRequest $request)
    {
        $user = $this->traderService->register($request);
        return $user;
    }

    /**
     * @group Authentication
     *
     * Trader login.
     *
     * Authenticates a trader with phone and password credentials and returns an authentication token.
     *
     * @unauthenticated
     *
     * @bodyParam phone string required Trader's phone number. Example: +1234567890
     * @bodyParam password string required Trader's password (minimum 6 characters). Example: password123
     * @bodyParam fcm_token string optional Firebase Cloud Messaging token for push notifications. Example: fcm_token_here
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Login successful",
     *   "data": {
     *     "trader": {
     *       "id": 1,
     *       "owner_contact_number": "+1234567890",
     *       "city": "New York",
     *       "store": {
     *         "id": 1,
     *         "store_name": "Electronics Store"
     *       }
     *     },
     *     "token": "1|abc123tokenxyz"
     *   }
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Invalid credentials"
     * }
     */
    public function login(LoginRequest $request)
    {
        $user = $this->traderService->login($request);
        return $user;
    }

    /**
     * @group Authentication
     *
     * Trader logout.
     *
     * Logs out the authenticated trader by invalidating their current access token.
     *
     * @authenticated
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Logged out successfully"
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     */
    public function logout(Request $request)
    {
        $user = $this->traderService->logout($request);
        return $user;
    }

    /**
     * @group Trader Management
     *
     * Update trader profile.
     *
     * Updates the authenticated trader's profile information including city, contact numbers, and store description.
     *
     * @authenticated
     *
     * @bodyParam city string optional City where the store is located. Example: Los Angeles
     * @bodyParam whatsapp_number string optional WhatsApp contact number. Example: +1234567890
     * @bodyParam telegram_number string optional Telegram contact number. Example: +1234567890
     * @bodyParam social_media_link string optional Social media profile link. Example: https://facebook.com/store
     * @bodyParam store_description string optional Description of the store (max 500 characters). Example: Premium electronics retailer
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Profile updated successfully",
     *   "data": {
     *     "id": 1,
     *     "owner_contact_number": "+1234567890",
     *     "city": "Los Angeles",
     *     "whatsapp_number": "+1234567890",
     *     "store_description": "Premium electronics retailer"
     *   }
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     */
    public function updateProfile(UpdateTraderProfileRequest $request)
    {
        /** @var \App\Models\Trader $trader */
        $response = $this->traderService->updateProfile($request);
        return $response;
    }

    /**
     * @group Trader Management
     *
     * Change trader password.
     *
     * Allows the authenticated trader to change their account password.
     *
     * @authenticated
     *
     * @bodyParam current_password string required Current password. Example: oldpass123
     * @bodyParam new_password string required New password (minimum 6 characters). Example: newpass456
     * @bodyParam new_password_confirmation string required Confirmation of new password. Example: newpass456
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Password changed successfully"
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Current password is incorrect"
     * }
     *
     * @response 422 {
     *   "status": false,
     *   "message": "Validation errors",
     *   "errors": {
     *     "new_password": ["The new password confirmation does not match."]
     *   }
     * }
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $response = $this->traderService->changePassword($request);
        return $response;
    }


    /**
     * @group Trader Management
     *
     * Get authenticated trader profile.
     *
     * Retrieves the complete profile information of the currently authenticated trader including store details and subcategories.
     *
     * @authenticated
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *     "id": 1,
     *     "owner_contact_number": "+1234567890",
     *     "city": "New York",
     *     "whatsapp_number": "+1234567890",
     *     "store": {
     *       "id": 1,
     *       "store_name": "Electronics Store",
     *       "store_owner_name": "John Doe",
     *       "subCategories": [
     *         {
     *           "id": 1,
     *           "name": "Smartphones",
     *           "image": "https://example.com/image.jpg"
     *         }
     *       ]
     *     },
     *     "created_at": "2024-01-15T10:30:00.000000Z"
     *   }
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Unauthenticated"
     * }
     */
    public function getProfile()
    {
        $user = Auth::user()->load('store.subCategories');

        if ($user->store) {
            // Map the subCategories relation to only id, name, image
            $mapped = $user->store->subCategories->map(function ($sub) {
                return [
                    'id'    => $sub->id,
                    'name'  => $sub->name,
                    'image' => $sub->image,
                ];
            })->values();

            // IMPORTANT: override the relation, not a new attribute
            $user->store->setRelation('subCategories', $mapped);
        }

        return response()->json([
            'status' => true,
            'data'   => $user,
        ]);
    }
}
