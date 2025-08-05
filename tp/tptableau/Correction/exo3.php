<?php
require 'tp2q1.php';

echo '<ul>';

foreach ($personnes as $nom => $infos) {
    echo '<li>Élément ' . htmlspecialchars($nom) . '<ul>';

    foreach ($infos as $index => $info) {
        echo '<li>Élément ' . $index . ' : ' . htmlspecialchars($info) . '</li>';
    }

    echo '</ul></li>';
}

echo '</ul>';
