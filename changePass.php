<?php
require __DIR__ . "./dbConfig.php";


try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);
} catch (\Throwable $th) {
    throw $th;
};



$userId = $_POST['id'];

if (!isset($_POST['id']) || empty($_POST['id']) || !isset($_POST['oldPass']) || empty($_POST['oldPass']) || !isset($_POST['newPass']) || empty($_POST['newPass'])) {
    echo " Erreur ! <br> <a href='./users.php'>Retour</a>";
    var_dump($_POST);
}



$DATA['newPass'] = strip_tags($_POST['newPass']);
$DATA['oldPass'] = strip_tags($_POST['oldPass']);
$DATA['newPassConfirm'] = strip_tags($_POST['newPassConfirm']);



if (strlen($DATA['newPass']) < 6) {

    echo "Erreur mot de passe trop court <br>";
    echo "<a href='./users.php'>Retour</a>";
    die();
}




$newPass = password_hash($DATA["newPass"], PASSWORD_DEFAULT);

$sql = "SELECT password FROM users WHERE id=$userId";
$sql2 = "UPDATE users SET password='$newPass' WHERE id=$userId";


$result = $PDO->query($sql);

while ($u = $result->fetch(PDO::FETCH_ASSOC)) {
    $oldPass = false;
    if (password_verify($DATA['oldPass'], $u['password'])) {
        echo "Bravo votre ancien mdp est exact <br>";
        $oldPass = true;
    } else {
        echo "Erreur ce n'est pas votre ancien mdp !<br>";
        echo "<br> <a href='./users.php'>Retour</a>";
    }
    if ($oldPass) {
        if (($DATA['newPass']) === ($DATA['newPassConfirm'])) {
            $password = $PDO->query($sql2);
            if ($password) {
                echo "Le MDP à été changer";
                echo "<br> <a href='./users.php'>Retour</a>";
            }
        } else {
            echo "Erreur les mdp ne correspondent pas";
            echo "<br> <a href='./users.php'>Retour</a>";
        }
    }
}