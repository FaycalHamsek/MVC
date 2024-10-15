<?php
require('view_begin.php');
?>
<div class="h-100 d-flex flex-column align-items-center justify-content-center">
    <!-- Ajoute l'image ici -->
    <img src="Content\img\lotologo2.png"  class="img-fluid mb-4" /> <!-- Remplace "ton_image.jpg" par le nom de ton image -->
    
    <h1 class="text-center mb-4">
        Bienvenue pour la Loterie
    </h1>
    <h2 class="text-center mb-4">
        3 millions d'euros à départager !
    </h2>
    <div class="d-flex gap-3"> <!-- Ajoute un espacement entre les boutons -->
        <button class="btn btn-primary">
            <a href="?controller=play&action=play" class="text-white text-decoration-none">Jouer</a>
        </button>
        <button class="btn btn-secondary">
            <a href="?controller=lottery&action=bot" class="text-white text-decoration-none">Simuler</a>
        </button>
    </div>
</div>

<?php
require('view_end.php');
?>
