<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required',
            'subject'       => 'required',
            'message'       => 'required',
        ], [
            'mobile_number.required' => 'Mobile Number is Empty!',
            'subject.required'       => ' Subject is Empty!',
            'message.required'       => 'Message is Empty!',

        ]);
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->mobile_number = $request->mobile_number;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        return response()->json(['success' => 'Your Message Send Successfully']);

    }
    public function list() {
        $contacts = Contact::latest()->paginate(10);
        return view('admin-views.contacts.list', compact('contacts'));

    }
    public function view($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin-views.contacts.view', compact('contact'));
    }
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        $contact->feedback = $request->feedback;
        $contact->seen = 1;
        $contact->update();
        Toastr::success('Feedback  Update successfully!');
        return redirect()->route('admin.contact.list');
    }
    public function destroy(Request $request)
    {
        $contact = Contact::find($request->id);
        $contact->delete();

        return response()->json();
    }

}
