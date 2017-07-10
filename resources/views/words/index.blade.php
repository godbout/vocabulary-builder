@extends('layouts.main')

@section('title', 'grid — more words for you')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($words as $word)
                <div class="col-md-3"><h1><a @if($word->mastered == true) class="text-success" @endif href="{{ url('/words', [$word->id]) }}">{{ $word->spelling }}</a></h1></div>
            @endforeach
        </div>
    </div>
@endsection
