@extends('layouts/main')

@section('title', 'randomizer — now go write')

@section('content')

    <div class="content container">
        @forelse ($words as $word)
            <h1><a href="{{ url('/words', [$word->id]) }}">{{ $word->spelling }}</a></h1>
        @empty
            @include('words._nowords')
        @endforelse
    </div>

@endsection