<?php
require('view_begin.php');
?>

<form method="post" action="?controller=lottery&action=simulation">
<input type="number" name="NbBot" min='1' max='100' id="nbBot">
<input type="submit" value="Simuler">
</form>

<?php
require('view_end.php');
?>