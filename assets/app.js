/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import 'flowbite';

document.addEventListener('DOMContentLoaded', function() {
    // Assurez-vous d'utiliser le bon sélecteur pour le bouton
    const button = document.querySelector('#user-menu-button'); // Le bouton qui déclenche le dropdown
    const dropdown = document.querySelector('#user-dropdown'); // Le dropdown menu lui-même
    
    if (button && dropdown) {
        button.addEventListener('click', () => {
            dropdown.classList.toggle('hidden'); // Afficher/masquer le dropdown
        });
    }
});

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
