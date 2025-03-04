@extends('parts.main')
@section('head')
<link rel="stylesheet" href="{{ asset('css/processing.css') }}">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

@endsection
@section('main')
    @livewire('quiz-processing',['uuid'=>$uuid])
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function copyToClipboard(url) {
            navigator.clipboard.writeText(url).then(() => {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: 'Havola nusxalandi!',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            }).catch(err => {
                Swal.fire({
                    toast: true,
                    icon: 'error',
                    title: 'Nusxalashda xatolik!',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                console.error('Nusxalashda xatolik:', err);
            });
        }
    </script>
@endsection
