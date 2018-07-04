<!DOCTYPE html>
<html>
<?php
include ('session.php');

include ('head.php');

if($_SESSION['user']) {
    $userid = $_SESSION['user']['id'];
    $useravatar = $_SESSION['user']['avatar'];

}

$resType = $dbh->query('SELECT * FROM faq_categ');
$dataType = $resType->fetchAll();

$resFaq = $dbh->query('SELECT * FROM faq_message ORDER BY date ASC');
$dataFaq = $resFaq->fetchAll();

$resFaqCommentary = $dbh->query('SELECT * FROM faq_commentary ORDER BY date ASC');
$dataFaqCommentary = $resFaqCommentary->fetchAll();

$resUser = $dbh->query('SELECT * FROM user');
$dataUser = $resUser->fetchAll();

?>
<body>
<?php
include ('nav.php');

?>
<h1 style="text-align: center; font-size: 40px; margin-top: 20px; margin-bottom: 20px;">Messages de la Faq</h1>

<main>
    <?php
    foreach ($dataType as $type) {
        ?>
        <div class="box" style="width: 80%; margin-left: auto; margin-right: auto; margin-bottom: 50px;">
            <h1 class="title is-3"><?= $type["type"];?></h1>

        <?php
            foreach ($dataFaq as $faq) {
                if($faq["type"] == $type["id"]) {
                    ?>
                    <section class="section" style="width: 85%; margin-left: auto; margin-right: auto;">

                        <article class="media">
                            <figure class="media-left">
                                <p class="image is-64x64">
                                    <?php
                                    foreach ($dataUser as $user) {
                                        if ($user["id"] == $faq["user_id"]) {
                                            if ($user["avatar"]) {
                                                ?>
                                                <img src="<?= $user["avatar"]; ?>">
                                                <?php
                                            }

                                        }
                                    }
                                    ?>
                                </p>
                            </figure>
                            <div class="media-content">
                                <div class="content">
                                    <p>
                                        <strong>
                                            <?php
                                            foreach ($dataUser as $user) {
                                                if ($user["id"] == $faq["user_id"]) {
                                                    echo $user["username"];
                                                }
                                            }
                                            ?>
                                            -
                                            <strong><?= $faq["title"]; ?></strong>
                                        </strong>
                                        <br>
                                        <?= $faq["message"]; ?>
                                        <br>
                                        <small><?= $faq["date"]; ?></small>
                                    </p>
                                </div>

                                <?php
                                foreach ($dataFaqCommentary as $commentary) {
                                    if ($commentary["faq_message_id"] == $faq["id"]) {
                                        ?>
                                        <article class="media">
                                            <figure class="media-left">
                                                <p class="image is-48x48">
                                                    <?php
                                                    foreach ($dataUser as $user) {
                                                        if ($user["id"] == $commentary["user_id"]) {
                                                            if ($user["avatar"]) {
                                                                ?>
                                                                <img src="<?= $user["avatar"]; ?>">
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                            </figure>
                                            <div class="media-content">
                                                <div class="content">
                                                    <p>
                                                        <strong>
                                                            <?php
                                                            foreach ($dataUser as $user) {
                                                                if ($user["id"] == $commentary["user_id"]) {
                                                                    echo $user["username"];
                                                                }
                                                            }

                                                            ?></strong>
                                                        <br>
                                                        <?= $commentary["message"]; ?>

                                                        <br>
                                                        <small><?= $commentary["date"]; ?></small>
                                                    </p>
                                                </div>
                                            </div>
                                        </article>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </article>

                        <article class="media" style="width: 90%; margin-left: auto; margin-right: auto;">

                            <figure class="media-left">
                                <p class="image is-64x64">
                                    <img src="<?= $useravatar; ?>">
                                </p>
                            </figure>
                            <div class="media-content">
                                <form method="POST" action="faq_commentary.php">
                                    <div class="field">
                                        <p class="control">
                                            <textarea class="textarea" name="commentary"
                                                      placeholder="Ajouter un commentaire"></textarea>
                                        </p>
                                    </div>
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="hidden" name="faqid" value="<?= $faq["id"]; ?>">
                                        </p>
                                    </div>
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="hidden" name="userid" value="<?= $userid; ?>">
                                        </p>
                                    </div>
                                    <div class="field">
                                        <p class="control">
                                            <button type="submit" class="button">Publier</button>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </article>
                    </section>

                    <?php
                }
            }
            ?>
        </div>
            <?php
        }
    ?>
</main>


</body>
</html>

