<div class="container analyzing-container">
    <div class="loader-content">
        <div class="progress-container">
            <div class="progress-circle">
                <div class="progress-value">{{ $counter }}/{{ $quizRequestModel->number_of_question }}</div>
                <div class="progress-label">Savollar</div>
            </div>
            <svg class="progress-ring" width="160" height="160">
                <circle class="progress-ring-bg" cx="80" cy="80" r="70" />
                <circle class="progress-ring-circle" cx="80" cy="80" r="70" />
            </svg>
        </div>
        <div class="loader-text">
            <h2>Quizlar yaratilmoqda</h2>
            <p class="status-text">
                @if ($progress <= 30)
                    Matn tahlil qilinmoqda...
                @elseif ($progress <= 60)
                    Savollar shakllantirilmoqda...
                @elseif ($progress <= 90)
                    Test yakunlanmoqda...
                @else
                    Tayyor!
                @endif
            </p>
        </div>
    </div>
</div>
