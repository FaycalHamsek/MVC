<?php 
require('view_begin.php');
?>
<h1>
    Ajouter un joueur
</h1>

<form action="?controller=set&action=add" method="post">
    <label for="name">Nom:</label>
    <input type="text" id="name" name="name" required><br><br>
    
    <label for="nickname">Pseudo:</label>
    <input type="text" id="nickname" name="nickname" required><br><br>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="phone">Téléphone:</label>
    <input type="tel" id="phone" name="phone" required><br><br>
    
    <p><input type="submit" value="Ajouter"></p>
</form>

<?php
require('view_end.php');
?>