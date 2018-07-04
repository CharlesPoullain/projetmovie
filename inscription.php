<?php
include ('head.php');

session_start();
$_SESSION["user"] = false;
?>
<div style="margin-left: 30%; margin-right: 30%; margin-top: 20%;">
    <div class="box">

        <h3>Inscrivez vous !</h3>
        <form action="subscribe.php" method="POST" novalidate>
            <div class="field">
                <label class="label">Identifiant</label>
                <div class="control">
                    <input class="input" name="newusername" type="text" placeholder="identifiant">
                </div>
            </div>

            <div class="field">
                <label class="label">Mot de passe</label>
                <div class="control">
                    <input class="input" name="newpassword"  type="password" placeholder="mot de passe">
                </div>
            </div>

            <div class="field">
                <label class="label">Confirmer le Mot de passe</label>
                <div class="control">
                    <input class="input" name="confirmpassword"  type="password" placeholder="mot de passe">
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-primary">S'inscrire</button>
                    <a class="button is-primary" href="auth.php">Connexion</a>
                </div>

            </div>

        </form>
    </div>
</div>