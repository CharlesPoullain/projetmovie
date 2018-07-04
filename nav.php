<?php

if($_SESSION['user']) {
    $username = $_SESSION['user']['username'];
}

?>

<nav class="navbar is-primary" role="navigation" aria-label="dropdown navigation">
    <a class="navbar-item" href="index.php">
        <span class="icon is-large">
            <i style="width: 30px; height: 30px;" class="fas fa-film"></i>
        </span>
    </a>
    <div class="navbar-item">
        <a class="navbar">
            <a class="button is-primary" href="movielist.php">
                List des Films
            </a>
        </a>
    </div>
    <div class="navbar-item">
        <a  class="navbar">
            <a class="button is-primary"  href="favorits.php">
                Favoris
            </a>
        </a>
    </div>
    <div class="navbar-item">
        <a  class="navbar">
            <a class="button is-primary"  href="watchlist.php">
                Watchlist
            </a>
        </a>
    </div>
    <div class="navbar-item">
        <a class="navbar">
            <a class="button is-primary" href="contact.php">
                Contact
            </a>
        </a>
    </div>
    <div class="navbar-item">
        <a  class="navbar">
            <a class="button is-primary"  href="faq.php">
                Faq
            </a>
        </a>
    </div>
    <div class="navbar-end">
        <div class="navbar-item">
            User connecté : <?= $username; ?>
        </div>
        <div class="navbar-item">
            <a class="navbar">
                <a class="button is-link" href="auth.php">
                    Déconnexion
                </a>
            </a>
        </div>
        <div class="navbar-item">
            <div class="field is-grouped">
                <h1 style="font-size: x-large;">Movie</h1>
            </div>
        </div>
    </div>
</nav>