<?php require __DIR__ . "./header.php";
require __DIR__ . "./dbConfig.php";


$userId = $_GET['id'];

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



$sql = "SELECT firstname,id FROM users WHERE id=$userId";
$result = $PDO->query($sql);

while ($u = $result->fetch(PDO::FETCH_ASSOC)) {

    echo "<form action='./changePass.php' method='POST'>" . $u['firstname'] . " voulez vous changer de MDP ? <br>
    <input type='text' name='oldPass' placeholder='Old password'>
    <input type='password' name='newPass' placeholder='New password'>
     <input type='password' name='newPassConfirm' placeholder='Confirm password'>
     <input type='hidden' name='id' value=$userId>
    <input type='submit'>
    </form>";
}



require __DIR__ . "./footer.php";