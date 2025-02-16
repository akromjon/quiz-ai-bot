
document.addEventListener('livewire:load', function () {
    Livewire.hook('message.received', (message, component) => {
        const progressValue = document.querySelector('.progress-value');
        const statusText = document.querySelector('.status-text');
        const circle = document.querySelector('.progress-ring-circle');

        const totalCount = 100; // Adjust based on your logic
        const radius = circle.r.baseVal.value;
        const circumference = radius * 2 * Math.PI;

        circle.style.strokeDasharray = `${circumference} ${circumference}`;
        circle.style.strokeDashoffset = circumference;

        function setProgress(progress) {
            const percent = (progress / totalCount) * 100;
            const offset = circumference - (percent / 100 * circumference);
            circle.style.strokeDashoffset = offset;
            progressValue.textContent = progress;

            if (progress <= 30) {
                statusText.textContent = "Matn tahlil qilinmoqda...";
            } else if (progress <= 60) {
                statusText.textContent = "Savollar shakllantirilmoqda...";
            } else if (progress <= 90) {
                statusText.textContent = "Test yakunlanmoqda...";
            } else {
                statusText.textContent = "Tayyor!";
            }
        }

        setProgress(@this.progress); // Get Livewire progress
    });
});

