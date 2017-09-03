@extends('layouts.messages')

@section('type', 'info')

@section('body')
    New words are not recorded in demo mode. Please <a href="{{ url('register') }}" class="alert-link">register</a> to add your own words!
@endsection
