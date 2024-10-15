<?php
require('view_begin.php');
?>
<h1>
    Bienvenue pour la Loterie
</h1>
<div class="h-100 d-flex align-items-center justify-content-center">
    <button><a href="?controller=play&action=play">Jouer</a></button>
    <button><a href="?controller=lottery&action=bot">Simuler</a></button>
</div>

<?php
require('view_end.php');
?>
