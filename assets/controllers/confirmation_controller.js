import { Controller } from "@hotwired/stimulus";

/**
 *  Ce contrôleur gère l'affichage d'un popup de confirmation avant la soumission du formulaire de réservation.
 */
export default class extends Controller {
    static targets = ["popup"];
    connect() {
        this.popupTarget.classList.add("hidden"); // Masquer le popup au chargement initial
    }

    showPopup(event) {
        event.preventDefault(); // Empêcher la soumission immédiate du formulaire
        this.popupTarget.classList.remove("hidden"); // Afficher le popup
        setTimeout(() => {
            event.target.submit(); // Soumettre le formulaire après l'affichage du popup
        }, 5000); // Délai de 5 secondes avant la soumission
    }

    closePopup() {
        this.popupTarget.classList.add("hidden"); // Masquer le popup
    }
}