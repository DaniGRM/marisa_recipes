const myConfetti = confetti.create(
    document.getElementById('confetti-canvas'),
    { resize: true }
);
document.addEventListener("DOMContentLoaded", function () {
    if (taskCompleted) {
        showTaskCompleted();
    }
    
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
screensaver.addEventListener('click', function(e) {
    e.stopPropagation(); // evita que el click se propague a elementos debajo
    e.preventDefault();  // evita acciones por defecto si hubiera
    location.reload();
});

screensaver.addEventListener('touchstart', function(e) {
    e.stopPropagation();
    e.preventDefault();
    location.reload();
});

let timeout;

function resetTimer() {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        screensaver.style.display = 'flex';
        app.style.display = 'none';
    }, 60000); // 60 segundos
}

document.addEventListener('click', function(e){
    if(!screensaver.contains(e.target)){
        resetTimer();
    }
});
document.addEventListener('touchstart', function(e){
    if(!screensaver.contains(e.target)){
        resetTimer();
    }
});

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
    const form = document.getElementById('formCommonTask' + taskId);
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
        targets: ['#view-' + viewName + ' .task', '#view-' + viewName + ' .common-task'], // o .today-item
        
        translateY: [30, 0],
        opacity: [0, 1],
        scale: [0.95, 1],

        delay: anime.stagger(240), // clave → uno detrás de otro

        easing: 'easeOutCubic',
        duration: 400
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

function showTaskCompleted() {

    const overlay = document.getElementById('task-completed');
    const imageScreen = document.getElementById('bmo-image-screen');
    const textScreen = document.getElementById('bmo-text-screen');

    overlay.style.display = 'flex';

    
    // Mostrar imagen primero
    imageScreen.classList.add('active');
    textScreen.classList.remove('active');

    // Después de 2s → texto
    setTimeout(() => {
        imageScreen.classList.remove('active');
         // 🎉 Lanzar confetti al inicio
        launchConfetti();
        textScreen.classList.add('active');
        
    }, 3000);
   
    // Después de 5s → volver a app
    setTimeout(() => {
        overlay.style.display = 'none';
    }, 6000);
}


function launchConfetti() {

    const duration = 2000;
    const end = Date.now() + duration;

    (function frame() {

        myConfetti({
            particleCount: 5,
            angle: 60,
            spread: 55,
            origin: { x: 0 }
        });

        myConfetti({
            particleCount: 5,
            angle: 120,
            spread: 55,
            origin: { x: 1 }
        });

        if (Date.now() < end) {
            requestAnimationFrame(frame);
        }

    })();
}