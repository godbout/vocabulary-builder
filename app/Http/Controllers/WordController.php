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
        if (Auth::check() === true) {
            $query = Word::where('user_id', '=', Auth::id());
        } else {
            $query = Word::where('user_id', '=', 1);
        }

        if ($request->has('search') === true) {
            $term = $request->input('search');
            $query->where(function ($query) use ($term) {
                $query->where('spelling', 'LIKE', '%' . $term . '%')
                    ->orWhere('excerpt', 'LIKE', '%' . $term . '%');
            });
        }

        $words = $query->get();

        return view('words.index', [
            'words' => $words,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $word = Word::find($id);

        if (!$this->userCanSee($word)) {
            return response('You are not allowed to see the words of others.', 403);
        }

        return view('words.show', [
            'word' => $word,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $word = Word::find($id);

        $word->mastered = 1;
        $word->save();

        $request->session()->flash('message_word', $word->spelling);
        $request->session()->flash('message_rest', "mastered.");

        return redirect('flashcards');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function userCanSee(Word $word)
    {
        if (!Auth::check() && $word->user_id != 1) {
            return false;
        }

        if (Auth::check() && (Auth::id() != $word->user_id)) {
            return false;
        }

        return true;
    }
}
