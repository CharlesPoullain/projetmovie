<!DOCTYPE html>
<?php
include ('session.php');


include ('head.php');
$res = $dbh->query('SELECT * FROM movie ORDER BY RAND() LIMIT 50');

if(!empty($_GET["show-message"])) {
    ?>
    <div id="popover" class="notification is-danger">
        <button onclick="hide()"  class="delete"></button>
        Message envoyé !
    </div>
    <?php
}

    include ('nav.php');
    include ('main.php');

    if($_SESSION['user']) {
        $userid = $_SESSION['user']['id'];
        $userres = $dbh->query("SELECT * FROM movie_like WHERE user_id = $userid");
        $favorit = $userres->fetchAll();
    }
    ?>

    <div class="columns is-gapless is-multiline gradientPrimary" >
            <?php
                //connexion avec le dsn et la classe PDO
                    while ($data = $res->fetch())
                {
                    ?>
                    <div style=" margin-right: 5px; min-width: 200px; margin-left: 5px; margin-bottom: 5px;">
                        <div style="text-align: center;">
                            <a href="detail.php?id=<?= $data['id']; ?>">
                                <img class="poster hoverposter" src="./posters/<?= $data['image']; ?>"/>
                                <!--
                                <div style="position: absolute;">
                                    <?php
                                    /*
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
                                    */
                                    ?>
                                </div>
                                -->
                            </a>
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

