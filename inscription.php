<?php
require __DIR__ . "/dbConfig.php";
$formError = false;


if (isset($_POST) && ($_POST != NULL)) {
} else {
    echo 'remplir le formulaire ! <br>';
    var_dump($_POST);
}

if (empty($_POST['nom']) || empty($_POST['pseudo']) || empty($_POST['prenom']) || empty($_POST['mail'])) {
    echo " Erreur des champs sont vide ! <br>";
}

if ($_POST['mail'] == NULL) {
    echo "Veuillez rentrez une adresse email ! <br>";
} else {

    if (filter_var(($_POST['mail']), FILTER_VALIDATE_EMAIL)) {
    } else {
        echo " L'adresse email " . $_POST['mail'] .  " est considérée comme invalide. <br>";
        $formError = true;
    }
}


if ($_POST["password"] != $_POST["mdpConfirm"]) {
    echo " Les mots de passe ne correspondent pas ! <br> ";
    $formError = true;
} else {
    if ($_POST['password'] != NULL || !empty($_POST["password"])) {
        $cryptedPass = password_hash($_POST["password"], PASSWORD_DEFAULT);
        echo $cryptedPass;
    }
}



if (strlen($_POST["password"]) < 6) {
    echo "Erreur mot de passe ! <br>";
    $formError = true;
}


if ($formError) {
    echo " Echec de l'inscription ! <br> ";
} else {
    var_dump($_POST);
    $DATA['prenom'] = strip_tags($_POST['prenom']);
    $DATA['nom'] = strip_tags($_POST['nom']);
    $DATA['pseudo'] = strip_tags($_POST['pseudo']);
    $DATA['mail'] = strip_tags($_POST['mail']);
}


// CONNEXION BDD
try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);

    echo "Connexion &eacute;tablie <br>";
} catch (\Throwable $th) {
    throw $th;
};

// 


$sql = $PDO->prepare('INSERT INTO users(firstname,lastname,pseudo,email,password) VALUES(:prenom, :nom, :pseudo,:email, :password)');





$sql->execute(array(
    'prenom' => $DATA['prenom'],
    'nom' => $DATA['nom'],
    'pseudo' => $DATA['pseudo'],
    'password' => $cryptedPass,
    'email' => $DATA['mail']
));

if ($sql) {
    echo 'Merci ' . $DATA['prenom'] . '! Vous êtes inscrit ! <a href="./index.php">Accueil</a>';
}