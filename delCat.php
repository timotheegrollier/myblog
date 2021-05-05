<?php require __DIR__ . "./dbConfig.php";

$catId = $_GET['id'];
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

$sql = "DELETE FROM category WHERE id=$catId";
$result = $PDO->query($sql);

if ($sql) {
    echo "<br>Category supprimé";
    header('Location: ./tagsList.php');
    exit();
} else {
    echo "Erreur ! <br> <a href='./tagsList.php'>Retour</a>";
}