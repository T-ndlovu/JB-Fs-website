<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    // address info
    $alternativeNumb = $_POST['altTelephone'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $country = $_POST['country'];
    $region = $_POST['region'];
    //password
    $password = $_POST['pwd'];//add confimr pwd and functionality

    try {
        require_once 'dbh.inc.php';
        require_once 'register_model.inc.php';
        require_once 'register_contr.inc.php';

        //error handler
        $errors = [];

        if (isInputEmpty($firstName, $lastName, $email, $telephone, $address1, $city, $postcode, $country, $region, $password)) {
            $errors['empty input'] = 'Fill in all fields!';
        }

        if (isEmailInvalid($email)) {
            $errors['invalid email'] = 'Fill in valid email.';
        }
        if (isEmailTaken($pdo, $email)) {
            $errors['email taken'] = 'Email already exists!.';
        }

        require_once 'config_session.inc.php';

        if ($errors) {
            $_SESSION['Error register'] = $errors;
            header("Location: ../index.php?page=cart");//error message should be sent to the current page
            die();
        }

        create_user($pdo, $firstName, $lastName, $email, $password);
        create_user_data($pdo, $alternativeNumb, $address1, $address2, $city, $region, $postcode, $country);
        header("Location: ../index.php?page=cart&register=success");//send user to home page

        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
        echo "Query failed" . $e->getMessage();
    }

} else {
    header("Location: ../index.php");
    die();
}