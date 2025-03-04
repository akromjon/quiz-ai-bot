@extends('parts.main')
@section('head')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

@endsection
@section('main')
<div class="container">
    <header>
        <h1>Testlar Ro'yxati</h1>
        <p>Yaratilgan barcha testlar</p>
    </header>

    <main>
        <div class="quiz-list">
            @foreach ($quiz_requests as $quiz)
            <div class="quiz-card">
                <div class="quiz-header">
                    <h3 class="quiz-title">{{str($quiz->text)->words(3)}}</h3>
                    <span class="quiz-date">{{$quiz->created_at->format('d.m.y H:i')}}</span>
                </div>

                <div class="quiz-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M9 11l3 3L22 4"></path>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                        </div>
                        <span class="stat-value">{{$quiz->number_of_generated_question}}</span>
                        <span class="stat-label">Savollar</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <span class="stat-value">{{$quiz->language}}</span>
                        <span class="stat-label">Til</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                                </path>
                            </svg>
                        </div>
                        <span class="stat-value">
                            @switch($quiz->difficulty->value)
                            @case('Beginner')
                            Boshlang'ich
                            @break
                            @case('Intermediate')
                            O'rtacha
                            @break
                            @case('Advanced')
                            Murakkab
                            @break
                            @case('Expert')
                            Ekspert
                            @break
                            @default
                            @endswitch
                        </span>
                        <span class="stat-label">Daraja</span>
                    </div>
                </div>

                <div class="quiz-actions">
                    <a href="{{route('quiz.completed',$quiz->uuid)}}" class="action-btn primary-action">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <span>Ko'rish</span>
                    </a>
                    <a href="{{route('quiz.pdf',$quiz->uuid)}}" href="" class="action-btn pdf-action"
                        onclick="downloadPDF()">
                        <span>PDF</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </a>
                    <a href="{{route('quiz.word',$quiz->uuid)}}" class="action-btn word-action"
                        onclick="downloadWord()">
                        <span>Word</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </a>
                    <button onclick="copyToClipboard('{{route('quiz.completed',$quiz->uuid)}}')"
                        class="action-btn link-action" onclick="copyLink()">
                        <span>Havola</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @if ($quiz_requests->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($quiz_requests->onFirstPage())
            <span class="disabled prev-next">&laquo; Oldingi</span>
        @else
            <a href="{{ $quiz_requests->previousPageUrl() }}" class="prev-next" rel="prev">&laquo; Oldingi</a>
        @endif

        {{-- First Page Link --}}
        @if($quiz_requests->currentPage() > 3)
            <a href="{{ $quiz_requests->url(1) }}">1</a>
            @if($quiz_requests->currentPage() > 4)
                <span>...</span>
            @endif
        @endif

        {{-- Pagination Elements --}}
        @foreach (range(max(1, $quiz_requests->currentPage() - 2), min($quiz_requests->lastPage(), $quiz_requests->currentPage() + 2)) as $page)
            @if ($page == $quiz_requests->currentPage())
                <span class="active">{{ $page }}</span>
            @else
                <a href="{{ $quiz_requests->url($page) }}">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Last Page Link --}}
        @if($quiz_requests->currentPage() < $quiz_requests->lastPage() - 2)
            @if($quiz_requests->currentPage() < $quiz_requests->lastPage() - 3)
                <span>...</span>
            @endif
            <a href="{{ $quiz_requests->url($quiz_requests->lastPage()) }}">{{ $quiz_requests->lastPage() }}</a>
        @endif

        {{-- Next Page Link --}}
        @if ($quiz_requests->hasMorePages())
            <a href="{{ $quiz_requests->nextPageUrl() }}" class="prev-next" rel="next">Keyingi &raquo;</a>
        @else
            <span class="disabled prev-next">Keyingi &raquo;</span>
        @endif
    </div>
@endif
    </main>
</div>
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
