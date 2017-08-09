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

        return view('words.grid', [
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
        if (Auth::check()) {
            Word::create([
                'user_id'  => Auth::id(),
                'spelling' => $request->spelling,
                'meaning'  => $request->meaning,
                'excerpt'  => $request->excerpt,
                'from'     => $request->from,
            ]);

            $request->session()->flash('alert-status', 'success');
            $request->session()->flash('alert-message', 'Your word has been recorded! You can add another one right now.');
        } else {
            $request->session()->flash('alert-status', 'warning');
            $request->session()->flash('alert-message', 'New words are not recorded in demo mode. Please register to add your own words!');
        }

        return back();
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
            return redirect('words');
        }

        return view('words.word', [
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
        $request->session()->flash('message_rest', 'mastered.');

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

    /**
     * @param Word $word
     */
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
