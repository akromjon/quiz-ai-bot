<div class="container">
    @if($quizRequestModel->status->value==='pending')
        @include('livewire.quiz.status.pending')
    @elseif($quizRequestModel->status->value==='processing')
        @include('livewire.quiz.status.processing')
    @elseif($quizRequestModel->status->value==='completed')
        @include('livewire.quiz.status.completed')
    @else
        @include('livewire.quiz.status.failed')
    @endif
</div>
