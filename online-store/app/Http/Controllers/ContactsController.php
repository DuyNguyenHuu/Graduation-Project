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
}