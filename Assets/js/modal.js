// Sélectionnez tous les liens d'ouverture de modale
const openModalLinks = document.querySelectorAll('.open-modal');

// Sélectionnez tous les boutons de fermeture de modale
const closeModalButtons = document.querySelectorAll('.close-modal');

// Ajoutez un gestionnaire d'événements pour les liens d'ouverture de modale
openModalLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const bookId = link.getAttribute('data-book-id');
        const modal = document.querySelector(`#modal-${bookId}`);
        modal.style.display = 'block';
    });
});

// Ajoutez un gestionnaire d'événements pour les boutons de fermeture de modale
closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.modal');
        modal.style.display = 'none';
    });
});
