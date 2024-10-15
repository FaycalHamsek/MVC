<?php
require('view_begin.php');
?>

<form action="?controller=lottery&action=jouer" method="post">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Select</th>
                <th scope="col">Pseudo</th>
                <th scope="col">Numéros</th>
                <th scope="col">Etoiles</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($play as $p) { #récupère les infos de notre BDD
                echo "<tr>";
                echo "<td><input type='checkbox' class='player-checkbox' idPlayer='" . $p['id'] . "'></td>"; #on créé l'id pour que le JS récupère
                echo "<td>" . htmlspecialchars($p['nickname'] ?? '') . "</td>";
                echo "<td>";
                for ($i = 1; $i <= 5; $i++) { # on boucle 5 fois pour les 5 input
                    echo "<input type='number' class='number-input' name='loto[" . $p['id'] . "][number][]' min='1' max='49' value='" . htmlspecialchars($p["number$i"] ?? '') . "' disabled>";
                }
                echo "</td>";
                echo "<td>";
                for ($i = 1; $i <= 2; $i++) { #on boucle 2 fois pour les 2 input
                    echo "<input type='number' class='star-input' name='loto[" . $p['id'] . "][stars][]' min='1' max='9' value='" . htmlspecialchars($p["star$i"] ?? '') . "' disabled>";
                }
                echo "</td>";
                echo "<td>";
                echo "<button type='button' class='generate-button' idPlayer='" . $p['id'] . "' generate='generate" . $p['id'] . "' disabled>Générer</button>"; # bouton généré
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-center mb-4"> <!-- Centre le bouton "Jouer" -->
        <input type="submit" value="Jouer" id="playButton" class="btn btn-primary" disabled> <!-- Bouton "Jouer" désactivé au départ -->
    </div>
</form>

<div class="d-flex justify-content-center"> <!-- Centre le bouton "Ajouter un joueur" -->
    <button class="btn btn-primary">
        <a href="?controller=set&action=default" class="text-white text-decoration-none">Ajouter un joueur</a>
    </button>
</div>

<script>
    // Fonction pour activer ou désactiver le bouton "Jouer"
    function togglePlayButton() {
        const playButton = document.getElementById('playButton');
        const checkboxes = document.querySelectorAll('.player-checkbox');

        let allPlayersFilled = true;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                const idPlayer = checkbox.getAttribute('idPlayer');
                const numberInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][number][]"]');
                const starInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][stars][]"]');

                let allInputsFilled = Array.from(numberInputs).every(input => input.value.trim() !== '' && input.value !== '0');
                let allStarsFilled = Array.from(starInputs).every(input => input.value.trim() !== '' && input.value !== '0');

                if (!(allInputsFilled && allStarsFilled)) {
                    allPlayersFilled = false;
                }
            }
        });

        playButton.disabled = !allPlayersFilled;
    }

    document.querySelectorAll('.player-checkbox').forEach(function(checkbox) { // sélection du joueur
        checkbox.addEventListener('change', function() {
            var idPlayer = this.getAttribute('idPlayer');
            var numberInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][number][]"]'); // sélectionner les inputs de numéros
            var starInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][stars][]"]'); // sélectionner les étoiles
            var generateButton = document.querySelector('button[generate="generate' + idPlayer + '"]'); // bouton générer

            numberInputs.forEach(function(input) {
                input.disabled = !checkbox.checked; // l' input est désactiv é
                if (!checkbox.checked) { // si non coché
                    input.value = ''; // vide
                }
            });
            starInputs.forEach(function(input) {
                input.disabled = !checkbox.checked; // l'input est désactivé
                if (!checkbox.checked) { // si non coché
                    input.value = ''; // vide
                }
            });
            generateButton.disabled = !checkbox.checked; // bouton désactivé

            togglePlayButton(); // Vérifier l'état du bouton "Jouer"
        });
    });

    document.querySelectorAll('.generate-button').forEach(function(button) { // bouton générer
        button.addEventListener('click', function() { // sur le click
            var idPlayer = this.getAttribute('idPlayer'); // pour l'idPlayer
            var numberInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][number][]"]'); // générer les 5 numéros
            var starInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][stars][]"]'); // générer les 2 étoiles

            var numbers = [];
            var stars = [];

            numberInputs.forEach(function(input) {
                let randomNumber = Math.floor(Math.random() * 49) + 1;
                while (numbers.includes(randomNumber)) {
                    randomNumber = Math.floor(Math.random() * 49) + 1;
                }
                input.value = randomNumber;
                numbers.push(randomNumber);
            });
            starInputs.forEach(function(input) {
                let randomStar = Math.floor(Math.random() * 9) + 1;
                while (stars.includes(randomStar)) {
                    randomStar = Math.floor(Math.random() * 9) + 1;
                }
                input.value = randomStar;
                stars.push(randomStar);
            });

            togglePlayButton(); // Vérifier l'état du bouton "Jouer" après génération
        });
    });

    // Écouter les événements sur tous les inputs de numéros et étoiles
    document.querySelectorAll('.number-input, .star-input').forEach(function(input) {
        input.addEventListener('input', function() {
            var inputValue = parseInt(this.value);
            var inputs = document.querySelectorAll('input[name="' + this.name + '"]');
            var values = Array.from(inputs).filter(input => input !== this).map(input => input.value.trim() !== '' ? parseInt(input.value) : null);

            if (values.includes(inputValue) && inputValue !== 0) {
                this.value = '';
                alert('Vous avez déjà sélectionné ce numéro ou cette étoile');
            }

            togglePlayButton(); // Vérifier l'état du bouton "Jouer" quand un input change
        });
    });
</script>

<?php
require('view_end.php');
?>