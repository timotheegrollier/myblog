<?php require __DIR__ . "./header.php";



if (isset($_SESSION['id']) and isset($_SESSION['pseudo'])) {
    echo 'Bonjour ' . $_SESSION['pseudo'];
}


?>
<div class="logo-container">


    <div class="logo">

    </div>
</div>








<?php require __DIR__ . "./footer.php";