<!DOCTYPE html>
<html>
<?php
include ('session.php');

include ('head.php');
//paramètres de connexion en constantes

$res = $dbh->query('SELECT * FROM movie ORDER BY title ASC');

if(!empty($_GET["show-message"])) {
    ?>
    <div id="popover" class="notification is-danger">
        <button onclick="hide()"  class="delete"></button>
        Message envoyé !
    </div>
    <?php
}

if($_SESSION['user']) {
    $userid = $_SESSION['user']['id'];
    $userres = $dbh->query("SELECT * FROM movie_like WHERE user_id = $userid");
    $favorit = $userres->fetchAll();
}

if(!empty($_GET["film"])) {
    $film = $_GET["film"];
    $res = $dbh->query("SELECT * FROM movie WHERE title LIKE '%$film%' ORDER BY id DESC");
}

if(!empty($_GET["actor"])) {
    $actor = $_GET["actor"];
    $res = $dbh->query("SELECT * FROM movie WHERE actors LIKE '%$actor%' ORDER BY id DESC");
}
?>

<body>

<?php
include ('nav.php');

?>

<h1 style="text-align: center; font-size: 40px;">Watchlist</h1>

<div class="columns gradientPrimary is-gapless is-multiline" style="padding-top: 40px;">
    <?php
    while ($data = $res->fetch()) {
        $islike = false;
        foreach ($favorit as $fav) {
            if ($fav['movie_id'] == $data['id'] && $fav['watch_list'] == 1) {
                ?>
                <div id="main" class="column" style="margin-right: 25px; margin-left: 25px; margin-bottom: 50px;">
                    <div id="child" class="box"
                         style="text-align: center;  max-width: 250px;  min-width: 250px;  height: 600px; position: relative;">
                        <strong>Film</strong> :
                        <div id="title"><?= $data['title']; ?></div>
                        <br>
                        <em>Année de sortie : <?= $data['year']; ?> </em><br>
                        <a href="detail.php?id=<?= $data['id']; ?>">
                            <img class="hoverposter" src="./posters/<?= $data['image']; ?>"/>
                        </a>
                        <div>
                            <?php $nbstars = round($data['rating']);
                            for ($i = 0; $i < $nbstars; $i++) {
                                ?>
                                <i style="color: #ffe31b; width: 10px;" class="fas fa-star"></i>
                                <?php
                            }
                            ?>
                            <?php $nbemptystars = 10 - round($data['rating']);
                            for ($i = 0; $i < $nbemptystars; $i++) {
                                ?>
                                <i style="width: 10px;" class="far fa-star"></i>
                                <?php
                            }
                            ?>
                        </div>
                        <p>Genre : <?= $data['genres']; ?></p><br>
                    </div>
                </div>
                <?php
            }
        }
    }
    $res->closeCursor();

    ?>
</div>
</body>
</html>

<script>
    function hide() {
        document.getElementById("popover").style.display = 'none';
    }
</script>

