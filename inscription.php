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
// $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
$bonneExtensions = ["jpg", "png", "gif", "jfif"];

function generateRandomString($length = 10)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}





if (isset($_POST)) {
    if (empty($_POST['nom']) || empty($_POST['pseudo']) || empty($_POST['prenom'])) {
        $formErrors['nom'] = " Erreur des champs sont vide ! ";
    }
    if (!empty($_POST['mail']) && !filter_var(($_POST['mail']), FILTER_VALIDATE_EMAIL)) {

        $formErrors['mail'] = " L'adresse email " . $_POST['mail'] .  " est considérée comme invalide. ";
    }


    if (empty($_POST["password"]) || strlen($_POST["password"]) < 6) {
        $formErrors['password'] = "Erreur mot de passe trop court ou vide! ";
    }


    if ($_POST["password"] != $_POST["mdpConfirm"]) {
        $formErrors['passwordConfirm'] = "Les mots de passes ne sont pas identiques";
    } else {
        $cryptedPass = password_hash(strip_tags($_POST["password"]), PASSWORD_DEFAULT);
        // echo $cryptedPass;
    }

    // VERIF SI USER DEJA INSCRIT EN BDD

    $sql2 = ("SELECT pseudo FROM users WHERE pseudo='$_POST[pseudo]'");
    $sql3 = ("SELECT email FROM users WHERE email='$_POST[mail]'");
    $result = $PDO->query($sql2);
    $result2 = $PDO->query($sql3);
    while ($pseudo = $result->fetch(PDO::FETCH_ASSOC)) {
        if (isset($pseudo)) {
            $formErrors["inscrit"] = "Pseudo ou e-mail déja utilisée !";
        }
    }
    while ($email = $result2->fetch(PDO::FETCH_ASSOC)) {
        if (isset($email)) {
            $formErrors["inscrit"] = "Pseudo ou e-mail déja utilisée !";
        }
    }




    // ENVOI D'IMG

    if (!empty($_FILES)) {
        var_dump($_FILES);

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
                    $formErrors['avatarSize'] = "Poid de l'image supérieur a la limite de 3Mo";
                }
            } else {
                $formErrors['avatarExtension'] = "Mauvaise extension d'image";
            }
        } else {
            echo "Attention! Aucune image. ";
        }
    }
} else {
    echo 'remplir le formulaire ! ';
    // var_dump($_POST);
    die();
}






if (!empty($formErrors)) {
    $response = [
        'status' => 'ko',
        'messages' => $formErrors
    ];
    echo json_encode($response);
} else {
    // var_dump($_POST);
    $DATA['prenom'] = strip_tags($_POST['prenom']);
    $DATA['nom'] = strip_tags($_POST['nom']);
    $DATA['pseudo'] = strip_tags($_POST['pseudo']);
    $DATA['mail'] = strip_tags($_POST['mail']);

    // REQUÊTE SQL


    $sql = $PDO->prepare('INSERT INTO users(firstname,lastname,pseudo,email,password) VALUES(:prenom, :nom, :pseudo,:email, :password)');


    // 
    $sql->execute(array(
        'prenom' => $DATA['prenom'],
        'nom' => $DATA['nom'],
        'pseudo' => $DATA['pseudo'],
        'password' => $cryptedPass,
        'email' => $DATA['mail'],
        // 'avatar' => $uploads_dir . "/" . $newFileName . "." . $extension
    ));

    if ($sql) {
        $response =  [
            'status' => 'ok',
            'message' => 'Merci ' . $DATA['prenom'] . '! Vous êtes inscrit !',
        ];
        echo json_encode($response);
        session_start();
        $_SESSION['mail'] = $DATA['mail'];
        $_SESSION['prenom'] =  $DATA['prenom'];
    }
}










// var_dump($_FILES);


// var_dump($newFileName); 