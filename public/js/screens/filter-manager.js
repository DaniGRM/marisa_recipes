/**
 * Sistema de Filtros - Módulo independiente
 * Maneja la lógica de filtros y comunicación con el servidor
 */

class FilterManager {
    constructor() {
        this.currentFilter = null;
    }

    /**
     * Inicializa el gestor de filtros con el filtro actual
     * @param {string} currentFilter - Filtro actual desde la sesión
     */
    init(currentFilter) {
        this.currentFilter = currentFilter || null;
    }

    /**
     * Aplica o quita un filtro y lo guarda en sesión
     * @param {string} room - Nombre de la habitación
     * @param {number} userId - ID del usuario
     */
    toggleFilter(room, userId) {
        // Si es el mismo filtro, se desactiva
        if (this.currentFilter === room) {
            this.clearFilter(userId);
            return;
        }

        // Si es un filtro diferente, se activa
        this.applyFilter(room, userId);
    }

    /**
     * Aplica un filtro específico
     * @param {string} room - Nombre de la habitación
     * @param {number} userId - ID del usuario
     */
    applyFilter(room, userId) {
        this.saveFilterToSession(room, userId);
        this.currentFilter = room;
    }

    /**
     * Limpia el filtro actual
     * @param {number} userId - ID del usuario
     */
    clearFilter(userId) {
        this.saveFilterToSession(null, userId);
        this.currentFilter = null;
    }

    /**
     * Guarda el filtro en sesión mediante AJAX
     * @param {string|null} room - Nombre de la habitación o null para limpiar
     * @param {number} userId - ID del usuario
     */
    saveFilterToSession(room, userId) {
        fetch('/bmo/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': bmo.csrfToken
            },
            body: JSON.stringify({
                room: room,
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Filtro guardado:', data.room || 'ninguno');
            }
        })
        .catch(error => {
            console.error('Error al guardar filtro:', error);
        });
    }

    /**
     * Aplica el filtro visualmente en la pantalla
     * @param {string} room - Nombre de la habitación
     */
    applyFilterUI(room) {
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

        this.updateFilterIcon(room);
    }

    /**
     * Limpia el filtro visualmente en la pantalla
     */
    clearFilterUI() {
        const allitems = document.querySelectorAll('[data-room]');
        allitems.forEach(i => {
            i.style.display = 'flex';
        });

        const othersBtn = document.querySelectorAll('[data-sroom]');
        othersBtn.forEach(b => b.classList.remove('active'));

        this.clearFilterIcon();
    }

    /**
     * Actualiza el ícono del filtro aplicado en el header
     * @param {string} room - Nombre de la habitación
     */
    updateFilterIcon(room) {
        const filterIconImgs = document.querySelectorAll('.filterIcon');
        const filterIcon = document.querySelector('[data-sroom="' + room + '"] img');

        if (filterIconImgs.length === 0) return;

        filterIconImgs.forEach(filterIconImg => {
            if (filterIcon && filterIcon.src) {
                filterIconImg.style.display = 'block';
                filterIconImg.src = filterIcon.src;
            } else {
                filterIconImg.style.display = 'none';
                filterIconImg.src = '';
            }
        });
    }

    /**
     * Limpia el ícono del filtro en el header
     */
    clearFilterIcon() {
        const filterIconImgs = document.querySelectorAll('.filterIcon');

        if (filterIconImgs.length === 0) return;

        filterIconImgs.forEach(filterIconImg => {
            filterIconImg.style.display = 'none';
            filterIconImg.src = '';
        });
    }
}

// Instancia global
const filterManager = new FilterManager();
