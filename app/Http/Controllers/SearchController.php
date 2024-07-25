<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggest(Request $request)
    {
        $query = $request->input('query');
        $suggestions = Blog::where('title', 'like', "%{$query}%")->limit(5)->get();

        return response()->json($suggestions);
    }
}
