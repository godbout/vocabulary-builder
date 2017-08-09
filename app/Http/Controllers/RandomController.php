<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Http\Request;

class RandomController extends Controller
{
    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $count = ($request->has('count') ? (int) $request->input('count') : 3);

        if ($count < 0) {
            $count = 0;
        }

        if (auth()->check() === true) {
            $query = Word::where('user_id', '=', auth()->id());
        } else {
            $query = Word::where('user_id', '=', 1);
        }

        $words = $query->get();

        if (count($words) !== 0 && $count !== 0 && count($words) >= $count) {
            $words = $words->random($count);
        }

        return view('words.random', [
            'words' => $words,
        ]);
    }
}
