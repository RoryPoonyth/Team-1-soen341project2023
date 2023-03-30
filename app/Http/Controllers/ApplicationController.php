<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ApplicationController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        // process application form
        $applyArray = [
            'email' => 'required',
            'name' => 'required',
            'resume' => 'file|max:2048'
        ];

        $application = user->applications()
            ->create([
                'email' => $request->email,
                'name' => $request->name,
                'resume' => basename($request->file(key: 'resume')->store(path: 'public'))
            ]);

        return redirect()->route('dashboard');
    }

    public function create(Listing $listing, Request $request)
    {
        return view('applications.create', compact('listing'));
    }
}