let cardwrap = document.getElementById('cardwrap');

function home() {
    // Rediriger l'utilisateur vers une autre page
    window.location.href = "index.php";
}
function openCard() {
    cardwrap.classList.toggle('open-menu');
}
function logout() {
    // Rediriger l'utilisateur vers une autre page
    window.location.href = "register.php";
}
function ajouter() {
    // Rediriger l'utilisateur vers une autre page
    window.location.href = "joueur.php";
}
function equipe() {
    // Rediriger l'utilisateur vers une autre page
    window.location.href = "equipe.php";
}
function index() {
    // Rediriger l'utilisateur vers une autre page
    window.location.href = "index.php";
}
function deleteUser(email) {
    // Envoyer une requête AJAX pour supprimer l'utilisateur
    fetch('equipe.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email: email }),
    })
    .then(response => response.json())
    .then(data => {
        // Si la suppression réussit, recharger la page pour mettre à jour la liste des utilisateurs
        if (data.success) {
            location.reload();
        } else {
            // Si la suppression échoue, afficher un message d'erreur
            console.error('Erreur lors de la suppression:', data.error);
        }
    })
    .catch(error => console.error('Erreur:', error));
}

