<?php
require('view_begin.php');

?>
<h1 class="text-center"><?= $data['tirageLoto'] ?></h1>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Place</th>
            <th scope="col">Pseudo</th>
            <th scope="col">Grille</th>
            <th scope="col">Gain</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['listPlayer'] as $ligne):
        ?>
            <tr>
                <th scope="row"><?= $i ?></th>
                <td><?= $ligne['nickname'] ?></td>
                <td><?= $ligne['grille'] ?></td>
                <td><?= $ligne['gain'] ?></td>
            </tr>
        <?php
            $i++;
        endforeach; ?>
    </tbody>
</table>

<?php
require('view_end.php');
?>