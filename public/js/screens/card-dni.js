/**
 * Sistema de Tarjeta DNI - Módulo independiente
 * Maneja la lógica de renderizado y actualizaciones de la tarjeta del usuario
 */

class CardDNI {
    constructor() {
        this.currentUser = null;
    }

    /**
     * Inicializa la tarjeta con los datos del usuario actual
     * @param {number} userId - ID del usuario seleccionado
     */
    init(userId) {
        this.currentUser = bmo.users[userId - 1];
        
        if (!this.currentUser) {
            console.warn('Usuario no encontrado en CardDNI');
            return false;
        }

        this.render();
        return true;
    }

    /**
     * Renderiza todos los elementos de la tarjeta
     */
    render() {
        this.updateName();
        this.updatePoints();
        this.updateImages();
    }

    /**
     * Actualiza el nombre del usuario en la tarjeta
     */
    updateName() {
        const nameElement = document.querySelector('.bmo-dni-name span');
        if (nameElement) {
            nameElement.textContent = this.currentUser.name;
        }
    }

    /**
     * Actualiza los puntos del usuario
     */
    updatePoints() {
        const pointsElement = document.querySelector('.bmo-dni-points');
        if (pointsElement) {
            pointsElement.innerHTML = `<img style="margin-bottom: 18px;" src="/card/coin.png" alt="Coin Icon"> ${this.currentUser.current_month_points}`;
        }
    }

    /**
     * Actualiza las imágenes de la tarjeta según el usuario
     */
    updateImages() {
        this.updateCharmImage();
        this.updateDniImage();
        this.updateQueenRoomImage();
    }

    /**
     * Actualiza la imagen del adorno (charm) de la tarjeta
     */
    updateCharmImage() {
        const charmElement = document.querySelector('.bmo-dni-charm');
        if (charmElement) {
            charmElement.src = this.currentUser.id == 1 ? '/card/bmo-charm.png' : '/card/bma-charm.png';
        }
    }

    /**
     * Actualiza la imagen principal de la tarjeta
     */
    updateDniImage() {
        const dniImgElement = document.querySelector('.bmo-dni-img');
        if (dniImgElement) {
            dniImgElement.src = this.currentUser.id == 1 ? '/card/dni-bmo.png' : '/card/dni-bma.png';
        }
    }

    updateQueenRoomImage() {
        const otherUserId = this.currentUser.id === 1 ? 2 : 1;
        const otherRoomElement = document.querySelector(`#queenRoom${otherUserId}`);
        if (otherRoomElement) {
            otherRoomElement.style.display = 'none';
        }

        const queenRoomElement = document.querySelector(`#queenRoom${this.currentUser.id}`);
        if (queenRoomElement) {
            const favoriteRoom = bmo.favoriteRooms[this.currentUser.id];
            if (favoriteRoom) {
                queenRoomElement.src = favoriteRoom.icon_path;
                queenRoomElement.alt = `Habitación favorita: ${favoriteRoom.name}`;
                queenRoomElement.title = `Habitación favorita: ${favoriteRoom.name}`;
                queenRoomElement.style.display = 'block';
            } else {
                queenRoomElement.style.display = 'none';
            }
        }

    }
    /**
     * Actualiza un campo específico de la tarjeta
     * @param {string} field - Campo a actualizar (name, points, images)
     */
    updateField(field) {
        switch(field) {
            case 'name':
                this.updateName();
                break;
            case 'points':
                this.updatePoints();
                break;
            case 'images':
                this.updateImages();
                break;
            case 'all':
                this.render();
                break;
            default:
                console.warn(`Campo desconocido: ${field}`);
        }
    }
}

// Instancia global
const cardDNI = new CardDNI();
