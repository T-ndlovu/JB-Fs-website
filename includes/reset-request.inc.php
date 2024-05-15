<?php

require "dbh.inc.php";

$email = "";
if (isset($_POST['reset-submit'])) {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "https://615c-102-218-193-192.ngrok-free.app/index.php?page=create-new-password&selector=" . $selector . "&validator=" . bin2hex($token);//enter my directory
    $expire = date("U") + 1000;

    require_once "dbh.inc.php";




    $useremail = $_POST["email"];

    // Delete existing password reset request
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail = :useremail";


    // Insert new password reset request
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (:useremail, :selector, :hashedToken, :expire)";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute(['useremail' => $useremail, 'selector' => $selector, 'hashedToken' => $hashedToken, 'expire' => $expire])) {
        echo "There was an error!";
        exit();
    }

    $to = $useremail;
    $subject = 'Password Reset|JB Furniture Store';
    $message = "Hello There,<br> 
            Someone requested to reset your password.<br>
            If this was you,<a href='. $url .'>click here</a>to reset your password,
            if not just ignore this email.
            <br><br>
            Thank you,
            <br><br>
            JB Furniture Store
            <br><br>";

    $headers = "From: JB Furniture Store <gmail.com>\r\n";
    $headers .= "Reply-To: <gmail.com>\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);
    header("Location: ../index.php?page=forgot-password&reset=success");

} else {
    header('Location: ../index');
}
?>