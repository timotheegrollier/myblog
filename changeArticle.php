<?php require __DIR__ . "./dbConfig.php";

// CONNEXION BDD
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


$articleId = $_POST['id'];
$sql = $PDO->prepare("UPDATE article SET name = :articleName , article = :newArticle, image = :articleImage WHERE id=$articleId");
$sql2 = ("SELECT name , article,image FROM article WHERE id=$articleId");
$result = $PDO->query($sql2);
$formErrors = [];
$DATA = [];
$newFileName = generateRandomString();
$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
$bonneExtensions = ["jpg", "png", "gif", "jfif"];


function generateRandomString($length = 10)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}




while ($a = $result->fetch(PDO::FETCH_ASSOC)) {




    if (!empty($_POST['articleName'])) {
        if (strlen($_POST['articleName']) > 3) {
            $DATA['name'] = strip_tags($_POST['articleName']);
        } else {
            $formErrors['name'] = "Erreur le nom d'article est trop court ! ";
        }
    } else {
        $DATA["name"] = $a["name"];
    }
    if (!empty($_POST['newArticle'])) {
        if (strlen($_POST['newArticle']) > 6) {
            $DATA['article'] = strip_tags($_POST['newArticle']);
        } else {
            $formErrors['article'] = "L'article est trop court pour être publié !";
        }
    } else {
        $DATA['article'] = $a["article"];
    }

    // UPLOAD D'IMAGES



    if (!isset($a['image'])) {
        $DATA['image'] = $a['image'];
    }

    $uploads_dir = './uploads/articleImages';
    var_dump($_FILES['image']);
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
        // echo "File " . $_FILES['image']['name'] . " téléchargé avec succès.\n";
        $DATA['image'] = $_FILES["image"]["tmp_name"];
        $name = basename($_FILES["image"]["name"]);

        if (in_array($extension, $bonneExtensions)) {
            if ($_FILES['image']['size'] <= 3000000) {

                if (!is_dir($uploads_dir)) {
                    mkdir($uploads_dir);
                } else {
                    move_uploaded_file($DATA['image'], "$uploads_dir/$name");
                    rename("$uploads_dir/$name", "$uploads_dir/$newFileName.$extension");
                    $DATA['image'] = "$uploads_dir/$newFileName.$extension";
                }
            } else {
                $formErrors['imageSize'] = "Poid de l'image supérieur a la limite de 3Mo<br>";
            }
        } else {
            $formErrors['imageExtension'] = "Mauvaise extension d'image<br>";
        }
    } else {
        $DATA["image"] = $a['image'];
    }



    var_dump($DATA);
    if (empty($formErrors)) {
        $sql->execute(array(
            'articleName' => $DATA["name"],
            'newArticle' => $DATA["article"],
            'articleImage' => $DATA["image"]
        ));
    } else {
        foreach ($formErrors as $key => $error) {
            echo $error;
            echo "<br><a href=./article.php?id=$articleId>Retour</a>";

            die();
        }
    }
}






if ($sql) {
    header("location: ./article.php?id=$articleId");
    exit();
}