<?php require __DIR__ . './dbConfig.php';

$userId = $_POST['id'];
$active = 0;
$newCat = $_POST['oldCat'];

// CONNEXION BDD

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


if (isset($_POST['active'])) {
    $active = 1;
}


// REQUETE SI INPUT VIDE POUR ACTIVER OU DESACTIVER LA CAT

$sql = "UPDATE category SET name ='$newCat' ,enabled = $active WHERE id=$userId";
$result = $PDO->query($sql);



if (!empty($_POST['newCat'])) {
    $newCat = strip_tags($_POST['newCat']);



    if (strlen($newCat) < 8) {
        $sql = "UPDATE category SET name ='$newCat' ,enabled = $active WHERE id=$userId";
        $result = $PDO->query($sql);
    } else {
        echo "Nom trop long";
    }
}

if ($sql) {
    header('Location: ./tagsList.php');
    exit();
}