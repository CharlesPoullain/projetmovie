<?php
include ('head.php');

session_start();
$_SESSION["user"] = false;
?>
<div style="margin-left: 30%; margin-right: 30%; margin-top: 20%;">
    <div class="box">

        <h3>Connectez vous !</h3>
        <form action="connect.php" method="POST" novalidate>
            <div class="field">
                <label class="label">Identifiant</label>
                <div class="control">
                    <input class="input" name="username" type="text" placeholder="identifiant">
                </div>
            </div>

            <div class="field">
                <label class="label">Mot de passe</label>
                <div class="control">
                    <input class="input" name="password"  type="password" placeholder="mot de passe">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-primary">Se connecter</button>
                    <a class="button is-primary" href="inscription.php">Inscription</a>
                </div>

            </div>

        </form>

    </div>
</div>