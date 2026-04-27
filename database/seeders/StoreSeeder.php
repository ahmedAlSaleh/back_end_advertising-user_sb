<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // 5 متاجر حقيقية (أمثلة)
        $storesData = [
            [
                'store_name'        => 'مطعم أبو خالد',
                'image'             => null,
                'store_owner_name'  => 'أحمد خالد',
                'store_number'      => '0999990001',
            ],
            [
                'store_name'        => 'متجر الأناقة للألبسة',
                'image'             => null,
                'store_owner_name'  => 'ليث سامر',
                'store_number'      => '0999990002',
            ],
            [
                'store_name'        => 'خطوات للأحذية',
                'image'             => null,
                'store_owner_name'  => 'محمد رائد',
                'store_number'      => '0999990003',
            ],
            [
                'store_name'        => 'عطور باريس',
                'image'             => null,
                'store_owner_name'  => 'سارة نزار',
                'store_number'      => '0999990004',
            ],
            [
                'store_name'        => 'إلكترونيات المستقبل',
                'image'             => null,
                'store_owner_name'  => 'خالد جود',
                'store_number'      => '0999990005',
            ],
        ];

        // نتأكد أن هناك SubCategories متوفرة
        $allSubCategories = SubCategory::pluck('id')->toArray();

        if (empty($allSubCategories)) {
            // لو ما في سبكاتيجوريز، نطلع بدري
            return;
        }

        foreach ($storesData as $storeData) {
            // إنشاء المتجر
            $store = Store::create($storeData);

            // اختيار 2–3 سبكاتيجوريز عشوائياً لهذا المتجر
            $subCategoryIds = collect($allSubCategories)
                ->shuffle()
                ->take(3)
                ->values()
                ->all();

            // إدخال العلاقات في جدول pivot sub_categories_stores
            foreach ($subCategoryIds as $subCategoryId) {
                DB::table('sub_categories_stores')->insert([
                    'store_id'        => $store->id,
                    'sub_category_id' => $subCategoryId,
                ]);
            }
        }
    }
}
