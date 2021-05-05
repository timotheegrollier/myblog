<?php
require __DIR__ . "./header.php";
require __DIR__ . "./dbConfig.php";

$DATA = [];
$formErrors = [];

// CONNEXION BDD 

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

$userId = $_POST['id'];

$sql = $PDO->prepare('UPDATE users SET firstname = :newFirstname, lastname = :newLastname, pseudo= :newPseudo , email = :newEmail , avatar = :newAvatar WHERE id = :userId');

$sql2 = "SELECT id,firstname,lastname,pseudo,email,avatar FROM users WHERE id=$userId";
$result = $PDO->query($sql2);




// FETCH LA BDD
while ($u = $result->fetch(PDO::FETCH_ASSOC)) {
    $DATA['prenom'] = $u['firstname'];
    $DATA['nom'] = $u['lastname'];
    $DATA['pseudo'] = $u['pseudo'];
    $DATA['mail'] = $u['email'];
    $DATA['changeAvatar'] = $u['avatar'];
}

// UPLOAD VAR
$newFileName = generateRandomString();
$extension = pathinfo($_FILES['changeAvatar']['name'], PATHINFO_EXTENSION);
$bonneExtensions = ["jpg", "png", "gif", "jfif"];


// RANDOMSTRING 
function generateRandomString($length = 10)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

// UPLOAD IMAGE

// var_dump($_FILES);
if (!empty($_FILES)) {
    $uploads_dir = './uploads/avatar';

    if (is_uploaded_file($_FILES['changeAvatar']['tmp_name'])) {
        // echo "File " . $_FILES['changeAvatar']['name'] . " téléchargé avec succès.\n";
        $tmp_name = $_FILES["changeAvatar"]["tmp_name"];
        $name = basename($_FILES["changeAvatar"]["name"]);
        if (in_array($extension, $bonneExtensions)) {
            if ($_FILES['changeAvatar']['size'] <= 3000000) {
                if (!is_dir($uploads_dir)) {
                    mkdir($uploads_dir);
                } else {
                    move_uploaded_file($tmp_name, "$uploads_dir/$name");
                    rename("$uploads_dir/$name", "$uploads_dir/$newFileName.$extension");
                    $DATA['changeAvatar'] = $uploads_dir . "/" . $newFileName . "." . $extension;
                }
            } else {
                $formErrors['avatarSize'] = "Erreur ! Poid de l'image supérieur a la limite de 3Mo<br>";
            }
        } else {
            $formErrors['avatarExtension'] = "Mauvaise extension d'image<br>";
        }
    } else {
        echo "Attention! aucune image upload . ";
    }
}







// FORM CONTROL 

if (isset($_POST)) {





    if (!empty($_POST['changeEmail'])) {
        if (!filter_var($_POST['changeEmail'], FILTER_VALIDATE_EMAIL)) {
            $formErrors['mail'] = " L'adresse email " . $_POST['changeEmail'] .  " est considérée comme invalide. <br>";
        } else {
            $DATA['mail'] = strip_tags($_POST['changeEmail']);
        }
    }


    if (!empty($_POST['changeFirstname'])) {
        if (strlen($_POST['changeFirstname']) < 3) {
            $formErrors['prenom'] = "Entrez un prénom valide au moins 3 lettres !";
        } else {
            $DATA['prenom'] = strip_tags($_POST['changeFirstname']);
        }
    }
    if (!empty($_POST['changeLastname'])) {
        if (strlen($_POST['changeLastname']) < 3) {
            $formErrors['nom'] = "Entrez un prénom valide au moins 3 lettres !";
        } else {
            $DATA['nom'] = strip_tags($_POST['changeLastname']);
        }
    }
    if (!empty($_POST['changePseudo'])) {
        if (strlen($_POST['changePseudo']) < 4) {
            $formErrors['pseudo'] = "Entrez un pseudo valide au moins 3 lettres !";
        } else {
            $DATA['pseudo'] = strip_tags($_POST['changePseudo']);
        }
    }



    if (!empty($formErrors)) {
        foreach ($formErrors as $key => $errors) {
            echo $errors;
            die;
        }
    } else {

        $sql->execute(array(
            'newFirstname' => $DATA['prenom'],
            'newLastname' => $DATA['nom'],
            'newPseudo' => $DATA['pseudo'],
            'newEmail' => $DATA['mail'],
            'userId' => $userId,
            'newAvatar' => $DATA['changeAvatar']
        ));
        echo 'Merci ' . $DATA['prenom'] . '<br>Les informations ont été modifié !';
        header('Location: ./users.php');
        exit();
    }



    // REPRENDRE AVANT LA REQ SQL
}










require __DIR__ . "./footer.php";