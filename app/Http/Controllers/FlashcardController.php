<?php

namespace App\Http\Controllers;

use App\Word;

class FlashcardController extends Controller
{
    public function index()
    {
        if (auth()->check() === true) {
            $query = Word::where('user_id', '=', auth()->id());
        } else {
            $query = Word::where('user_id', '=', 1);
        }

        $word = $query->where('mastered', 0)
            ->inRandomOrder()
            ->first();

        return view('words.flashcard', [
            'word' => $word,
        ]);
    }
}
