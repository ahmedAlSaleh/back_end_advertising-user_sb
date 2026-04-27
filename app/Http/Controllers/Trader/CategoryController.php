<?php

namespace App\Http\Controllers\Trader;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller{

    public function index()
    {
        $categories = Category::with('subCategories')->get();
        return response()->json([
            'data' => $categories
        ], 200);
    }

}
