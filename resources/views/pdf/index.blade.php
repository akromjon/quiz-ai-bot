<!DOCTYPE html>
<html lang="uz">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quiz</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .question {
            margin-bottom: 20px;
        }
        .question-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .option {
            margin-left: 15px;
            margin-bottom: 3px;
        }
        .correct {
            font-weight: bold;
            color: #008800;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <h1>Quiz</h1>

    @php $questionNumber = 1; @endphp

    @foreach($quizzes as $quiz)
        @foreach($quiz->questions as $question)
            <div class="question">
                <div class="question-title">{{ $questionNumber }}. Savol</div>
                <div>{{ $question->text }}</div>

                @foreach($question->options as $option)
                    <div class="option {{ $option->is_correct ? 'correct' : '' }}">
                        {{ $option->text }} {{ $option->is_correct ? '✓' : '' }}
                    </div>
                @endforeach
            </div>

            @php $questionNumber++; @endphp

            @if($questionNumber % 10 == 0)
                <div class="page-break"></div>
            @endif
        @endforeach
    @endforeach
</body>
</html>
