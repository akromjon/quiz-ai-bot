@extends('parts.main')
@section('head')
<link rel="stylesheet" href="{{ asset('css/completed.css') }}">
<link href="https://cdn.tailwindcss.com/3.4.1" rel="stylesheet">
@endsection
@section('main')
    @livewire('quiz-completed',['uuid'=>$uuid])
@endsection

