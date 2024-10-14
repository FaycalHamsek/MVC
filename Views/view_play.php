<?php
require('view_begin.php');
?>
<button onclick="window.location.href='?controller=home&action=home'">Menu</button>


<form action="?controller=lottery&action=jouer" method="post">
    <table>
        <thead>
            <tr>
                <th>Select</th>
                <th>Pseudo</th>
                <th>Numéros</th>
                <th>Etoiles</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($play as $p) { #récupère les infos de notre BDD
                echo "<tr>";
                echo "<td><input type='checkbox' class='player-checkbox' idPlayer='" . $p['id'] . "'></td>"; #on créé l'id pour que le JS récupère
                echo "<td>" . htmlspecialchars($p['nickname'] ?? '') . "</td>";
                echo "<td>";
                for ($i = 1; $i <= 5; $i++) { # on boucle 5 fois pour les 5 input, je créé dans le tableau Loto + ID du joueur un tableau où je mets les 5 valeurs dedans
                    echo "<input type='number' class='number-input' name='loto[" . $p['id'] . "][number][]' min='1' max='49' value='" . htmlspecialchars($p["number$i"] ?? '') . "' disabled>";
                }
                echo "</td>";
                echo "<td>";
                for ($i = 1; $i <= 2; $i++) { #on boucle 2 fois pour les 2 input, je créé dans le tableau Loto + ID du joueur un tableau où je mets les 5 valeurs dedans
                    echo "<input type='number' class='star-input' name='loto[" . $p['id'] . "][stars][]' min='1' max='9' value='" . htmlspecialchars($p["star$i"] ?? '') . "' disabled>";
                }
                echo "</td>";
                echo "<td>";
                echo "<button type='button' class='generate-button' idPlayer='" . $p['id'] . "' generate=generate" . $p['id'] . " disabled>Générer</button>"; # bouton généré
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <input type="submit" value="Jouer" id="playButton" disabled> <!-- Bouton "Jouer" désactivé au départ -->
</form>

<button><a href="?controller=set&action=default">Ajouter un joueur</a></button>

<script>
    // Fonction pour activer ou désactiver le bouton "Jouer"
    function togglePlayButton() {
        const playButton = document.getElementById('playButton');
        const checkboxes = document.querySelectorAll('.player-checkbox');
        let isAnyChecked = false;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                isAnyChecked = true; // Au moins un joueur est sélectionné
            }
        });

        playButton.disabled = !isAnyChecked; // Activer si un joueur est sélectionné, sinon désactiver
    }

    document.querySelectorAll('.player-checkbox').forEach(function(checkbox) { // selection du joueur
        checkbox.addEventListener('change', function() {
            var idPlayer = this.getAttribute('idPlayer');
            var numberInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][number][]"]') // on selectionne dans la variable numbersInputs les input des numéros
            var starInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][stars][]"]') // on selectionne dans la variable starInputs les étoiles
            var generateButton = document.querySelector('button[generate="generate' + idPlayer + '"]'); // on selectionne dans la variable generateButton le bouton générer

            numberInputs.forEach(function(input) {
                input.disabled = !checkbox.checked; // l'input est désactivé
                if (!checkbox.checked) { // si il n'est pas coché
                    input.value = ''; // vide
                }
            });
            starInputs.forEach(function(input) {
                input.disabled = !checkbox.checked; // l'input est désactivé
                if (!checkbox.checked) { // si il n'est pas coché
                    input.value = ''; // vide
                }
            });
            generateButton.disabled = !checkbox.checked; //bouton désactivé

            togglePlayButton(); // Vérifier l'état du bouton "Jouer"
        });
    });

    document.querySelectorAll('.generate-button').forEach(function(button) { //bouton générer
        button.addEventListener('click', function() { // sur le click
            var idPlayer = this.getAttribute('idPlayer'); // pour l'idPlayer
            var numberInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][number][]"]') // on génère dans le tableau Loto+IdPlayer les 5 numéros
            var starInputs = document.querySelectorAll('input[name="loto[' + idPlayer + '][stars][]"]') // on génère dans le tableau Loto+IdPlayer les 2 étoiles

            numberInputs.forEach(function(input) {
                input.value = Math.floor(Math.random() * 49) + 1;
            });
            starInputs.forEach(function(input) {
                input.value = Math.floor(Math.random() * 9) + 1;
            });
        });
    });
</script>

<?php
require('view_end.php');
?>