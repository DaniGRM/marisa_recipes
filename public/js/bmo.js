
document.addEventListener("DOMContentLoaded", function () {

    const video = document.getElementById('bmoVideo');

    // Esperar a que el vídeo tenga datos suficientes
    video.addEventListener('canplaythrough', function () {
        video.play().catch(() => { });
    });

    if (selectedUser !== '0') {
        setUser(selectedUser);
    }

});
const screensaver = document.getElementById('screensaver');
const app = document.getElementById('app');
const user_select = document.getElementById('user-select');

function activarApp() {
    screensaver.style.display = 'none';
    user_select.style.display = 'flex';
}

// Detecta toque o click
screensaver.addEventListener('click', activarApp);
screensaver.addEventListener('touchstart', activarApp);

let timeout;

function resetTimer() {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        screensaver.style.display = 'flex';
        app.style.display = 'none';
    }, 60000); // 60 segundos
}

document.addEventListener('click', resetTimer);
document.addEventListener('touchstart', resetTimer);

resetTimer();

function setUser(id) {
    selectedUser = id;
    user_select.style.display = 'none';
    app.style.display = 'flex';
    showView('tasks');
}

function completeTask(taskId) {
    const user = document.getElementById('user' + taskId);
    const form = document.getElementById('formTask' + taskId);
    user.value = selectedUser;
    form.submit();
}

function completeCommonTask(taskId) {
    const user = document.getElementById('user' + taskId);
    const form = document.getElementById('formTask' + taskId);
    user.value = selectedUser;
    form.submit();
}

// --- VISTAS BMO ---
function showView(viewName) {

    document.querySelectorAll('.bmo-view').forEach(v => {
        v.style.display = 'none';
    });

    const view = document.getElementById('view-' + viewName);

    if (view) {
        view.style.display = 'block';
    }
    anime({
        targets: '.'+viewName,
        translateY: [40, 0],
        opacity: [0, 1],
        scale: [0.95, 1],
        delay: anime.stagger(120),
        easing: 'easeOutElastic(1, .3 )',
        duration: 700
    });

}

// Click en iconos
document.querySelectorAll('.icon[data-view]').forEach(icon => {

    icon.addEventListener('click', function () {

        document.querySelectorAll('.icon').forEach(i => i.classList.remove('active'));
        this.classList.add('active');

        const view = this.getAttribute('data-view');
        showView(view);

    });

});