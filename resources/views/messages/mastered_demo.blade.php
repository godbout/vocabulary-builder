@extends('layouts.messages')

@section('type', 'info')

@section('body')
    Words cannot be mastered in demo mode. Please <a href="{{ url('register') }}" class="alert-link">register</a> to start recording your own words!
@endsection
