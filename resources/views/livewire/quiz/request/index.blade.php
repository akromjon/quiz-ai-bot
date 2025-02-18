<div>
    <form id="quizForm" wire:submit="submit">
        <div class="input-group">
            <label for="userText">Matn kiriting</label>
            <textarea minlength="3" wire:model="text" id="userText" placeholder="Matningizni bu yerga joylashtiring va biz uni testga aylantiramiz..."
                rows="8" required></textarea>
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
            <label for="questionLimit">Savollar soni</label>
            <div class="counter-input">
                <button
                    type="button"
                    wire:click="minusHandler"
                    class="counter-btn minus"
                    aria-label="Decrease"
                    @disabled($this->number_of_question <= 10)
                >
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>

                <input
                    type="text"
                    wire:model="number_of_question"
                    id="questionLimit"
                    name="number_of_question"
                    readonly
                    aria-label="Number of questions"
                >

                <button
                    type="button"
                    wire:click="plusHandler"
                    class="counter-btn plus"
                    aria-label="Increase"
                    @disabled($this->number_of_question >= 40)
                >
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="format-selection">
            <button type="submit" wire:click="submit" class="submit-btn">
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
