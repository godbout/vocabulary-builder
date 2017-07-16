@extends('layouts/main')

@section('title', 'randomizer — now go write')

@section('content')
    @foreach ($words as $word)
        <h1><a href="{{ url('/words', [$word->id]) }}">{{ $word->spelling }}</a></h1>
    @endforeach
@endsection