<div>
    <form id="quizForm" wire:submit="submit">
        <div class="input-group">
            <label for="userText">Matn kiriting</label>
            <textarea minlength="3" wire:model="text" id="userText" placeholder="Matningizni bu yerga joylashtiring va biz uni testga aylantiramiz..."
                rows="8" required></textarea>
        </div>
        <div class="format-selection">
            <label>Test turi</label>
            <div class="format-options">
                <div class="format-option">
                    <input type="radio" id="multiple-choice" wire:model="type" name="quizType" value="multiple choice" checked>
                    <label for="multiple-choice">
                        Test
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="true-false" wire:model="type" name="quizType" value="true false">
                    <label for="true-false">
                        To'g'ri/Noto'g'ri
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="short-answer" wire:model="type" name="quizType" value="short answer">
                    <label for="short-answer">
                        Qisqa javob
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="fill-blanks" wire:model="type" name="quizType" value="fill blanks">
                    <label for="fill-blanks">
                        Bo'sh joylarni to'ldiring
                    </label>
                </div>
            </div>
        </div>
        <div class="format-selection">
            <label>Til</label>
            <div class="format-options">
                <div class="format-option">
                    <input type="radio" id="uzbek" wire:model="language" name="language" value="UZBEK">
                    <label for="uzbek">
                        🇺🇿 O'zbek
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="english" wire:model="language" name="language" value="ENGLISH">
                    <label for="english">
                        🇬🇧 Ingliz
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="RUSSIAN" wire:model="language" name="language" value="RUSSIAN">
                    <label for="RUSSIAN">
                        🇷🇺 Rus
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="TURKISH" wire:model="language" name="language" value="TURKISH">
                    <label for="TURKISH">
                        🇹🇷 Turk
                    </label>
                </div>
            </div>
        </div>

        <div class="format-selection">
            <label>Qiyinlik</label>
            <div class="format-options">
                <div class="format-option">
                    <input type="radio" id="Beginner" wire:model="difficulty" name="difficulty" value="Beginner">
                    <label for="Beginner">
                        ⭐ Boshlang'ich
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="Intermediate" wire:model="difficulty" name="difficulty" value="Intermediate">
                    <label for="Intermediate">
                        ⭐⭐ O'rtacha
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="Advanced" wire:model="difficulty" name="difficulty" value="Advanced">
                    <label for="Advanced">
                        ⭐⭐⭐ Murakkab
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="Expert" wire:model="difficulty" name="difficulty" value="Expert">
                    <label for="Expert">
                        🏆 Ekspert
                    </label>
                </div>
            </div>
        </div>


        <div class="format-selection">
            <label>Format</label>
            <div class="format-options">
                <div class="format-option">
                    <input type="radio" wire:model="format" id="link" name="format" value="link" checked>
                    <label for="link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                        </svg>
                        Havola
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="pdf" wire:model="format" name="format" value="pdf">
                    <label for="pdf">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6" />
                        </svg>
                        PDF
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="csv" name="format" value="csv">
                    <label for="csv">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        CSV
                    </label>
                </div>
                <div class="format-option">
                    <input type="radio" id="text" wire:model="format" name="format" value="text">
                    <label for="text">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                        TEXT
                    </label>
                </div>
            </div>
        </div>

        <div class="format-selection">
            <label>Savollar soni</label>
            <div class="counter-input">
                <button type="button" class="counter-btn minus" aria-label="Decrease">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
                <input type="text" wire:model="number_of_question" id="questionLimit" name="questionLimit" value="10" readonly>
                <button type="button" class="counter-btn plus" aria-label="Increase">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="format-selection">
            <button type="submit" class="submit-btn">
                <span>Testni yaratish</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        </div>
    </form>
</div>
