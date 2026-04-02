<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{
    public function index(){
        return view('content.contacts');
    }
    public function sendMessage(Request $request){
        $data = $request->all();
        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->send(new ContactMail($data));
        return back()->with('success', 'Your message has been sent successfully');
    }

    public function upload(Request $request){
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $urls = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {

                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                $file->move(public_path('images'), $filename);

                $urls[] = asset('images/' . $filename);
            }
        }

        return response()->json([
            'images' => $urls
        ]);
    }
}