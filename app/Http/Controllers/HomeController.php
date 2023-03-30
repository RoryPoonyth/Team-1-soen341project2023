<?php


namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $listings = Listing::where('is_active', true)
        ->with('tags')
        ->latest()
        ->get();

    $tags = Tag::orderBy('name')
        ->get();

    if ($request->has('search')){
        $query = strtolower($request->get('search'));
        $listings = $listings -> filter(function($listing)  use($query) {

            if (Str::contains(strtolower($listing->title), $query)) {
                 return true;
                }
            if (Str::contains(strtolower($listing->company), $query)) {
                return true;
            }

            if (Str::contains(strtolower($listing->location), $query)) {
                 return true;
            }

            return false;
        });
    }
        if ( $request->has('tag') ) {
            $tag = $request->get('tag');
            $listings = $listings->filter( function($listing) use($tag) {
                return $listing->tags->contains('slug', $tag);
            });
        }
    return view('listings.index', compact('listings', 'tags'));
    }
}
