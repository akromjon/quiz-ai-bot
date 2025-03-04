<div class="container">
    <!-- Added breadcrumb navigation -->
    <nav class="breadcrumb">
        <a href="{{route('quiz.list',0)}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                style="position: relative; top: -1px;">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
            Orqaga
        </a>
    </nav>

    <header>
        <h1>Quiz</h1>
        @if($isSubmitted)
        <div class="alert success"
            style="background-color: var(--secondary-bg); border: 1px solid var(--border-color); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
            <p style="color: var(--primary-color);">
                Sizning natijangiz: {{ $correctCount }} / {{ $totalQuestions }}
                ({{ round(($correctCount / $totalQuestions) * 100) }}%)
            </p>
        </div>
        @endif
    </header>

    <main>
        <form wire:submit.prevent="submit">
            <div class="quiz-results">
                @php
                $counter = 0;
                @endphp
                @foreach ($quizzes as $quiz)
                @foreach ($quiz->questions as $q)
                @php
                $counter++;
                $questionResult = $isSubmitted ? $results[$q->id] : null;
                @endphp
                <div class="question-card"
                    style="{{ $isSubmitted ? ($questionResult['isCorrect'] ? 'background: var(--secondary-bg);' : 'background: #FEE2E2;') : '' }}">
                    <h2 class="question-number">{{$counter}}. Savol</h2>
                    <p class="question-text">{{$q->text}}</p>
                    <div class="options">
                        @foreach ($q->options as $o)
                        <div class="option">
                            <input type="radio" id="{{$o->id}}" wire:model="selectedAnswers.{{$q->id}}"
                                value="{{$o->id}}" @disabled($isSubmitted)>
                            <label for="{{$o->id}}" style="
                                            @if($isSubmitted)
                                                @if($o->id === $questionResult['correctOptionId'])
                                                    color: var(--primary-color);
                                                    font-weight: 600;
                                                @elseif($o->id === $questionResult['selectedOptionId'] && !$questionResult['isCorrect'])
                                                    color: #DC2626;
                                                    text-decoration: line-through;
                                                @endif
                                            @endif
                                        ">
                                {{$o->text}}
                                @if($isSubmitted && $o->id === $questionResult['correctOptionId'])
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="
                                        top: 2px;
                                        display: inline;
                                        margin-left: 8px;
                                        color: var(--primary-color);
                                        position: relative;
                                    " viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                @endif
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @if($isSubmitted)
                    <div style="margin-top: 1rem;">
                        @if($questionResult['isCorrect'])
                        <p style="color: var(--primary-color);">✓ To'g'ri javob!</p>
                        @else
                        <p style="color: #DC2626;">✗ Noto'g'ri javob</p>
                        @endif
                    </div>
                    @endif
                </div>
                @endforeach
                @endforeach
            </div>

            <div class="actions">
                @if(!$isSubmitted)
                <button type="submit" class="submit-btn primary-btn">
                    <span>Testni yakunlash</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </button>
                @else
                <button type="button" onclick="window.location.reload()" class="submit-btn"
                    style="background-color: #6B7280;">
                    Qaytadan boshlash
                </button>
                @endif
            </div>
        </form>
    </main>
</div>
