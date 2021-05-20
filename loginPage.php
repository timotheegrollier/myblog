<?php require __DIR__ . './header.php'; ?>

<div class="login">
    <form action="./connexion.php" method="POST" id="login">
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password"><br>
        <input type="submit">
    </form>
</div>
<div id="error" style="background:red; height:30%; display:none; justify-content:center;align-items:center;">
    <h5>Erreur dans les données !</h5>
</div>
<div id="connected">
</div>
<div id="signin">
    <form id="inscription" enctype="multipart/form-data">
        <i class='fas fa-times-circle' id='exitSign'></i>

        <label for="prenom">Prénom</label>
        <input type="text" for="prenom" name="prenom" id="prenom">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom">
        <label for="pseudo">Pseudo</label>
        <input type="text" for="pseudo" name="pseudo" id="pseudo">
        <label for="mail">Email</label>
        <input type="email" for="mail" name="mail" id="mail">
        <label for="mdp">Password</label>
        <input type="password" for="mdp" name=" password" id="mdp">
        <label for="mdpConfirm">Confirm password</label>
        <input type="password" for="mdpConfirm" name="mdpConfirm" id="mdpConfirm">
        <!-- <input type="file" name="avatar"> -->

        <input type="submit" value="Inscription">
    </form>
</div>




<?php require __DIR__ . "./footer.php";