@section('head')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
<div id="completedState" class="state-container">
    <div class="success-wrapper">
        <div class="success-animation">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
            </svg>
        </div>
        <div class="success-text">
            <h2>Test tayyor!</h2>
            <p>Testingiz muvaffaqiyatli yaratildi</p>
        </div>
        <div class="action-buttons">
            <a href="{{route('quiz.pdf',$quizRequestModel->uuid)}}" id="downloadBtn" class="primary-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                <span>PDF yuklab olish</span>
            </a>
            <a href="{{route('quiz.word',$quizRequestModel->uuid)}}" class="primary-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <line x1="10" y1="9" x2="8" y2="9" />
                </svg>
                <span>Word yuklab olish</span>
            </a>
            <button onclick="copyToClipboard('{{route('quiz.completed',$quizRequestModel->uuid)}}')"
                class="primary-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1" />
                </svg>
                <span>Havolani nusxalash</span>
            </button>
            <a href="{{route('main')}}" id="newTestFailedBtn" class="secondary-btn">
                Yangi test yaratish
            </a>
        </div>
    </div>
</div>


@section('script')
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
