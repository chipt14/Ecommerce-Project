<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class SliderController extends Controller
{
    public function SliderView()
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.slider_view', compact('sliders'));
    }

    public function SliderStore(Request $request)
    {
        $request->validate([
            'slider_img' => 'required',
        ], [
            'slider_img.required' => 'Plz Select One Image',
        ]);

        $image = $request->file('slider_img');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(870, 370)->save('upload/slider/' . $name_gen);
        $save_url = 'upload/slider/' . $name_gen;

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'slider_img' => $save_url,

        ]);

        $notification = [
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function SliderEdit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.slider.slider_edit', compact('slider'));
    }

    public function SliderUpdate(Request $request)
    {
        $slider_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('slider_img')) {
            unlink($old_img);
            $image = $request->file('slider_img');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(870, 370)->save('upload/slider/' . $name_gen);
            $save_url = 'upload/slider/' . $name_gen;

            Slider::findOrFail($slider_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'slider_img' => $save_url,

            ]);

            $notification = [
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'info'
            ];

            return redirect()->route('manage-slider')->with($notification);
        } else {
            Slider::findOrFail($slider_id)->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $notification = [
                'message' => 'Slider Updated Without Image Successfully',
                'alert-type' => 'info'
            ];

            return redirect()->route('manage-slider')->with($notification);
        }
    }

    public function SliderDelete($id)
    {
        $slider = Slider::findOrFail($id);
        $img = $slider->slider_img;
        unlink($img);
        Slider::findOrFail($id)->delete();

        $notification = [
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->back()->with($notification);
    }

    public function SliderInactive($id)
    {
        Slider::findOrFail($id)->update(['status' => 0]);

        $notification = [
            'message' => 'Slider Inactive Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->back()->with($notification);
    }

    public function SliderActive($id)
    {
        Slider::findOrFail($id)->update(['status' => 1]);

        $notification = [
            'message' => 'Slider Active Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->back()->with($notification);
    }
}
