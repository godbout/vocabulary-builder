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
        $this->validate($request, [
            'spelling' => 'required',
            'meaning' => 'required',
        ]);

        if (Auth::check()) {
            Word::create([
                'user_id'  => Auth::id(),
                'spelling' => $request->spelling,
                'meaning'  => $request->meaning,
                'excerpt'  => $request->excerpt,
                'from'     => $request->from,
            ]);

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
        if (Auth::check()) {
            $this->authorize('handle', $word);
        } elseif ($word->user_id != 1) {
            abort(403, 'You do not have the permission to view the words of others.');
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
    public function update(Word $word, Request $request)
    {
        if (Auth::check()) {
            $this->authorize('handle', $word);

            $word->mastered = 1;
            $word->save();

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
        if (Auth::check()) {
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
}
