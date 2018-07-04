<?php
include ('head.php');

if($_POST["movieId"] && $_POST["userId"] && $_POST["watch"]) {
    $movieId = $_POST["movieId"];
    $userId = $_POST["userId"];
    $watch_list = $_POST["watch"];

    if($_POST["insert"]) {
        $reqInsert = $dbh->prepare("INSERT INTO movie_like (movie_id, user_id, watch_list) VALUES (:movie_id, :user_id, :watch_list)");

        $reqInsert->execute(array(
            "movie_id" => $movieId,
            "user_id" => $userId,
            "watch_list" => $watch_list
        ));
    }
}
?>