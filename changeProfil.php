<?php
require __DIR__ . "./header.php";
require __DIR__ . "./dbConfig.php";





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

$userId = $_POST['id'];

$sql = $PDO->prepare('UPDATE users SET firstname = :newFirstname, lastname = :newLastname, pseudo= :newPseudo , email = :newEmail WHERE id = :userId');






if (!isset($_POST) || empty($_POST['changeFirstname']) || empty($_POST['changeLastname']) || empty($_POST['changePseudo']) || empty($_POST['changeEmail'])) {
    echo "erreur veuillez remplir tout les champs! <br>";
} else {
    if (filter_var($_POST['changeEmail'], FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse email " . $_POST['changeEmail'] . " est considérée comme valide.";
        var_dump($userId);
        $DATA['prenom'] = strip_tags($_POST['changeFirstname']);
        $DATA['nom'] = strip_tags($_POST['changeLastname']);
        $DATA['pseudo'] = strip_tags($_POST['changePseudo']);
        $DATA['mail'] = strip_tags($_POST['changeEmail']);
        $sql->execute(array(
            'newFirstname' => $DATA['prenom'],
            'newLastname' => $DATA['nom'],
            'newPseudo' => $DATA['pseudo'],
            'newEmail' => $DATA['mail'],
            'userId' => $userId
        ));
        echo 'Merci ' . $DATA['prenom'] . '<br>Les informations ont été modifié !';
        header('Location: ./users.php');
        exit();
    } else {
        echo "L'adresse email " . $_POST['changeEmail'] . " est considérée comme invalide.";
    }
}





require __DIR__ . "./footer.php";