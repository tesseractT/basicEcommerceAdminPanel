<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Carbon;

class ContactController extends Controller
{
    public function Contact()
    {
        return view('frontend.contact');
    } //end method

    public function StoreMessage(Request $request)
    {
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'budget' => $request->budget,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);
        $notification = array(
            'message' => ' Message Submitted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } //End Method

    public function ContactMessage()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contact.all_contact', compact('contacts'));
    } //End Method

    public function DeleteMessage($id)
    {

        Contact::findOrFail($id)->delete();
        $notification = array(
            'message' => ' Message Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } //End Method
}
