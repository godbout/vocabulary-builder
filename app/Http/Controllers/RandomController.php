<?php

namespace App\Http\Controllers;

use App\Word;

use Illuminate\Http\Request;

class RandomController extends Controller
{
    public function index(Request $request)
    {
        $count = ($request->has('count') ? $request->input('count') : 3);

        $words = Word::all()->random($count);

        return view('words.random', [
            'words' => $words,
        ]);
    }
}