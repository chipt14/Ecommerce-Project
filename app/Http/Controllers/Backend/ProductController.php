<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Brand;
use App\Models\MultiImg;
use App\Models\Product;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function AddProduct(Request $request)
    {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        return view('backend.product.product_add', compact('categories', 'brands'));
    }

    public function StoreProduct(Request $request)
    {
        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(917, 1000)->save('upload/products/thambnail/' . $name_gen);
        $save_url = 'upload/products/thambnail/' . $name_gen;

        $product_id = Product::insertGetId([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,

            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'product_thambnail' => $save_url,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        // Multiple Image Upload Start
        $images = $request->file('multi_img');
        foreach ($images as $img) {
            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(917, 1000)->save('upload/products/multi-image/' . $make_name);
            $uploadPath = 'upload/products/multi-image/' . $make_name;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),

            ]);
        }

        // End Multiple Image Upload Start

        $notification = [
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('manage-product')->with($notification);
    }

    public function ManageProduct()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_view', compact('products'));
    }

    public function EditProduct($id)
    {
        $multiImgs = MultiImg::where('product_id', $id)->get();
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $subsubcategories = SubSubCategory::latest()->get();
        $product = Product::findOrFail($id);
        return view('backend.product.product_edit', compact('multiImgs', 'categories', 'brands', 'subcategories', 'subsubcategories', 'product'));
    }

    public function ProductDataUpdate(Request $request)
    {
        $product_id = $request->id;
        Product::findOrFail($product_id)->update([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,

            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Product Updated Without Image Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('manage-product')->with($notification);
    }

    public function MultiImageUpdate(Request $request)
    {
        $imgs = $request->multi_img;

        foreach ($imgs as $id => $img) {
            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
            Image::make($img)->resize(917, 1000)->save('upload/products/multi-image/' . $make_name);
            $uploadPath = 'upload/products/multi-image/' . $make_name;

            MultiImg::where('id', $id)->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = [
            'message' => 'Product Image Updated Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->route('manage-product')->with($notification);
    }

    public function ThambnailUpdate(Request $request)
    {
        $pro_id = $request->id;
        $oldImage = $request->old_img;
        unlink($oldImage);

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(917, 1000)->save('upload/products/thambnail/' . $name_gen);
        $save_url = 'upload/products/thambnail/' . $name_gen;

        Product::findOrFail($pro_id)->update([
            'product_thambnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Product Image Thambnail Updated Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->back()->with($notification);
    }

    public function MultiImageDelete($id)
    {
        $oldimg = MultiImg::findOrFail($id);
        unlink($oldimg->photo_name);
        MultiImg::findOrFail($id)->delete();

        $notification = [
            'message' => 'Product Image Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    public function ProductInactive($id)
    {
        Product::findOrFail($id)->update(['status' => 0]);

        $notification = [
            'message' => 'Product Inactive',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    public function ProductActive($id)
    {
        Product::findOrFail($id)->update(['status' => 1]);

        $notification = [
            'message' => 'Product Active',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    public function ProductDelete($id)
    {
        $product = Product::findOrFail($id);
        unlink($product->product_thambnail);
        Product::findOrFail($id)->delete();

        $images = MultiImg::where('product_id', $id)->get();
        foreach ($images as $img) {
            unlink($img->photo_name);
            MultiImg::where('product_id', $id)->delete();
        }

        $notification = [
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    public function ProductStock()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_stock', compact('products'));
    }
}
