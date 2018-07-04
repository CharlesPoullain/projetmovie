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
include ('main.php');

?>

<form action="" method="GET" style="margin-bottom: 40px;">
    <div class="columns" style="text-align: center">
        <div class="column is-half" style="margin-top: 40px; margin-left: 40px;">
            <div class="control has-icons-left has-icons-right">
                <input name="film" class="input is-medium" type="text" placeholder="Nom du film">
                <span class="icon is-medium is-left">
                     <i class="fas fa-search"></i>
                </span>
            </div>
            <div class="control has-icons-left has-icons-right" style="margin-top: 20px;">
                <input name="actor" class="input is-medium" type="text" placeholder="Nom d'un acteur">
                <span class="icon is-medium is-left">
                     <i class="fas fa-search"></i>
                </span>
            </div>
        </div>
        <div class="column is-half" style="margin-top: 40px;">
            <button type="submit" class="button is-primary">Rechercher</button>
        </div>
    </div>
</form>

<h1 style="text-align: center; font-size: 40px;">Liste de tout les films</h1>

<div class="columns gradientPrimary is-gapless is-multiline" style="padding-top: 40px;">
    <?php
        while ($data = $res->fetch())
        {
            ?>
            <div id="main" class="column" style="margin-right: 25px; margin-left: 25px; margin-bottom: 50px;">
                <div id="child" class="box" style="text-align: center;  max-width: 250px;  min-width: 250px;  height: 600px; position: relative;">
                    <?php
                    $islike = false;
                    foreach ($favorit as $fav) {
                        if($fav['movie_id'] == $data['id'] && $fav['is_like'] == 1 ) {
                            $islike = true;
                            ?>
                            <?php
                            break;
                        }
                    }
                    if(!$islike) {
                        ?>
                            <i style="color: black;" class="far fa-heart"></i>
                        <?php
                    }else{
                        ?>
                        <i style="color: #ff2c37;position: absolute; top: 5px; left: 5px;" class="fas fa-heart"></i>
                        <?php
                    }
                    ?>
                    <strong>Film</strong> : <div id="title"><?= $data['title']; ?></div><br>
                    <em>Année de sortie : <?= $data['year']; ?> </em><br>
                    <a href="detail.php?id=<?= $data['id']; ?>">
                        <img class="hoverposter" src="./posters/<?= $data['image']; ?>"/>
                    </a>
                    <div>
                        <?php $nbstars = round($data['rating']);
                        for($i=0; $i < $nbstars; $i++) {
                            ?>
                            <i style="color: #ffe31b; width: 10px;" class="fas fa-star"></i>
                            <?php
                        }
                        ?>
                        <?php $nbemptystars = 10-round($data['rating']);
                        for($i=0; $i < $nbemptystars; $i++) {
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

