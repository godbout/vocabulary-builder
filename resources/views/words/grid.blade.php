@extends('layouts.app')

@section('title', 'grid — more words for you')

@section('content')
    <div class="container suck-top">
        <div class="row">
            @forelse ($words as $word)
                <div class="col-md-3 col-sm-4">
                    <h1>
                        <a @if($word->mastered == true) class="text-success" @endif href="{{ url($word->path()) }}">{{ $word->spelling }}</a>
                    </h1>
                </div>
            @empty
                @include('words._nowords')
            @endforelse
        </div>
    </div>
@endsection
