<div id="failedState" class="state-container">
    <div class="failed-wrapper">
        <div class="failed-animation">
            <svg class="exclamation" viewBox="0 0 24 24" width="72" height="72">
                <circle class="exclamation__circle" cx="12" cy="12" r="11" fill="none" />
                <path class="exclamation__mark" fill="none" d="M12 7v6 M12 17v0.5" />
            </svg>
        </div>
        <div class="failed-text">
            <h2>Xatolik yuz berdi</h2>
            <p>Test yaratishda muammo yuzaga keldi</p>
        </div>
        <div class="action-buttons">
            <a href="{{route('main')}}" id="retryBtn" class="primary-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12a9 9 0 0 1 9-9 9 9 0 0 1 6.9 3.2L22 9" />
                    <path d="M21 3v6h-6" />
                </svg>
                <span>Qayta urinish</span>
            </a>

        </div>
    </div>
</div>
