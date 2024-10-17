<?php
require('view_begin.php');
session_start(); // S'assurer que la session est démarrée

// Vérifier s'il y a une erreur ou un succès dans la session
if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']); // Supprimer l'erreur après l'affichage
}

if (isset($_SESSION['success'])) {
    echo "<script>alert('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']); // Supprimer le message de succès après l'affichage
}
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="border p-4 rounded">
        <h1>Ajouter un joueur</h1>
        <form action="?controller=set&action=add" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nom:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nickname" class="form-label">Pseudo:</label>
                <input type="text" id="nickname" name="nickname" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone:</label>
                <input type="tel" id="phone" name="phone" class="form-control" required maxlength="10" oninput="removeSpacesAndValidate(this)">
                <small class="form-text text-muted">Entrez un numéro de téléphone valide (10 chiffres sans espaces).</small>
            </div>

            <p><input type="submit" value="Ajouter" class="btn btn-primary"></p>
        </form>
    </div>
</div>

<script>
function removeSpacesAndValidate(input) {
    // Enlever les espaces du champ de saisie
    input.value = input.value.replace(/\s+/g, '');
    
    // Enlever tout caractère qui n'est pas un chiffre
    input.value = input.value.replace(/\D/g, '');

    // Limiter la longueur à 10 caractères
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
}
</script>

<?php
require('view_end.php');
?>
