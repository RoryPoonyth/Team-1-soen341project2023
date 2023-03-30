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
        $validationArray = [
            'email' => 'required|email',
            'name' => 'required',
            'resume' => 'file|max:2048'
        ];

        $request->validate($validationArray);

        $user = Auth::user();

        if (!$user){
            $user = User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password' => Hash::make($request->password)
            ]);
        }

        Auth::login($user);
        try{
            $user->applications() //Need application model
                ->create([
                    'email' => $request->email,
                    'name' => $request->name,
                    'resume' => basename($request->file(key: 'resume')->store(path: 'public'))
                ]);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create(Listing $listing, Request $request)
    {
        return view('applications.create', compact('listing'));
    }
}
