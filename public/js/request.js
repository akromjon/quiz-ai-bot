const input = document.getElementById('questionLimit');
const minusBtn = document.querySelector('.minus');
const plusBtn = document.querySelector('.plus');
const values = [10, 20, 30, 50];
let currentIndex = 0;

function updateButtonStates() {
    minusBtn.disabled = currentIndex === 0;
    plusBtn.disabled = currentIndex === values.length - 1;
}

minusBtn.addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
        input.value = values[currentIndex];
        updateButtonStates();
    }
});

plusBtn.addEventListener('click', () => {
    if (currentIndex < values.length - 1) {
        currentIndex++;
        input.value = values[currentIndex];
        updateButtonStates();
    }
});

updateButtonStates();

