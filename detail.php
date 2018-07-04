<!DOCTYPE html>
<html>
<?php
include ('session.php');

include ('head.php');
if(!empty($_GET['id'])) {
    $id = $_GET['id'];
    $res = $dbh->query("SELECT * FROM movie WHERE id = $id");
    $data = $res->fetch();

    $resReview = $dbh->query("SELECT * FROM review WHERE movie_id = $id ORDER BY date DESC");
    $dataReview = $resReview->fetchAll();
}

if (!empty($_POST)) {
    $title = strip_tags(htmlentities($_POST["title"]));
    $email= strip_tags($_POST["email"]);
    $username= strip_tags(htmlentities($_POST["username"]));
    $review = strip_tags(htmlentities($_POST["message"]));

    if(empty($title)){
        $errors["title"] = "Merci de remplir le champ du titre";
    }

    if(empty($username)){
        $errors["username"] = "Merci de remplir le champ de votre username";
    } else if(mb_strlen($username) < 2) {
        $errors["username"] = "Le username est trop court !";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors["email"] = "Email invalid";
    }

    if(empty($review)) {
        $errors["review"] = "Message vide";
    }

    if(empty($errors)) {
        $reqInsert = $dbh->prepare("INSERT INTO review (title, review, username, email, movie_id, date) VALUES (:title, :review, :username, :email, :movie_id, now())");

        $reqInsert->execute(array(
            "title" => $title,
            "review" => $review,
            "username" => $username,
            "email" => $email,
            "movie_id" => $id
        ));
        //$dataReview = $reqInsert->fetchAll();
        header("Location: detail.php?id=$id");

    }
}
if($_SESSION['user']) {
    $userid = $_SESSION['user']['id'];
    $userres = $dbh->query("SELECT * FROM movie_like WHERE user_id = $userid");
    $favorit = $userres->fetchAll();
}
?>
<body>

<?php
include ('nav.php');

?>

