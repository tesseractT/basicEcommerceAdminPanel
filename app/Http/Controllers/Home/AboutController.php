<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;


class AboutController extends Controller
{
    //
    public function AboutPage()
    {
        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all', compact('aboutpage'));
    } // End Method

    public function UpdateAbout(Request $request)
    {
        $about_id = $request->id;

        if ($request->file('about_image')) {

            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(523, 605)->save('uploads/home_about_images/' . $name_gen);

            $save_url = 'uploads/home_about_images/' . $name_gen;


            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'About Page Updated with image Successfully',
                'alert-type' => 'success',
            );

            return redirect()->back()->with($notification);
        } else {
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
            ]);

            $notification = array(
                'message' => 'About Page Updated without image Successfully',
                'alert-type' => 'success',
            );

            return redirect()->back()->with($notification);
        } // End Else
    }//End Method

    public function HomeAbout(){
        $aboutpage = About::find(1);

        return view('frontend.about_page', compact('aboutpage'));
    }
}
