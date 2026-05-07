<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactQuery::create($request->all());

        return redirect()->back()->with('success', 'Your query has been submitted. We will get back to you soon!');
    }
}
