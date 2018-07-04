<?php
include ('head.php');

if($_POST["movieId"] && $_POST["userId"] && $_POST["like"]) {
    $movieId = $_POST["movieId"];
    $userId = $_POST["userId"];
    $like = $_POST["like"];

    if($_POST["insert"]) {
        $reqInsert = $dbh->prepare("INSERT INTO movie_like (movie_id, user_id, is_like) VALUES (:movie_id, :user_id, :is_like)");

        $reqInsert->execute(array(
            "movie_id" => $movieId,
            "user_id" => $userId,
            "is_like" => $like
        ));
    }
}
?>