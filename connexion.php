<?php require __DIR__ . "./dbConfig.php";


var_dump($_POST);
$pseudo = strip_tags($_POST['pseudo']);


try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);

    // echo "Connexion &eacute;tablie<br>";
} catch (\Throwable $th) {
    throw $th;
};


$sql = $PDO->prepare("SELECT id ,password,avatar,firstname,email FROM users WHERE pseudo = :pseudo");
$sql->execute(array(
    'pseudo' => $pseudo
));
$resultat = $sql->fetch();




// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);


if (!$resultat) {
    echo 'Mauvais identifiant ou mot de passe !';
} else {
    if ($isPasswordCorrect) {
        session_start();
        echo "Bon mot de passe ! <br> ";
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['avatar'] = $resultat['avatar'];
        $_SESSION['prenom'] = $resultat['firstname'];
        $_SESSION['mail'] = $resultat['email'];
        header('Location: ./index.php');
        exit();
        echo "Vous êtes connécté ! ";
    } else {
        echo 'Mauvais identifiant ou mot de passe !';
        echo "<a href='./loginPage.php'>Retour</a>";
    }
}