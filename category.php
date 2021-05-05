<?php require __DIR__ . "./dbConfig.php";


$active = 0;

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




if (isset($_POST['active'])) {
    $active = 1;
}


$category = strip_tags($_POST['category']);

if (!empty($category)) {
    // On verifie si la catégorie existe déja en BDD
    $sql = "SELECT name FROM category";
    $result = $PDO->query($sql);
    while ($c = $result->fetch(PDO::FETCH_ASSOC)) {
        if (in_array($category, $c)) {
            $same = 1;
        } else {
            $same = 0;
        }
    }

    if (strlen($category) < 10) {
        if ($same != 1) {

            $sql2 = $PDO->prepare('INSERT INTO category(name,enabled) VALUES(:catName, :active)');
            $sql2->execute(array(
                'catName' => $category,
                'active' => $active
            ));
            header("location:./tagsList.php");
            exit;
        } else {
            echo "Le nom de catégorie éxiste déja";
        }
    } else {
        echo "<br>Nom de catégorie trop long";
    }
}