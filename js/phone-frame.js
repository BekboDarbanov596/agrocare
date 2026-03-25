// Скрипт для рамки телефона
document.addEventListener('DOMContentLoaded', function() {
    // Обновление времени в статус-баре
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const timeElements = document.querySelectorAll('.phone-time');
        timeElements.forEach(el => {
            el.textContent = `${hours}:${minutes}`;
        });
    }

    updateTime();
    setInterval(updateTime, 60000);

    // Симуляция уровня батареи
    function updateBattery() {
        const batteryElements = document.querySelectorAll('.phone-battery');
        batteryElements.forEach(el => {
            const level = Math.floor(Math.random() * 20) + 80; // 80-100%
            el.innerHTML = `<span>${level}%</span><div class="battery-icon" style="width: ${level}%"></div>`;
        });
    }

    updateBattery();
    setInterval(updateBattery, 300000); // каждые 5 минут

    // Плавная прокрутка для контента телефона
    const phoneContent = document.querySelector('.phone-content');
    if (phoneContent) {
        phoneContent.addEventListener('scroll', function() {
            // Можно добавить эффекты при прокрутке
        });
    }
});
