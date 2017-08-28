<?php

namespace App\Http\Controllers;

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
        return view('words.create');
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

            $request->session()->flash('flash', [
                'message' => "$request->spelling recorded. You can add another word right now.",
                'type' => 'success',
            ]);
        } else {
            $request->session()->flash('flash', [
                'message' => 'New words are not recorded in demo mode. Please register to add your own words!',
                'type' => 'info',
            ]);
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

            $request->session()->flash('flash', [
                'message' => "$word->spelling mastered.",
                'type' => 'success'
            ]);
        } else {
            $request->session()->flash('flash', [
                'message' => 'Words cannot be mastered in demo mode. Please register to start recording your own words!',
                'type' => 'info',
            ]);
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

            $request->session()->flash('flash', [
                'message' => "$word->spelling deleted.",
                'type' => 'success'
                ]);
        } else {
            $request->session()->flash('flash', [
                'message' => 'Words cannot be deleted in demo mode. Please register to start recording your own words!',
                'type' => 'info',
                ]);
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
