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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
    <script src="./script.js" defer></script>

</head>

<body>
    <header>
        <nav>
            <ul class="menu">
                <a href="index.php">
                    <li>Home</li>
                </a>


                <?php if (isset($_SESSION['prenom'])) {
                    echo "  <a href='tagsList.php'>
<li>TAG & Catégories</li>
</a>

<a href='./users.php'>
<li>Users</li>
</a>";
                }
                ?>

                <?php if (!isset($_SESSION['prenom'])) {
                    echo "<li id='signin'>Inscription</li>
                <a href='./loginPage.php'>
                    <li>Connexion</li>
                </a>";
                }
                if (isset($_SESSION['prenom'])) {
                    echo
                    "<a href='./deconnexion.php'>
                    <li>Déconnexion</li>
                </a><a href='./editUsers.php?id=$_SESSION[prenom]'></a>";
                }
                ?>

                <?php if (!empty($_SESSION['avatar'])) {
                ?><img class="profile-pic" src=<?= $_SESSION['avatar'] ?> alt="profile-pic"><?php
                                                                                        }
                                                                                            ?>
            </ul>

        </nav>
    </header>
    <main>