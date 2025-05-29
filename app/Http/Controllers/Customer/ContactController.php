<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('customer.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you would typically store the contact form data
        // or send an email

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
}