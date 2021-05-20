<?php require __DIR__ . './dbConfig.php';
session_start();

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


if ($userId == $_SESSION['id']) {
    $error = 1;
}
?>
<?php
if ($sql) {
    if (!$error) {
        $result = $PDO->query($sql);
        echo 'Utilisateur supprimer';
        header('Location: ./users.php');
        exit();
    } else { ?>
<h5>Vous ne pouvez pas supprimez ce compte ! <a href="./users.php">Retour</a></h5>
<?php
    }
} else {
    echo 'Erreur';
}