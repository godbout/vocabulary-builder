<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Word;

class FlashcardController extends Controller
{
    public function index()
    {
        $word = Word::where('mastered', 0)
            ->inRandomOrder()
            ->first();

        return view('words.flashcard' , [
            'word' => $word,
        ]);
    }
}
