@extends('layouts.app')

@section('title', 'grid — more words for you')

@section('content')

<div class="content container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Record New Word</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/words') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="spelling" class="col-md-4 control-label">Spelling</label>

                            <div class="col-md-6">
                                <input id="spelling" type="text" class="form-control" name="spelling" value="{{ old('spelling') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="meaning" class="col-md-4 control-label">Meaning</label>

                            <div class="col-md-6">
                                <textarea id="meaning" class="form-control" name="meaning" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="excerpt" class="col-md-4 control-label">Excerpt</label>

                            <div class="col-md-6">
                                <textarea id="excerpt" class="form-control" name="excerpt" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="from" class="col-md-4 control-label">From</label>

                            <div class="col-md-6">
                                <input id="from" type="text" class="form-control" name="from">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
