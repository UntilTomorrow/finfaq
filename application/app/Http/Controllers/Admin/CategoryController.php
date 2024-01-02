<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function categories(){
        $pageTitle = 'Categories';
        $emptyMessage = 'No data found';
        $categories = Category::paginate(getPaginate());
        return view('admin.categories.log', compact('pageTitle', 'categories')); 
    }

    public function categoryStore(Request $request){
        $pageTitle = ' Create Category';
        $category = $this->rules($request);
        Category::create([
            'name' => $category['name'],
            'icon' =>$category['icon'],
            'status' =>$category['status']
        ]);
        $notify[] = ['success', 'Category create successfully'];
        return to_route('admin.category.all')->withNotify($notify);
    }

    public function categoryUpdate(Request $request, Category $category){
        $pageTitle = ' Category Update';
        $data = $this->rules($request,$category->id);
        $category->name = $data['name'];
        $category->icon = $data['icon'];
        $category->status = $data['status'];
        $category->save();
        $notify[] = ['success', 'Category create successfully'];
        return to_route('admin.category.all')->withNotify($notify);
    }

    private function rules($rules, $id=null){
        $data = $rules->validate([
            'name' =>"required|unique:categories,name,".$id,
            'icon' =>"required",
            'status' =>"required|".Rule::in(['1', '0']),
        ]);
        return $data;
    }
}
