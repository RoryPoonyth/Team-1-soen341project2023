<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Listing;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ApplicationController extends Controller
{

    public function index(Listing $listing)
    {


        $user = Auth::user();

        if ($user->is_employer){

            $applications = Application::where('listing_id', $listing->id)
                ->with('user')
                ->latest()
                ->get();

            return view('applications.show', compact('applications', 'listing'));
        } else {

            $application = Application::where('listing_id', $listing->id)
                            ->where('user_id', $user->id)
                            ->first();

            return view('applications.show', compact('application', 'listing'));
        }
    }

    public function create(Listing $listing, Request $request)
    {
        return view('applications.create', compact('listing'));
    }


    public function store(Request $request)
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
            $user->applications()
                ->create([
                    'email' => $request->email,
                    'name' => $request->name,
                    'resume' => basename($request->file(key: 'resume')->store(path: 'public')),
                    'listing_id' => $request->input('listing_id'),
                ]);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        return view('applications.edit');
    }

    public function update(Request $request)
    {

    }

}
