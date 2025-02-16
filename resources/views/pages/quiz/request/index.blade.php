@extends('parts.main')
@section('style')
  <link rel="stylesheet" href="{{ asset('css/request.css') }}">
@endsection
@section('main')
<div class="container">
    @include('parts.header')
    <main>
        @livewire('quiz-request')
    </main>
</div>
@endsection
@section('script')

<script src="{{asset('js/request.js')}}"></script>

@endsection
