<?php

namespace App\Filament\Resources\RechargeCodeResource\Pages;

use App\Filament\Resources\RechargeCodeResource;
use Filament\Actions;
use App\Models\RechargeCode;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class CreateRechargeCode extends CreateRecord
{
    protected static string $resource = RechargeCodeResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        DB::beginTransaction();
        try {
            $point_number = $data['point_number'];
            $amount = $data['price'];
            $qrNumber = $data['Qr_number'];
            for ($i = 0; $i < $qrNumber; $i++) {
                do {
                    $uniqueContent = uniqid(rand(), true);
                    $hashedCode = substr(md5($uniqueContent), 0, 8);
                    $exists = RechargeCode::where('code', $hashedCode)->exists();
                } while ($exists);
                $rechargeCode = new RechargeCode();
                $rechargeCode->code = $hashedCode;
                $rechargeCode->price = $amount;
                $rechargeCode->point_number = $point_number;
             //   $image = QrCode::size(200)->format('png')->generate($rechargeCode->code);
              //  $rechargeCode->image = base64_encode($image);
                $rechargeCode->save();
            }
            // Commit the transaction
            DB::commit();
            return $rechargeCode;
        } catch (\Exception $e) {
            // Rollback transaction if something goes wrong
            DB::rollBack();
            throw $e;
        } 
    }

}
