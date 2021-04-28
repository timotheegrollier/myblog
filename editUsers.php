<?php require __DIR__ . "./header.php";
require __DIR__ . "./dbConfig.php";
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
$userId = ($_GET['id']);

$sql = "SELECT id,firstname,lastname,pseudo,email FROM users WHERE id=$userId";

$result = $PDO->query($sql);

if (isset($_GET) && !empty($_GET)) {
} else {
    echo "<br> Erreur !";
}
while ($u = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<br> Bonjour :" . $u['firstname'] . "<br>";
}




require __DIR__ . "./footer.php";