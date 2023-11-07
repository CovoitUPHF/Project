const searchForm = document.getElementById("search-form");

searchForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const departure = document.getElementById("departure").value;
    const destination = document.getElementById("destination").value;

    if (departure && destination) {
        // Vous pouvez ajouter ici la logique de recherche et d'affichage des résultats
        alert(`Recherche de covoiturage de ${departure} à ${destination}`);
    } else {
        alert("Veuillez saisir un lieu de départ et une destination.");
    }
});

