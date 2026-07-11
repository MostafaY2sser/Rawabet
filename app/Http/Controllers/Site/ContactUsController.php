<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;


class ContactUsController extends Controller
{
    function index(Request $request)
    {
        return view("site.contact-us");


    }
   public function store(Request $request)
{
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'nullable|email',
        'message'    => 'required|string',
    ]);
    ContactUs::create($validatedData);
    return redirect()->back()->with('success', 'Your message has been sent successfully!');
}
}
