@extends('parts.main')
@section('style')
<link rel="stylesheet" href="{{ asset('css/processing.css') }}">
@endsection
@section('main')
    @livewire('quiz-processing',['uuid'=>$uuid])
@endsection
@section('script')
<script src="{{asset('js/processing.js')}}"></script>
@endsection
