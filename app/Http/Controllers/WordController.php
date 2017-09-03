<?php

namespace App\Http\Controllers;

use App\User;
use App\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('words.grid', [
            'words' => $this->getWords(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastWord = Word::orderBy('id', 'desc')->first();

        return view('words.create', [
            'lastFrom' => $lastWord->from ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'spelling' => 'required',
            'meaning' => 'required',
        ]);

        if (auth()->check()) {
            auth()->user()->addWord($request->toArray());

            $request->session()->flash('message_partial', 'messages.added');
            $request->session()->flash('message_data', ['spelling' => $request->spelling]);
        } else {
            $request->session()->flash('message_partial', 'messages.added_demo');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Word  $word
     * @return \Illuminate\Http\Response
     */
    public function show(Word $word)
    {
        if (auth()->check()) {
            $this->authorize('handle', $word);
        }

        return view('words.word', [
            'word' => $word,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Word $word, Request $request)
    {
        if (auth()->check()) {
            $this->authorize('handle', $word);

            $this->master($word);

            $request->session()->flash('message_partial', 'messages.mastered');
            $request->session()->flash('message_data', ['spelling' => $word->spelling]);
        } else {
            $request->session()->flash('message_partial', 'messages.mastered_demo');
        }

        return redirect('flashcards');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Word $word, Request $request)
    {
        if (auth()->check()) {
            $this->authorize('handle', $word);

            $word->delete();

            $request->session()->flash('message_partial', 'messages.deleted');
            $request->session()->flash('message_data', ['spelling' => $word->spelling]);
        } else {
            $request->session()->flash('message_partial', 'messages.deleted_demo');
        }

        return redirect('words');
    }

    protected function master(Word $word)
    {
        $word->master();
    }

    protected function getWords()
    {
        /**
         * Global scopes handle whether the user is guest or auth
         * and whether a search term is used
         */
        return Word::all();
    }
}
