@extends('layouts/main')

@section('title', 'the word — take good care of it')

@section('content')
    <div class="main-word m-b-md text-center">
        <p>{{ $word->spelling }}</p>
    </div>
    <p class="meaning m-b-hg">{{ $word->meaning }}</p>
    <blockquote class="excerpt m-b-lg">
        <p>{!! preg_replace("#$word->spelling(\w*)#", "<strong>$0</strong>", $word->excerpt) !!}</p>
    </blockquote>
    <p class="from">
        {{ $word->from }}
    </p>
@endsection