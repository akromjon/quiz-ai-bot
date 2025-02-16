@extends('parts.main')
@section('style')
<link rel="stylesheet" href="{{ asset('css/completed.css') }}">
@endsection
@section('main')
    @livewire('quiz-completed',['uuid'=>$uuid])
@endsection

