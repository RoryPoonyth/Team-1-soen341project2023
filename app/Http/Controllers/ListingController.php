<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Application;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ListingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if($user->is_employer){
            $listings = Listing::where('user_id', $user->id)
                ->where('is_active', true)
                ->with('tags')
                ->latest()
                ->get();

            return view('dashboard', compact('listings', 'user'));
        }else{

            $listings = Application::where('user_id', $user->id)
                    ->pluck('listing_id')
                    ->toArray();

            $listings = Listing::whereIn('id', $listings)
                ->with('applications')
                ->get();

            $applications = Application::where('user_id', $user->id)->get();



            return view('dashboard', compact('listings', 'user', 'applications'));
        }
    }


    public function show(Listing $listing, Request $request)
    {

        $user = Auth::user();

        if (!$user || !$user->is_employer){
            return view('applications.show', compact('listing'));
        }else{
            return view('listings.show', compact('listing'));
        }
    }

    
    public function apply(Listing $listing, Request $request)
    {
        $listing->clicks()
            ->create([
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]);

        return redirect()->to($listing->apply_link);
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        // process the listing creation form
        $validationArray = [
            'title' => 'required',
            'company' => 'required',
            'logo' => 'file|max:2048',
            'location' => 'required',
            'apply_link' => 'required|url',
            'content' => 'required',
            'payment_method_id' => 'required'
        ];

        if (!Auth::check()) {
            $validationArray = array_merge($validationArray, [
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:5',
                'name' => 'required'
            ]);
        }

        $request->validate($validationArray);

        // is a user signed in? if not, create one and authenticate
        $user = Auth::user();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user->createAsStripeCustomer();

            Auth::login($user);
        }

        // process the payment and create the listing
        try {
            $amount = 9900; // $99.00 USD in cents
            if ($request->filled('is_highlighted')) {
                $amount += 1900;
            }

            $user->charge($amount, $request->payment_method_id);

            $md = new \ParsedownExtra();

            $listing = $user->listings()
                ->create([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title) . '-' . rand(1111, 9999),
                    'company' => $request->company,
                    'logo' => basename($request->file('logo')->store('public')),
                    'location' => $request->location,
                    'apply_link' => $request->apply_link,
                    'content' => $md->text($request->input('content')),
                    'is_highlighted' => $request->filled('is_highlighted'),
                    'is_active' => true
                ]);

            foreach(explode(',', $request->tags) as $requestTag) {
                $tag = Tag::firstOrCreate([
                    'slug' => Str::slug(trim($requestTag))
                ], [
                    'name' => ucwords(trim($requestTag))
                ]);

                $tag->listing()->attach($listing->id);
            }

            return redirect()->route('dashboard');
        } catch(\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
    }

