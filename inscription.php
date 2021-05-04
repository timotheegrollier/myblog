<?php
require __DIR__ . "/dbConfig.php";


// CONNEXION BDD
try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);

    // echo "Connexion &eacute;tablie <br>";
} catch (\Throwable $th) {
    throw $th;
};
$DATA = [];

$formErrors = [];
$newFileName = generateRandomString();
$extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
$bonneExtensions = ["jpg", "png", "gif", "jfif"];


function generateRandomString($length = 10)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}





if (isset($_POST)) {
    if (empty($_POST['nom']) || empty($_POST['pseudo']) || empty($_POST['prenom'])) {
        $formErrors['nom'] = " Erreur des champs sont vide ! <br>";
    }
    if (!empty($_POST['mail']) && !filter_var(($_POST['mail']), FILTER_VALIDATE_EMAIL)) {

        $formErrors['mail'] = " L'adresse email " . $_POST['mail'] .  " est considérée comme invalide. <br>";
    }


    if (empty($_POST["password"]) || strlen($_POST["password"]) < 6) {
        $formErrors['password'] = "Erreur mot de passe trop court ou vide! <br>";
    }


    if ($_POST["password"] != $_POST["mdpConfirm"]) {
        $formErrors['passwordConfirm'] = "Les mots de passes ne sont pas identiques";
    } else {
        $cryptedPass = password_hash(strip_tags($_POST["password"]), PASSWORD_DEFAULT);
        // echo $cryptedPass;
    }


    // ENVOI D'IMG

    if (!empty($_FILES)) {

        $uploads_dir = './uploads/avatar';
        if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
            // echo "File " . $_FILES['avatar']['name'] . " téléchargé avec succès.\n";
            $DATA['avatar'] = $_FILES["avatar"]["tmp_name"];
            $name = basename($_FILES["avatar"]["name"]);

            if (in_array($extension, $bonneExtensions)) {
                if ($_FILES['avatar']['size'] <= 3000000) {

                    if (!is_dir($uploads_dir)) {
                        mkdir($uploads_dir);
                    } else {
                        move_uploaded_file($DATA['avatar'], "$uploads_dir/$name");
                        rename("$uploads_dir/$name", "$uploads_dir/$newFileName.$extension");
                    }
                } else {
                    $formErrors['avatarSize'] = "Poid de l'image supérieur a la limite de 3Mo<br>";
                }
            } else {
                $formErrors['avatarExtension'] = "Mauvaise extension d'image<br>";
            }
        } else {
            echo "Attention! Aucune image. ";
        }
    }
} else {
    echo 'remplir le formulaire ! <br>';
    // var_dump($_POST);
    die();
}




if (!empty($formErrors)) {
    echo " Echec de l'inscription ! <br> ";
    foreach ($formErrors as $key => $errors) {
        echo $errors;
    }
    echo "<a href='./inscription.html'>Retour</a>";
    die;
} else {
    // var_dump($_POST);
    $DATA['prenom'] = strip_tags($_POST['prenom']);
    $DATA['nom'] = strip_tags($_POST['nom']);
    $DATA['pseudo'] = strip_tags($_POST['pseudo']);
    $DATA['mail'] = strip_tags($_POST['mail']);


    // REQUÊTE SQL


    $sql = $PDO->prepare('INSERT INTO users(firstname,lastname,pseudo,email,password,avatar) VALUES(:prenom, :nom, :pseudo,:email, :password,:avatar)');
    // 
    $sql->execute(array(
        'prenom' => $DATA['prenom'],
        'nom' => $DATA['nom'],
        'pseudo' => $DATA['pseudo'],
        'password' => $cryptedPass,
        'email' => $DATA['mail'],
        'avatar' => $uploads_dir . "/" . $newFileName . "." . $extension
    ));

    if ($sql) {
        echo 'Merci ' . $DATA['prenom'] . '! Vous êtes inscrit ! <a href="./index.php">Accueil</a>';
    }
}










var_dump($_FILES);


// var_dump($newFileName); 