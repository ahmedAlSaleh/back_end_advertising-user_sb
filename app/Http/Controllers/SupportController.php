<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => [
                'text' => 'شكراً لاستخدامك تطبيق أعلاني
مطور ومصمم تطبيقات متخصص في بناء حلول تقنية مخصصة ومشاريع رقمية. إذا كان لديك فكرة مشروع أو تبحث عن تطوير تطبيق احترافي، يسعدني التواصل معك.',
                'social' => [
                    'telegram' => ['link' => 'https://t.me/Ahmedasml', 'image' => ''],
                    'youtube' => ['link' => 'https://www.youtube.com/@Ahmed-AlSaleh', 'image' => ''],
                    'linkedin' => ['link' => 'https://www.linkedin.com/in/ahmed-al-saleh-0424ba208/', 'image' => '']
                ]
            ]
        ]);
    }
}
