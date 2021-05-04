<?php require __DIR__ . './dbConfig.php';


$userId = $_GET['id'];

var_dump($userId);

try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);

    echo "Connexion &eacute;tablie<br>";
} catch (\Throwable $th) {
    throw $th;
};


$sql = "DELETE FROM users WHERE id=$userId";

$result = $PDO->query($sql);


if ($sql) {
    echo 'Utilisateur supprimer';
    header('Location: ./users.php');
    exit();
} else {
    echo 'Erreur';
}