<div class="box" style="margin-left: 100px; margin-right: 100px; margin-top: 200px; margin-bottom: 100px; ">
    <article class="media">
        <div class="media-left">
            <figure class="image is-128x128">
                <a href="./posters/<?= $data['image']; ?>">
                    <img class="hoverposter" src="./posters/<?= $data['image']; ?>" alt="Image">
                </a>
            </figure>
        </div>
        <div class="media-content">
            <div class="content">
                <div><strong><?= $data['title'];?></strong> - <small><?= $data['year'];?></small><br>
                    <div>
                        <?php
                        $islike = false;
                        $watch_list = false;
                        foreach ($favorit as $fav) {
                            if($fav['movie_id'] == $data['id'] && $fav['is_like'] == 1 ) {
                                $islike = true;
                                ?>
                                <?php
                                break;
                            }

                            if($fav['movie_id'] == $data['id'] && $fav['watch_list'] == 1 ) {
                                $watch_list = true;
                                ?>
                                <?php
                                break;
                            }
                        }
                        if(!$islike) {
                            ?>
                            <a id="likebutton">
                                <i style="color: black;" class="far fa-heart"></i>
                            </a>
                            <?php
                        }else{
                            ?>
                            <i style="color: #ff2c37;" class="fas fa-heart"></i>
                            <?php
                        }

                        if(!$watch_list) {
                            ?>
                            <a id="watchbutton">
                                <i style="color: black;" class="fas fa-eye"></i>
                            </a>
                            <?php
                        }else{
                            ?>
                            <i style="color: dodgerblue;" class="fas fa-eye"></i>
                            <?php
                        }
                        ?>

                    </div>
                <small><em>Directors : <?= $data['directors'];?></em></small></div>
                <small><em>Actors : <?= $data['actors'];?></em></small></div>
                    <div>
                        <?php $nbstars = round($data['rating']);
                        for($i=0; $i < $nbstars; $i++) {
                            ?>
                            <i style="color: #ffe31b;" class="fas fa-star"></i>
                            <?php
                        }
                        ?>
                        <?php $nbemptystars = 10-round($data['rating']);
                        for($i=0; $i < $nbemptystars; $i++) {
                            ?>
                            <i class="far fa-star"></i>
                            <?php
                        }
                        ?>
                    </div>
                    <small>Durée : <?= $data['runtime'];?> min</small>
                    <br>
                <p><?= $data['plot'];?></p>

                <div style="text-align: center; margin-top: 50px; margin-bottom: 50px;">
                    <p style="margin-top: 20px; margin-bottom: 20px;">Bande annonce : </p>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $data['trailer_id'];?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </iframe>
                </div>
                <div>
                    <p style="text-align: center; margin-top: 50px;">Commentaires des utilisateurs : </p>
                    <div>
                        <div class="">

                            <?php
                            $sizetab = sizeof($dataReview);
                            if($sizetab) {
                                ?>
                                <div style="text-align: center; margin-top: 20px;">
                                    <a style="margin-bottom: 30px;" id="openModal" class="button is-primary">Ajouter un commentaire</a>
                                </div>
                                    <?php
                                foreach ($dataReview as $key => $review){ ?>
                                <article class="message is-primary">
                                    <div class="message-header">
                                        <div><?= $review['title']; ?></div>
                                    <div style="position: absolute; right: 10px;"><small>Posté le : <?= $review['date']; ?></small></div>
                                        </div>
                                    <div class="card-content">
                                        <p> <?= $review['review']; ?></p>

                                    </div>
                                    <div style="display: flex;   justify-content: space-around;">
                                        <p style="font-size: 10px;"> Utilisateur : <?= $review['username']; ?></p>
                                        <p style="font-size: 10px;"> Email : <?= $review['email']; ?></p>
                                    </div>
                                </article>
                                <?php
                                }
                            }else {
                                ?>
                                <div style="text-align: center;">
                                    <p style="padding-top: 30px; padding-bottom: 30px;">Aucun commentaire</p>
                                    <a style="margin-bottom: 30px;" id="openModal" class="button is-primary">Ajouter un commentaire</a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <nav class="level is-mobile">
                <div class="level-left" style="margin-right: 50px;">
                    <span class="level-item" aria-label="reply">
                    <p> <?= $data['genres'];?></p>
                    </span>
                </div>
            </nav>
        </div>
    </article>

<div id="modal" class="modal ">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Envoyer un nouveau message</p>
            <button id="closeModal" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">

            <form method="POST" novalidate>
                <div class="field">
                    <label class="label">Titre du message</label>
                    <div class="control">
                        <input class="input" name="title" type="text" placeholder="Votre titre">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Nom d'utilisateur</label>
                    <div class="control">
                        <input class="input" name="username" type="text" placeholder="Votre nom d'utilisateur">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input" name="email" type="email" placeholder="Votre email">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Message</label>
                    <div class="control">
                        <textarea class="textarea" name="message" placeholder="Textarea"></textarea>
                    </div>
                </div>
        </section>
        <footer class="modal-card-foot">
            <button type="submit" class="button is-success">Envoyer</button>
            <button id="closeModal2" class="button">Annuler</button>
        </footer>
        </form>

    </div>
</div

</body>
</html>

<script>
    $( document ).ready(function() {
        $("#openModal").click(function () {
            console.log("open")
            $("#modal").addClass("is-active");
        })
        $("#closeModal").click(function () {
            console.log("close")
            $("#modal").removeClass("is-active");
        })
        $("#closeModal2").click(function () {
            console.log("close")
            $("#modal").removeClass("is-active");
        })

        $('#likebutton').click(function () {
            $.ajax({
                method: "POST",
                url: "love.php",
                data: {
                    movieId: <?= $data['id']; ?>,
                    like: 1,
                    userId: <?= $userid; ?>,
                    insert: true
                }
            }).done(function() {
                location.reload();

            });
        })

        $('#watchbutton').click(function () {
            $.ajax({
                method: "POST",
                url: "watch.php",
                data: {
                    movieId: <?= $data['id']; ?>,
                    watch: 1,
                    userId: <?= $userid; ?>,
                    insert: true
                }
            }).done(function() {
                location.reload();

            });
        })

    });
</script>