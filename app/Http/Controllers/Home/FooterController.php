<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function FooterSetup()
    {
        $allfooter = Footer::find(1);
        return view('admin.footer.footer_all', compact('allfooter'));
    } //End Method

    public function UpdateFooter(Request $request)
    {
        $footer_id = $request->id;

        Footer::findOrFail($footer_id)->update([
            'number' => $request->number,
            'short_description' => $request->short_description,
            'address' => $request->address,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'github' => $request->github,
            'copyright' => $request->copyright,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Footer Updated with image Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } //End Method
}
