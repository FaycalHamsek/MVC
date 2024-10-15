<?php
require('view_begin.php');
?>
<form method="post" action="?controller=lottery&action=simulation">
    <input type="number" name="NbBot" min='1' max='100' id="nbBot" class="form-control">
    <input type="submit" value="Simuler" id="simulateButton" class="btn btn-primary" disabled>
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