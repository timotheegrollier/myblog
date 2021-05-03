<?php require __DIR__ . "./dbConfig.php";

$oldTag = $_GET['oldTag'];

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


var_dump($_GET);

if (!isset($_GET['newTag'])  || !isset($_GET['id']) || empty($_GET['id'])) {
    echo "Erreur ! Veuillez rentrez un nom de tag valide";
} else {
    if (isset($_GET['enabled'])) {
        $enabled = 1;
    } else {
        $enabled = 0;
    }
    $newTag = strip_tags($_GET['newTag']);
    if (empty($newTag)) {
        $newTag = $oldTag;
    }
    $sql = "UPDATE tags SET name = '$newTag',enabled = $enabled  WHERE id=$_GET[id]";
    $result = $PDO->query($sql);
    if ($sql) {
        echo "Changé !";
        echo "<br><a href='./tagsList.php'>Retour</a>";
    }
}