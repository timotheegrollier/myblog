<?php require __DIR__ . "./dbConfig.php";


$tagName = $_GET['newTag'];
if (isset($_GET['enabled'])) {
    $active = 1;
} else {
    $active = 0;
}



try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);
} catch (\Throwable $th) {
    throw $th;
};



if (!isset($_GET['newTag']) || empty($_GET['newTag'])) {
    echo "Erreur entrez un nom de tag";
} else {
    var_dump($tagName);
    if (isset($_GET['enabled'])) {
        echo 'Le tag sera activé!';
    } else {
        echo "Attention le tag sera desactivé";
    }
    $sql = $PDO->prepare('INSERT INTO tags(name,enabled) VALUES(:tagName, :active)');
    $sql->execute(array(
        'tagName' => $tagName,
        'active' => $active
    ));

    if ($sql) {
        echo "<br>Tag crée !<br><a href='./tagsList.php'>Retour</a>";
    }
}