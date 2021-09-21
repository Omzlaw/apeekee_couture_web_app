<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CategoryManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function get_categories()
    {
        try {
            $categories = CategoryManager::parents();
        } catch (\Exception $e) {
        }

        return response()->json($categories, 200);
    }

    public function get_products($id){
        return response()->json(Helpers::product_data_formatting(CategoryManager::products($id),true),200);
    }
}
