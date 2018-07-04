<?php
include ('head.php');


if($_POST['newusername'] && $_POST['newpassword'] && $_POST['confirmpassword']) {

    $username = $_POST['newusername'];
    $password =  md5($_POST['newpassword']);
    $confirmpassword = md5($_POST['confirmpassword']);

    if ($username && $password == $confirmpassword) {
        $reqInsert = $dbh->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");

        $reqInsert->execute(array(
            "username" => $username,
            "password" => $password
        ));

        header("Location: auth.php");
    }
}