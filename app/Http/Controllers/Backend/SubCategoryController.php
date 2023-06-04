<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function SubCategoryView()
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $subcategories = SubCategory::latest()->get();
        return view('backend.category.subcategory_view', compact('subcategories', 'categories'));
    }

    public function SubCategoryStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required',
        ], [
            'category_id.required' => 'Please select Any Option',
            'subcategory_name.required' => 'Input SubCategory English Name',

        ]);

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),

        ]);

        $notification = [
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function SubCategoryEdit($id)
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $subcategory = SubCategory::findOrFail($id);
        return view('backend.category.subcategory_edit', compact('subcategory', 'categories'));
    }

    public function SubCategoryUpdate(Request $request)
    {
        $subcat_id = $request->id;
        SubCategory::findOrFail($subcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = [
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->route('all.subcategory')->with($notification);
    }

    public function SubCategoryDelete($id)
    {
        SubCategory::findOrFail($id)->delete();
        $notification = [
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->back()->with($notification);
    }

    // --------------That For Sub->SubCategory------------------

    public function SubSubCategoryView()
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $subsubcategories = SubSubCategory::latest()->get();
        return view('backend.category.sub_subcategory_view', compact('subsubcategories', 'categories'));
    }

    public function GetSubCategoryView($category_id)
    {
        $subcat = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name', 'ASC')->get();
        return json_encode($subcat);
    }

    public function SubSubCategoryStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'subsubcategory_name' => 'required',
        ], [
            'category_id.required' => 'Please select Any Option',
            'subsubcategory_name.required' => 'Input SubSubCategory English Name',

        ]);

        SubSubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name' => $request->subsubcategory_name,
            'subsubcategory_slug' => strtolower(str_replace(' ', '-', $request->subsubcategory_name)),

        ]);

        $notification = [
            'message' => 'SubSubCategory Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function SubSubCategoryEdit($id)
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $subcategories = SubCategory::orderBy('subcategory_name', 'ASC')->get();
        $subsubcategory = SubSubCategory::findOrFail($id);
        return view('backend.category.sub_subcategory_edit', compact('subsubcategory', 'subcategories', 'categories'));
    }

    public function SubSubCategoryUpdate(Request $request)
    {
        $subsubcat_id = $request->id;
        SubSubCategory::findOrFail($subsubcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name' => $request->subsubcategory_name,
            'subsubcategory_slug' => strtolower(str_replace(' ', '-', $request->subsubcategory_name)),
        ]);

        $notification = [
            'message' => 'SubSubCategory Updated Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->route('all.subsubcategory')->with($notification);
    }

    public function SubSubCategoryDelete($id)
    {
        SubSubCategory::findOrFail($id)->delete();
        $notification = [
            'message' => 'SubSubCategory Deleted Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->back()->with($notification);
    }
}
