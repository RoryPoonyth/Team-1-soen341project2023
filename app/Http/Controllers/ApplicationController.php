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
    public function storeApplication(Request $request)
    {
        // process application form
        $applyArray = [
            'email' => 'required',
            'name' => 'required',
            'resume' => 'file|max:2048'
        ];

        $listing = user->listings()
            ->apply([
                'email' => $request->email,
                'name' => $request->name,
                'resume' => basename($request->file(key: 'resume')->storeApplication(path: 'public'))
            ]);
    }
}