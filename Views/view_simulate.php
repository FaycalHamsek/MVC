<?php
require('view_begin.php');
?>
<button onclick="window.location.href='?controller=home&action=home'">Menu</button>

<form method="post" action="?controller=lottery&action=simulation">
    <input type="number" name="NbBot" min='1' max='100' id="nbBot">
    <input type="submit" value="Simuler" id="simulateButton" disabled>
</form>

<script>
    const nbBotInput = document.getElementById('nbBot');
    const simulateButton = document.getElementById('simulateButton');

    nbBotInput.addEventListener('input', function() {
        simulateButton.disabled = nbBotInput.value === '' || nbBotInput.value <= 0; // Désactive si input vide ou <= 0
    });
</script>
<?php
require('view_end.php');
?>