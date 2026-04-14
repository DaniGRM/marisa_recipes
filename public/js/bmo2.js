/**
 * Sistema BMO - Controlador Principal
 * Maneja el cambio de pantallas y lógica global
 */

class BMOSystem {
    constructor() {
        this.currentScreen = null;
        this.screens = {};
        this.init();
    }

    init() {
        // Aquí cargarán las pantallas
        this.loadScreen('select-user'); // Pantalla inicial
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
    }

    registerScreen(name, screenClass) {
        this.screens[name] = screenClass;
    }

    setUser(id) {
    
        bmo.selectedUser = id;
        this.loadScreen('tasks');
    }
}



// Instancia global
const bmoApp = new BMOSystem();