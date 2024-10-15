<?php
require('view_begin.php');
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
                <input type="tel" id="phone" name="phone" class="form-control" required>
            </div>

            <p><input type="submit" value="Ajouter" class="btn btn-primary"></p>
        </form>
    </div>
</div>

<?php
require('view_end.php');
?>