<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Services\UserService;
use App\Services\VerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userService;
    //    protected $verifyService ;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        //        $this->verifyService = $verifyService;
    }

    /**
     * @group Authentication
     *
     * Register a new user account.
     *
     * Creates a new user account with the provided credentials. Upon successful registration,
     * returns user details along with an authentication token.
     *
     * @unauthenticated
     *
     * @bodyParam name string required User's full name. Example: John Doe
     * @bodyParam phone string required User's phone number (must be unique). Example: +1234567890
     * @bodyParam email string optional User's email address. Example: john.doe@example.com
     * @bodyParam password string required User's password (minimum 6 characters). Example: password123
     * @bodyParam fcm_token string optional Firebase Cloud Messaging token for push notifications. Example: fcm_token_here
     *
     * @response 201 {
     *   "status": true,
     *   "message": "User registered successfully",
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "phone": "+1234567890",
     *       "email": "john.doe@example.com"
     *     },
     *     "token": "1|abc123tokenxyz"
     *   }
     * }
     *
     * @response 422 {
     *   "status": false,
     *   "message": "Validation errors",
     *   "errors": {
     *     "phone": ["The phone has already been taken."]
     *   }
     * }
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->userService->register($request);
        return $user;
    }

    /**
     * @group Authentication
     *
     * User login.
     *
     * Authenticates a user with phone and password credentials and returns an authentication token.
     *
     * @unauthenticated
     *
     * @bodyParam phone string required User's phone number. Example: +1234567890
     * @bodyParam password string required User's password (minimum 6 characters). Example: password123
     * @bodyParam fcm_token string optional Firebase Cloud Messaging token for push notifications. Example: fcm_token_here
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Login successful",
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "phone": "+1234567890",
     *       "email": "john.doe@example.com"
     *     },
     *     "token": "1|abc123tokenxyz"
     *   }
     * }
     *
     * @response 401 {
     *   "status": false,
     *   "message": "Invalid credentials"
     * }
     *
     * @response 422 {
     *   "status": false,
     *   "message": "Validation errors",
     *   "errors": {
     *     "phone": ["The phone field is required."]
     *   }
     * }
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userService->login($request);
        return $user;
    }

    /**
     * @group Authentication
     *
     * User logout.
     *
     * Logs out the authenticated user by invalidating their current access token.
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
        $user = $this->userService->logout($request);
        return $user;
    }

    /**
     * @group User Management
     *
     * Update user profile.
     *
     * Updates the authenticated user's profile information including name and email.
     *
     * @authenticated
     *
     * @bodyParam name string optional User's full name. Example: Jane Doe
     * @bodyParam email string optional User's email address. Example: jane.doe@example.com
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Profile updated successfully",
     *   "data": {
     *     "id": 1,
     *     "name": "Jane Doe",
     *     "phone": "+1234567890",
     *     "email": "jane.doe@example.com"
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
     *     "email": ["The email format is invalid."]
     *   }
     * }
     */
    public function updateProfile(UserUpdateProfileRequest $request)
    {
        $response = $this->userService->updateProfile($request);
        return $response;
    }

    /**
     * @group User Management
     *
     * Get authenticated user profile.
     *
     * Retrieves the complete profile information of the currently authenticated user.
     *
     * @authenticated
     *
     * @response 200 {
     *   "status": true,
     *   "data": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "phone": "+1234567890",
     *     "email": "john.doe@example.com",
     *     "created_at": "2024-01-15T10:30:00.000000Z",
     *     "updated_at": "2024-01-15T10:30:00.000000Z"
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
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    /**
     * @group User Management
     *
     * Get list of cities.
     *
     * Retrieves a list of all available cities in the system.
     *
     * @unauthenticated
     *
     * @response 200 {
     *   "status": true,
     *   "data": [
     *     "New York",
     *     "Los Angeles",
     *     "Chicago",
     *     "Houston",
     *     "Phoenix"
     *   ]
     * }
     */
    public function getCities()
    {
        $response = $this->userService->getCities();
        return $response;
    }
}
