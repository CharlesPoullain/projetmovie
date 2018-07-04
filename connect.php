<?php
include ('head.php');


if($_POST['username'] && $_POST['password']) {

    $username = "'".$_POST['username']."'";
    $password = "'".md5($_POST['password'])."'";
    $res = $dbh->query("SELECT * FROM user WHERE username = $username AND password = $password");
    $user = $res->fetch();
    if($user) {
        session_start();
        $_SESSION['user'] = $user;
        header("Location: index.php");

    }else{
        header("Location: auth.php");
    }

}else{
    header("Location: auth.php");
}
