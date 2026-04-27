<?php


namespace App\Services;

use App\Models\Store;
use App\Models\Trader;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\ImageTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TraderService
{
    use ImageTrait, ApiResponse;
    public function register($request)
    {
        // Begin a database transaction to ensure data consistency
        DB::beginTransaction();
        try {
            // create store
            $store = Store::create([
                'store_name' => $request->store_name,
                'store_owner_name' => $request->store_owner_name,
                'store_number' => $request->store_number,
            ]);
            if ($request->hasFile('image')) {
                $imagePath = $this->addImage($request->file('image'), 'store');
                $store->image = $imagePath;
                $store->save();
            }

            $store->subCategories()->attach($request->sub_category_ids);
            // create trader
            $trader = Trader::create([
                'owner_contact_number' => $request->owner_contact_number,
                'password' => Hash::make($request->password),
                'whatsapp_number' => $request->whatsapp_number,
                'telegram_number' => $request->telegram_number,
                'city' => $request->city,
                'social_media_link' => $request->social_media_link,
                'store_id' => $store->id,
                'store_description' => $request->store_description,
            ]);


            $token = $trader->createToken('trader')->plainTextToken;
            DB::commit();
            return $this->success([
                'trader' => $trader,
                'token' => $token,
            ], 'Successfully registered');
        } catch (\Exception $e) {
            // rollback
            DB::rollback();
            //response
            return $this->error($e->getMessage(), 500);
        }
    }

    public function login($request)
    {
        $trader = Trader::where('owner_contact_number', $request->phone)->first();
        if ($trader) {
            if (!Hash::check($request->password, $trader->password)) {
                return $this->error(__("message.Incorrect password"), 400);
            }
        } else {
            return $this->error(__("message.Incorrect phone number"), 400);
        }
        $trader = Trader::find($trader->id);
        if ($request->fcm_token)
            $trader->fcm_token = $request->fcm_token;
        $trader->save();
        $token = $trader->createToken('trader')->plainTextToken;

        return $this->success([
            'trader' => $trader,
            'token' => $token,
        ], 'Successfully logged in');
    }

    public function updateProfile($request)
    {
        $trader = $request->user();
        $store = Store::findOrFail($trader->store_id);
        $storeData = Arr::only($request->all(), [
            'store_name',
            'store_owner_name',
            'store_number',
        ]);

        if (!empty($storeData)) {
            $store->update($storeData);
        }


        // Handle image upload (optional)
        if ($request->hasFile('image')) {
            $imagePath = $this->addImage($request->file('image'), 'store');
            $store->image = $imagePath;
            $store->save();
        }

        $validated=$request->all();
        // ---- Update subcategories (pivot) ----
        if (isset($validated['sub_category_ids'])) {
            // sync will remove old relations and set these ones
            $store->subCategories()->sync($validated['sub_category_ids']);
        }

        // ---- Update trader fields ----
        $traderData = Arr::only($request->all(), [
            'owner_contact_number',
            'whatsapp_number',
            'telegram_number',
            'city',
            'social_media_link',
            'store_description',
        ]);

        // Handle password separately
        if (isset($validated['password'])) {
            $traderData['password'] = Hash::make($validated['password']);
        }

        if (!empty($traderData)) {
            $trader->update($traderData);
        }

        // Load subcategories for response if you like
        $store->load('subCategories:id,name');

        return $this->success([
            'trader'  => $trader->only([
                'id',
                'owner_contact_number',
                'whatsapp_number',
                'telegram_number',
                'social_media_link',
                'city',
            ]),
            'store'   => [
                'store_name'       => $store->store_name,
                'store_owner_name' => $store->store_owner_name,
                'store_number'     => $store->store_number,
                'image'            => $store->image,
                'sub_categories'   => $store->subCategories->map(function ($subCat) {
                    return [
                        'id'   => $subCat->id,
                        'name' => $subCat->name ?? null,
                    ];
                }),
            ],
        ], 'Profile updated successfully.');
    }

    public function changePassword($request)
    {
        $user = $request->user();
        $data = $request->all();
        if ($user->password && !Hash::check($data['old_password'], $user->password)) {
            return $this->error('Old password invalid.', 422);
        }

        $password = Hash::make($data['password']);
        $user->password = $password;
        $user->save();

        return $this->success($user, 'Your password changed successfully');
    }
}
