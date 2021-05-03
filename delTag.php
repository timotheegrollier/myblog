<?php

require __DIR__ . './dbConfig.php';

$tagId = $_GET['id'];


try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);

    echo "Connexion &eacute;tablie";
} catch (\Throwable $th) {
    throw $th;
};

$sql = "DELETE FROM tags WHERE id=$tagId";
$result = $PDO->query($sql);

if ($sql) {
    echo "<br>Tag supprimé";
    header('Location: ./tagsList.php');
    exit();
} else {
    echo "Erreur ! <br> <a href='./tagsList.php'>Retour</a>";
}