<?php

namespace App\Services;

use App\Models\User;

use App\Traits\ImageTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class UserService
{
    use ImageTrait;

//    protected $verifyService;
//
//    public function __construct(VerificationService $service)
//    {
//        $this->verifyService = $service;
//    }

    public function register($request)
    {
        $UserInfo = $request->validated();
        $UserInfo['password'] = Hash::make($request->validated()['password']);
        $user = User::create($UserInfo);
        $user->save();
        $token = $user->createToken('user')->plainTextToken;
        return response()->json([
            'message' => 'successfully register',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function login($request)
    {

        $user = User::where('phone',$request->phone)->first();
        if($user){
            if (!Hash::check($request->password, $user->password)) {
                return response([
                    'message' => __("message.Incorrect password")
                ], 400);
            }
        }
        else{
            return response([
                'message' => __("message.Incorrect phone number")
            ], 400);
        }
        $user = User::find($user->id);
        if($request->fcm_token)
        $user->fcm_token = $request->fcm_token;
        $user->save();
        $token = $user->createToken('user')->plainTextToken;

        return response()->json([
            'message' => 'successfully login',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function updateProfile($request)
    {
        $user = $request->user();
        $user->update($request->all());
        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user->only([
                'name',
                'email'
            ])
        ]);
    }

    public function getCities(): JsonResponse
    {
        $cities = [
            ['name_ar' => 'دمشق', 'name_en' => 'Damascus'],
            ['name_ar' => 'حلب', 'name_en' => 'Aleppo'],
            ['name_ar' => 'حمص', 'name_en' => 'Homs'],
            ['name_ar' => 'حماة', 'name_en' => 'Hama'],
            ['name_ar' => 'اللاذقية', 'name_en' => 'Latakia'],
            ['name_ar' => 'طرطوس', 'name_en' => 'Tartus'],
            ['name_ar' => 'درعا', 'name_en' => 'Daraa'],
            ['name_ar' => 'السويداء', 'name_en' => 'As-Suwayda'],
            ['name_ar' => 'القنيطرة', 'name_en' => 'Quneitra'],
            ['name_ar' => 'إدلب', 'name_en' => 'Idlib'],
            ['name_ar' => 'الرقة', 'name_en' => 'Raqqa'],
            ['name_ar' => 'دير الزور', 'name_en' => 'Deir ez-Zor'],
            ['name_ar' => 'الحسكة', 'name_en' => 'Hasakah'],
            ['name_ar' => 'ريف دمشق', 'name_en' => 'Rif Dimashq'],
        ];

        return response()->json(['data' => $cities]);
    }
}
