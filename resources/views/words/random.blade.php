@extends('layouts.app')

@section('title', 'randomizer — now go write')

@section('content')

    <div class="content container suck-top">
        @forelse ($words as $word)
            <h1><a href="{{ url($word->path()) }}">{{ $word->spelling }}</a></h1>
        @empty
            @include('words._nowords')
        @endforelse
    </div>

@endsection
