<?php

namespace App\Http\Controllers;
use App\Models\Listing;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Listing $listing)
    {
        return view('applications.create', compact('listing'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Listing $listing)
    {
        // process the application creation form 
        $validationArray = [
            'name' => 'required', 
            'email' => 'required|email', 
            'phone' => ['required', 'regex:/^\d{10}$/'], 
            'resume' => 'required|file|max:2048'
        ];

        $request->validate($validationArray);

        $user = Auth::user();

        if (!$user){
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user->createAsStripeCustomer();

            Auth::login($user);  
        }

        try{
        $md = new \ParsedownExtra();

        $application = $user->applications()
            ->create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'resume' => basename($request->file('resume')->store('public')),
                'content' => $md->text($request->input('cover_letter')),
            ]);

        return redirect()->route('dashboard');
    } catch(\Exception $e) {
        return redirect()->back()
            ->withErrors(['error' => $e->getMessage()]);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
