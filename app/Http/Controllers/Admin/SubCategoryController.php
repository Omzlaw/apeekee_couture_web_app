<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories=Category::where(['position'=>1])->paginate(10);
        return view('admin-views.category.sub-category-view',compact('categories'));
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
//        $category->icon = $request->name;
        $category->parent_id = $request->parent_id;
        $category->position = 1;
        $category->save();
        return response()->json();
    }

    public function edit(Request $request)
    {
        $data = Category::where('id', $request->id)->first();

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->parent_id = $request->parent_id;
        $category->position = 1;
        $category->save();
        return response()->json();
    }

    public function delete(Request $request)
    {
        $categories = Category::where('parent_id', $request->id)->get();
        if (!empty($categories)) {

            foreach ($categories as $category) {
                Category::destroy($category->id);
            }
        }
        Category::destroy($request->id);
        return response()->json();
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::where('position', 1)->orderBy('id', 'desc')->get();
            return response()->json($data);
        }
    }
}
