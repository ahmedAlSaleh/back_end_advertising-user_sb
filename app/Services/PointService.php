<?php

namespace App\Services;


use App\Models\Advertisement;
use App\Models\Image;
use App\Models\Post;
use App\Models\RechargeCode;
use App\Models\RechargeOperation;
use App\Models\Trader;
use App\Models\Wallet;
use App\Traits\ApiResponse;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PointService
{
    use ApiResponse;

    public function getPoint()
    {

        $rechargeCodes = RechargeCode::all();

        $uniquePointNumbers = $rechargeCodes->unique('point_number');

        return $this->success($uniquePointNumbers);
    }


    public function getWallet()
    {
        $trader = Auth::user();
        $wallet = Wallet::where('trader_id', $trader->id)->get();
        return $this->success($wallet);
    }

public function rechargePoint($request)
{
    $trader = Auth::user();
    DB::beginTransaction();
    try {
    $excode = RechargeCode::where('code',$request->code)->where('point_number',$request->point_number)->first();
    if(!$excode){
        return $this->error("This code is not for this point number", 400);
    }

    $code = RechargeCode::where('code',$request->code)->where('point_number',$request->point_number)
        ->where('is_used', false)->first();

    if(!$code){
        return $this->error("This code is already in use", 400);
    }
    $wallet = Wallet::where('trader_id' , $trader->id)->first();

    if($wallet){
        $wallet->balance +=  $code->point_number;
        $wallet->save();
    }
    else{
        Wallet::create([
            'trader_id' => $trader->id,
            'balance' => $code->point_number,
        ]);

    }
    $code->is_used = true;
    $code->save();

    RechargeOperation::create([
        "trader_id" => $trader->id,
        "code" => $code->code,
        "type" => "form_code",
        "amount" => $code->price
    ]);
        DB::commit();

        return $this->success(null, "Recharge successful.");
    }
    catch (\Exception $e) {
        // Rollback the transaction in case of any failure
        DB::rollback();
        return $this->error("Failed to recharge due to an error: " . $e->getMessage(), 500);
    }
}
}

