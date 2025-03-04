@extends('parts.main')
@section('style')
<link rel="stylesheet" href="{{ asset('css/request.css') }}">
<style>
    #userText:invalid {
        border-color: red;
    }

    #userText:valid {
        border-color: green;
    }
</style>
@endsection
@section('main')
<div class="container">
    @include('parts.header')
    <main>
        @livewire('quiz-request')
    </main>
</div>
@endsection
@section('script')

<script src="{{asset('js/request.js')}}"></script>
<script>
    // Create alert element
const alertDiv = document.createElement('div');
alertDiv.style.marginTop = '8px';
alertDiv.style.padding = '8px';
alertDiv.style.borderRadius = '4px';
alertDiv.style.display = 'none';

// Insert alert after textarea
const textarea = document.getElementById('userText');
textarea.parentNode.insertBefore(alertDiv, textarea.nextSibling);

// Create validator function
function validateTextInput(event) {
    const text = textarea.value;
    const minLength = 3;
    const maxLength = 25000;

    // Hide alert by default
    alertDiv.style.display = 'none';
    textarea.style.borderColor = '';

    // Check if text is too short
    if (text.length < minLength) {
        showError(`Matn kamida ${minLength} ta belgidan iborat bo'lishi kerak. Hozir: ${text.length} ta belgi.`);
        return false;
    }

    // Check if text is too long
    if (text.length > maxLength) {
        showError(`Matn ${maxLength} ta belgidan oshmasligi kerak. Hozir: ${text.length} ta belgi.`);
        return false;
    }

    // If validation passes
    showSuccess(`Matn to'g'ri formatda!`);
    return true;
}

// Function to show error message
function showError(message) {
    alertDiv.style.display = 'block';
    alertDiv.style.backgroundColor = '#ffd2d2';
    alertDiv.style.color = '#d8000c';
    alertDiv.style.border = '1px solid #d8000c';
    alertDiv.textContent = message;
    textarea.style.borderColor = '#d8000c';
    textarea.setCustomValidity(message);
}

// Function to show success message
function showSuccess(message) {
    alertDiv.style.display = 'block';
    alertDiv.style.backgroundColor = '#dff2bf';
    alertDiv.style.color = '#270';
    alertDiv.style.border = '1px solid #270';
    alertDiv.textContent = message;
    textarea.style.borderColor = '#270';
    textarea.setCustomValidity('');
}

// Add event listeners
textarea.addEventListener('input', validateTextInput);
textarea.addEventListener('change', validateTextInput);

// For use with form submission
const form = textarea.closest('form');
if (form) {
    form.addEventListener('submit', (event) => {
        if (!validateTextInput()) {
            event.preventDefault();
        }
    });
}

// Initial validation
validateTextInput();
</script>

@endsection
