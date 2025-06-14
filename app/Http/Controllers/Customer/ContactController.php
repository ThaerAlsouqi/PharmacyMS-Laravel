<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('customer.contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            // You can either send email or store in database
            // For now, let's store in a simple way or just return success
            
            // Option 1: Send email (you'll need to configure mail settings)
            // Mail::to('admin@medifind.com')->send(new ContactMessage($request->all()));
            
            // Option 2: Store in database (you can create a contacts table)
            // Contact::create($request->all());
            
            return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry, there was an error sending your message. Please try again.');
        }
    }
}