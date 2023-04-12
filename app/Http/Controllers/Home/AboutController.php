<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\MultiImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
    } //End Method

    public function HomeAbout()
    {
        $aboutpage = About::find(1);

        return view('frontend.about_page', compact('aboutpage'));
    } //End Method

    public function AboutMultiImage()
    {
        return view('admin.about_page.about_multi_image');
    } //End Method

    public function StoreMultiImage(Request $request)
    {

        $image = $request->file('multi_image_uploads');

        foreach ($image as $multi_image_uploads) {

            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()) . '.' . $multi_image_uploads->getClientOriginalExtension();

            Image::make($multi_image_uploads)->resize(220, 220)->save('uploads/multi/' . $name_gen);

            $save_url = 'uploads/multi/' . $name_gen;


            MultiImageUpload::insert([

                'multi_image_uploads' => $save_url,
                'created_at' => Carbon::now()
            ]);
        } // End For Each

        $notification = array(
            'message' => 'Images Uploaded Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('all.multi.image')->with($notification);
    } //End Method

    public function AllMultiImage()
    {
        $allMultiImage = MultiImageUpload::all();

        return view('admin.about_page.all_multiimage', compact('allMultiImage'));
    } //End Method

    public function EditMultiImage($id)
    {
        $multiImage = MultiImageUpload::findOrFail($id);
        return view('admin.about_page.edit_multiimage', compact('multiImage'));
    } //End Method

    public function UpdateMultiImage(Request $request)
    {
        $multi_image_id = $request->id;

        if ($request->file('multi_image_uploads')) {

            $image = $request->file('multi_image_uploads');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(220, 220)->save('uploads/multi/' . $name_gen);

            $save_url = 'uploads/multi/' . $name_gen;


            MultiImageUpload::findOrFail($multi_image_id)->update([

                'multi_image_uploads' => $save_url,
                'updated_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Image Updated Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('all.multi.image')->with($notification);
        } else {
            $notification = array(
                'message' => 'Image Update Failed',
                'alert-type' => 'fail',
            );
        }
    } //End Method

    public function DeleteMultiImage($id)
    {
        $multi = MultiImageUpload::findOrFail($id);
        $img = $multi->multi_image_uploads;

        unlink($img);

        MultiImageUpload::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Image Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } //End Method
}
