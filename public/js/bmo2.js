/**
 * Sistema BMO - Controlador Principal
 * Maneja el cambio de pantallas y lógica global
 */

class BMOSystem {
    constructor() {
        this.currentScreen = null;
        this.filterRoom = null;
        this.screens = {};
        this.init();
        this.timeout = null
        this.messages = [
            "Procesando...",
            "Cocinando magia...",
            "Sumando puntos...",
            "BMO está feliz :)",
            "Ole la limpieza :O",
            "Puntitos, puntitos ricos"
        ];
    }

    init() {
        // Aquí cargarán las pantallas
        this.loadScreen('select-user'); // Pantalla inicial
        
    }

    resetTimer() {
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => {
            document.getElementById('screensaver').style.display = 'flex';
            document.getElementById('bmo-content-container').style.display = 'none';
            
        }, 60000); // 60 segundos
    }
    /**
     * Carga una pantalla dinámicamente
     * @param {string} screenName - Nombre de la pantalla
     */
    loadScreen(screenName) {
        // Oculta pantalla actual
        if (this.currentScreen) {
            document.querySelector('.bmo-screen.active')?.classList.remove('active');
        }

        // Muestra nueva pantalla
        const screenElement = document.querySelector(`[data-screen="${screenName}"]`);
        if (screenElement) {
            screenElement.classList.add('active');
            this.currentScreen = screenName;
            
            // Actualiza la visibilidad del header según la pantalla
            if (typeof updateHeaderVisibility === 'function') {
                updateHeaderVisibility(screenName);
            }
        } else {
            console.error(`Pantalla "${screenName}" no encontrada`);
        }

        if(screenName == 'screensaver'){
            document.getElementById('bmo-content-container').style.display = 'none';
        }else{
            document.getElementById('bmo-content-container').style.display = 'block'    ;
        }
    }

    registerScreen(name, screenClass) {
        this.screens[name] = screenClass;
    }

    setUser(id) {
    
        bmo.selectedUser = id;
        this.loadScreen('tasks');
        this.updateUserIcon();
    }

    

    showLoader() {
        const text = document.querySelector('.loader-text');

        text.innerText = this.messages[Math.floor(Math.random() * this.messages.length)];
        this.loadScreen('loader');
    }


    updateUserIcon(){
        const userIconImgs = document.querySelectorAll('.current-user-icon');

        if (userIconImgs.length === 0) return;

        userIconImgs.forEach(userIconImg => {
            if (bmo.selectedUser == 1) {
                userIconImg.src = 'icons/header/bmo.png';
            } else if (bmo.selectedUser == 2) {
                userIconImg.src = 'icons/header/bma.png';
            } else {
                userIconImg.src = ''; // Ningún usuario
            }
        });
    }

    setFilterRoom(room){
        console.log("Filtrando por habitación:", room);
        if(this.filterRoom === room){

            console.log("Quitando filtro de habitación");
            this.filterRoom = null;
            const allitems = document.querySelectorAll('[data-room]');
            allitems.forEach(i => {
                i.style.display = 'flex';
            });
            const othersBtn = document.querySelectorAll('[data-sroom]');
            othersBtn.forEach(b => b.classList.remove('active'));
            const filterIconImgs = document.querySelectorAll('.filterIcon');

            if (filterIconImgs.length === 0) return;

            filterIconImgs.forEach(filterIconImg => {
                    filterIconImg.style.display = 'none';
                    filterIconImg.src = '';
            });
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
        this.filterRoom = room;
        let filterIcon = document.querySelector('[data-room="' + room + '"] img');

        const filterIconImgs = document.querySelectorAll('.filterIcon');

        if (filterIconImgs.length === 0) return;

        filterIconImgs.forEach(filterIconImg => {
            if(filterIcon.src){
                filterIconImg.style.display = 'block';
                filterIconImg.src = filterIcon.src;
            }else{
                filterIconImg.style.display = 'none';
                filterIconImg.src = '';
            }
        });
    }

    completeTaskConfirm(taskId, taskDescription = '', isCommon = false) {
        this.loadScreen('confirm'); // Pantalla inicial
        const btn = document.getElementById('confirmTaskBtn');
        btn.dataset['task'] = taskId;
        btn.dataset['common'] = isCommon;
        const message = document.getElementById('taskDescription');
        message.textContent = taskDescription || '';
    }

    completeTask() {
        this.showLoader();
        const btn = document.getElementById('confirmTaskBtn');
        let taskId = btn.dataset['task'];
        let isCommon = btn.dataset['common'];
        const user = document.getElementById('user' + taskId);
        let form = document.getElementById('formTask' + taskId);

        if(isCommon == 'true'){
            form = document.getElementById('formCommonTask' + taskId);
        }
        user.value = bmo.selectedUser;
        form.submit();
    }

    cancelCompleteTask(){
        const btn = document.getElementById('confirmTaskBtn');
        let isCommon = btn.dataset['common'];
        console.log("Cancelando tarea. Es común?", isCommon);
        if(isCommon == 'true'){
            this.loadScreen('common_tasks');
        }else{
            this.loadScreen('tasks');
        }
    }
}



// Instancia global
const bmoApp = new BMOSystem();

document.getElementById('screensaver').addEventListener('click', (e) => {
    e.stopPropagation(); // evita que el click se propague a elementos debajo
    e.preventDefault();  // evita acciones por defecto si hubiera
    location.reload();
});
document.addEventListener('click', function(e){
    if(!screensaver.contains(e.target)){
        bmoApp.resetTimer();
    }
});
document.addEventListener('touchstart', function(e){
    if(!screensaver.contains(e.target)){
        bmoApp.resetTimer();
    }
});
bmoApp.resetTimer();