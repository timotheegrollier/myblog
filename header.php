<?php session_start();
require __DIR__ . "./dbConfig.php";



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBlog PHP</title>
    <link rel="stylesheet" href="./style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


</head>

<body>
    <header>
        <nav>
            <ul class="menu">
                <a href="index.php">
                    <li>Home</li>
                </a>


                <?php if (isset($_SESSION['id'])) {
                    echo "  <a href='tagsList.php'>
<li>TAG & Catégories</li>
</a>

<a href='./users.php'>
<li>Users</li>
</a>";
                }
                ?>

                <?php if (!isset($_SESSION['id'])) {
                    echo "<a href='./inscription.html'>
                    <li>Inscription</li>
                </a><a href='./loginPage.php'>
                    <li>Connexion</li>
                </a>";
                }

                if (isset($_SESSION['id'])) {
                    echo
                    "<a href='./deconnexion.php'>
                    <li>Déconnexion</li>
                </a><a href='./editUsers.php?id=$_SESSION[id]'><img src=$_SESSION[avatar] class='profile-pic'></a>";
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>