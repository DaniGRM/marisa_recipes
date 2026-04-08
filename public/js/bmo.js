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
const user_card_screen = document.getElementById('user-card-screen');
const app = document.getElementById('app');
const user_select = document.getElementById('user-select');
let filterRoom = null;
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
        user_card_screen.style. display = 'none';
        
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
    updateUserIcon();
}

function completeTaskConfirm(taskId){
    const taskConfirm = document.getElementById('bmo-task-confirm');
    taskConfirm.classList.add('active');
    const btn = document.getElementById('confirmTaskBtn');
    btn.dataset['task'] = taskId;
    btn.dataset['common'] = false;

}
function completeTask() {
    const btn = document.getElementById('confirmTaskBtn');
    let taskId = btn.dataset['task'];
    let isCommon = btn.dataset['common'];
    showLoader();
    const user = document.getElementById('user' + taskId);
    let form = document.getElementById('formTask' + taskId);

    if(isCommon == 'true'){
        form = document.getElementById('formCommonTask' + taskId);
    }
    user.value = selectedUser;
    form.submit();
}

function completeCommonTaskConfirm(taskId){
    const taskConfirm = document.getElementById('bmo-task-confirm');
    taskConfirm.classList.add('active');
    const btn = document.getElementById('confirmTaskBtn');
    btn.dataset['task'] = taskId;
    btn.dataset['common'] = true;

}

function cancelCompleteTask(){
    const taskConfirm = document.getElementById('bmo-task-confirm');
    taskConfirm.classList.remove('active');
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
const messages = [
    "Procesando...",
    "Cocinando magia...",
    "Sumando puntos...",
    "BMO está feliz :)",
    "Ole la limpieza :O",
    "Puntitos, puntitos ricos"
];

function showLoader() {
    const loader = document.getElementById('bmo-loader');
    const text = loader.querySelector('.loader-text');

    text.innerText = messages[Math.floor(Math.random() * messages.length)];

    loader.classList.add('active');
}

function showFilters(){
    const filters = document.getElementById('task-filter');
    filters.style.display = 'flex';
    app.style.display = 'none';
}

function hideFilters(){
    const filters = document.getElementById('task-filter');
    filters.style.display = 'none';
    app.style.display = 'flex';
}
function hideLoader() {
    const loader = document.getElementById('bmo-loader');
    if (loader) {
        loader.classList.remove('active');
    }
}

function updateUserIcon() {
    const userIconImg = document.querySelector('#current-user-icon img');

    if (!userIconImg) return;

    if (selectedUser == 1) {
        userIconImg.src = 'bmo.png';
    } else if (selectedUser == 2) {
        userIconImg.src = 'bma.png';
    } else {
        userIconImg.src = ''; // Ningún usuario
    }
}

// Mostrar modal al click en el icono de usuario
document.querySelector('#current-user-icon').addEventListener('click', function() {
    const overlay = document.getElementById('user-card-screen');
    const card = document.querySelector('.user-card-container');
    const img = document.getElementById('userCardImg');
    let name = document.getElementById('userCardName');
    const points = document.getElementById('userCardPoints');
    const tasksCompleted = document.getElementById('userCardTasksCompleted');
    let cardUser = users[selectedUser - 1];
    // Datos dinámicos según selectedUser
    if (selectedUser == 1) {
        img.src = 'bmo-dni.png';
        name.textContent = 'BMO';
    } else if (selectedUser == 2) {
        img.src = 'bma-dni.png';
        name.textContent = 'BMA';
    }

    tasksCompleted.textContent = 'Tareas completadas: ' + cardUser.current_month_tasks;

    name.textContent = cardUser.name;
    points.innerHTML = cardUser.current_month_points + ' <i class="bi bi-coin"></i>';
    overlay.style.display = 'flex';
    // Mostrar la pantalla de info después de 0.3s para efecto tipo “pantalla”
     overlay.classList.add('active');
    document.getElementById('user-card-info-screen').classList.add('active');
    // Animación tipo "tarjeta que aparece"
    anime({
        targets: overlay,
        opacity: [0, 1],
        duration: 200,
        easing: 'linear'
    });

    anime({
        targets: card,
        scale: [0.6, 1],
        translateY: [80, 0],
        opacity: [0, 1],
        duration: 600,
        easing: 'easeOutElastic(1, .6)'
    });

});

// Cerrar pantalla

document.querySelectorAll('.reverse-card').forEach(btn => {
    btn.addEventListener('click', function () {
        const card = document.querySelector('.card-inner');
        card.classList.toggle('flipped');

        if (card.classList.contains('flipped')) {
            setTimeout(() => {
                animateStats();
            }, 300); // espera a que termine el giro
        }
    });
});

function animateStats() {

    document.querySelectorAll('.stat-row').forEach(row => {

        const leftValue = parseInt(row.dataset.left);
        const rightValue = parseInt(row.dataset.right);

        const leftBar = row.querySelector('.stat-left');
        const rightBar = row.querySelector('.stat-right');

        const leftScale = leftValue / 100;
        const rightScale = rightValue / 100;

        setTimeout(() => {
            leftBar.style.transform = `scaleX(${leftScale})`;
            rightBar.style.transform = `scaleX(${rightScale})`;
        }, 100);

    });

}
function closeCard(){
    const overlay = document.getElementById('user-card-screen');
    overlay.style.display = 'none';
    // Resetear screens
    document.getElementById('user-card-info-screen').classList.remove('active');
}

function setFilterRoom(room){

    if(filterRoom === room){
        hideFilters();
        filterRoom = null;
        const allitems = document.querySelectorAll('[data-room]');
        allitems.forEach(i => {
            i.style.display = 'flex';
        });
        const othersBtn = document.querySelectorAll('[data-sroom]');
        othersBtn.forEach(b => b.classList.remove('active'));
        document.getElementById("filterText").textContent = ""; 
        return;
    }
    const notitems = document.querySelectorAll('[data-room]:not([data-room="' + room + '"])');
    notitems.forEach(i => {
        i.style.display = 'none';
    });
    const items = document.querySelectorAll('[data-room="' + room + '"]');
    items.forEach(i => {
        i.style.display = 'flex';
    });

    const selectedBtn = document.querySelectorAll('[data-sroom="' + room + '"]');
    const othersBtn = document.querySelectorAll('[data-sroom]:not([data-sroom="' + room + '"])');
    selectedBtn.forEach(b => b.classList.add('active'));
    othersBtn.forEach(b => b.classList.remove('active'));
    filterRoom = room;
    hideFilters();

    document.getElementById("filterText").textContent = room; 
}

document.addEventListener('keydown', function (e) {

    if (e.key === 'F1') {
        e.preventDefault(); // evita comportamiento por defecto

        // Hard reload tipo Ctrl+Shift+R
        window.location.reload(true);
    }

});