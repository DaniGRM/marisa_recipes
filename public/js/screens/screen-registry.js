/**
 * Registro de configuración de pantallas BMO
 * Define qué pantallas muestran header y otros elementos globales
 */

const screenRegistry = {
    tasks: {
        showHeader: true
    },
    common_tasks: {
        showHeader: true
    },
    user_select: {
        showHeader: false
    },
    welcome: {
        showHeader: false
    }
};

/**
 * Obtiene la configuración de una pantalla
 * @param {string} screenName - Nombre de la pantalla
 * @returns {object} Configuración de la pantalla
 */
function getScreenConfig(screenName) {
    return screenRegistry[screenName] || { showHeader: false };
}

/**
 * Actualiza la visibilidad del header basado en la pantalla activa
 * @param {string} screenName - Nombre de la pantalla activa
 */
function updateHeaderVisibility(screenName) {
    const config = getScreenConfig(screenName);
    const headerEl = document.querySelector('.bmo-header');
    
    if (headerEl) {
        if (config.showHeader) {
            headerEl.classList.add('visible');
        } else {
            headerEl.classList.remove('visible');
        }
    }
}
