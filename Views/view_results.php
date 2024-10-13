<?php
require('view_begin.php');

?>
<h1><?= $data['tirageLoto'] ?></h1>

<table>
    <thead>
        <tr>
            <th>Place</th>
            <th>Pseudo</th>
            <th>Grille</th>
            <th>Gain</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($data['listPlayer'] as $ligne):
        ?>
            <tr>
                <td><?= $i ?></td>
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