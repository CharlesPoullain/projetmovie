<?php
include ('head.php');

var_dump($_POST);
if($_POST["commentary"] && $_POST["faqid"] && $_POST["userid"]) {
    $message = $_POST["commentary"];
    $user_id = $_POST["userid"];
    $faq_message_id = $_POST["faqid"];
    $date = date("Y-m-d H:i:s");

    $reqInsert = $dbh->prepare("INSERT INTO faq_commentary (user_id, faq_message_id, message, date) VALUES (:user_id, :faq_message_id, :message, :date)");

    $reqInsert->execute(array(
        "user_id" => $user_id,
        "faq_message_id" => $faq_message_id,
        "message" => $message,
        "date" => $date
    ));

    header("Location: faq.php");

}
?>