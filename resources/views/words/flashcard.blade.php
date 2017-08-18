@extends('layouts.app')

@section('title', 'flashcards — train!')

@section('content')

    <div class="content container">
        @if($word)
            <div class="main-word m-b-md text-center">
                <span>{{ $word->spelling }}</span>
            </div>

            <div class="row">
                <div class="col-12-md">
                    <!-- Button trigger modal -->
                    <button id="usageModalButton" type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#usageModal">
                      Show Usage
                    </button>
                    <!-- Button trigger modal -->
                    <button id="definitionModalButton" type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#definitionModal">
                      Show Definition
                    </button>

                    {!! Form::open(['url' => 'words/' .$word->id, 'method' => 'patch', 'style' => 'display: inline;']) !!}
                        <button type="submit" class="btn btn-success btn-lg">Mark as Mastered</button>
                    {!! Form::close() !!}
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="usageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="usageModal">Usage of {{ $word->spelling }}</h4>
                        </div>
                        <div class="modal-body">
                            <blockquote class="excerpt">
                                <p>{!! preg_replace("#$word->spelling(\w*)#", "<strong>$0</strong>", $word->excerpt) !!}</p>
                            </blockquote>
                            <p class="from">
                                {{ $word->from }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="definitionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="definitionModal">Definition of {{ $word->spelling }}</h4>
                        </div>
                        <div class="modal-body meaning">
                            {{ $word->meaning }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            @include('words._nowords')
        @endif
    </div>
@endsection
