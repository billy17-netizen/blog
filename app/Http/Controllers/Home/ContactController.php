<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ContactController extends Controller
{
    public function Contact()
    {
        $contact = Contact::all();
        return view('frontend.contact', compact('contact'));
    }

    public function storeMessage(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
            'subject' => 'required',
            'phone' => 'required',
        ],[
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email',
            'message.required' => 'Please enter your message',
            'subject.required' => 'Please enter your subject',
            'phone.required' => 'Please enter your phone',
        ]);

        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Your Message Sent Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function contactMessage()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contact.allContact', compact('contacts'));
    }

    public function deleteMessage($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        $notification = array(
            'message' => 'Message Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
