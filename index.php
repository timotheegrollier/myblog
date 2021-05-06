<?php require __DIR__ . "./header.php";


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



if (isset($_SESSION['id']) and isset($_SESSION['pseudo'])) {
    echo '<h3>Bonjour ' . $_SESSION['pseudo'] . '</h3>';
}


?>
<div class="logo-container">


    <div class="logo">

    </div>
</div>


<?php
$sql = ("SELECT id,name,article,enabled FROM article");
$result = $PDO->query($sql);

echo "<div class='articleList'><h4>Derniers articles:</h4>";
while ($a = $result->fetch(PDO::FETCH_ASSOC)) {

    echo "<a href='./article?id=$a[id]'>$a[name]</a>";
}
echo "</div>"
?>





<?php require __DIR__ . "./footer.php";