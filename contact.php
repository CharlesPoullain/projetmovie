<!DOCTYPE html>
<html>
<?php

include ('session.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("vendor/autoload.php");


$errors = [];

if (!empty($_POST)) {
    $name = strip_tags($_POST["name"]);
    $email= strip_tags($_POST["email"]);
    $message = strip_tags($_POST["message"]);

    if(empty($name)){
        $errors["name"] = "Merci de remplir le champ de votre nom";
    } else if(mb_strlen($name) < 2) {
        $errors["name"] = "Le nom est trop court !";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors["email"] = "Email invalid";
    }

    if(empty($message)) {
        $errors["message"] = "Message vide";
    }

    if(empty($errors)) {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'localhost';  // Specify main and backup SMTP servers
            //$mail->SMTPAuth = true;                               // Enable SMTP authentication
            //$mail->Username = 'user@example.com';                 // SMTP username
            //$mail->Password = 'secret';                           // SMTP password
            //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            //$mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('charles.poullain85@gmail.com', 'Charlou');     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = "<h1 style='color:red;'>$message</h1>";
            $mail->send();

            header("Location: index.php?show-message=1");
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }


   // var_dump($name, $email, $message);
}
include ('head.php');
?>
<body>
<?php
include ('nav.php');

?>

<main>
    <section class="section">
        <div class="container">
            <h1 class="title">
                Movies App
            </h1>
            <p class="subtitle">
                <strong></strong>
            </p>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <form action="contact.php" method="POST" novalidate>
                <div class="field">
                    <label class="label">Nom</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" name="name" type="text" placeholder="Votre nom">
                        <span class="icon is-small is-left">
                          <i class="fas fa-user"></i>
                        </span>
                        <p class="help is-danger"><?php echo $errors["name"] ?? "";?></p>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" name="email" type="email" placeholder="Votre email">
                        <span class="icon is-small is-left">
                          <i class="fas fa-envelope"></i>
                        </span>
                        <p class="help is-danger"><?php echo $errors["email"] ?? "";?></p>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Message</label>
                    <div class="control">
                        <textarea class="textarea" name="message" placeholder="Votre Message"></textarea>
                    </div>
                    <p class="help is-danger"><?php echo $errors["message"] ?? "";?></p>

                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-link">Submit</button>
                    </div>
                    <div class="control">
                        <button class="button is-text">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
</body>
</html>

