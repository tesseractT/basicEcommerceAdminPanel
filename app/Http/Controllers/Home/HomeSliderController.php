<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlide;
use Intervention\Image\ImageManagerStatic as Image;

class HomeSliderController extends Controller
{
    //
    public function HomeSlider()
    {

        $homeslide = HomeSlide::find(1);
        return view('admin.home_slide.home_slide_all', compact('homeslide'));
    } // End Method

    public function UpdateSlider(Request $request)
    {

        $slider_id = $request->id;

        if ($request->file('home_slide_image')) {

            $image = $request->file('home_slide_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(636, 852)->save('uploads/home_slide_images/' . $name_gen);

            $save_url = 'uploads/home_slide_images/' . $name_gen;


            HomeSlide::findOrFail($slider_id)->update([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'home_slide_image' => $save_url,
                'video_url' => $request->video_url,
            ]);

            $notification = array(
                'message' => 'Home Slide Updated with image Successfully',
                'alert-type' => 'success',
            );

            return redirect()->back()->with($notification);
        } else {
            HomeSlide::findOrFail($slider_id)->update([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'video_url' => $request->video_url,
            ]);

            $notification = array(
                'message' => 'Home Slide Updated without image Successfully',
                'alert-type' => 'success',
            );

            return redirect()->back()->with($notification);
        } // End Else

    } // End method
}
