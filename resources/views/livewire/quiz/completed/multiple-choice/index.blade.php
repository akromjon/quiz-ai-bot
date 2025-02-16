<div>
    <div class="container">
        <header>
            <h1>Quiz</h1>
        </header>
        <main>
            <form action="">
                <div class="quiz-results">
                    @foreach ($questions as $k => $q)
                    <div class="question-card">
                        <h2 class="question-number">Savol {{$k+1}}</h2>
                        <p class="question-text">{{$q->text}}</p>
                        <div class="options">
                            @foreach ($q->options as $o)
                            <div class="option">
                                <input type="radio" id="{{$o->id}}" name="answer_{{$o->id}}">
                                <label for="{{$o->id}}">{{$o->text}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="actions">
                    <button type="submit" class="submit-btn primary-btn">
                        <span>Testni yakunlash</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </main>
    </div>
</div>
