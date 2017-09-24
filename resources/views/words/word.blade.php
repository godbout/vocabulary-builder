@extends('layouts.app')

@section('title', 'the word — take good care of it')

@section('content')

<div class="content container">

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

    <div class="row">
        <div class="pull-right" style="padding-top:70px;">
            <form method="POST" action="{{ $word->path() }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
            </form>
        </div>
    </div>

</div>

@endsection
