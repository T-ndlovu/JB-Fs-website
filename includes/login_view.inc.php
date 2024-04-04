<?php


declare(strict_types=1);
function output_username()
{
    if (isset($_SESSION['user_id'])) {
        echo 'Welcome back: ' . $_SESSION['user_firstname'] . '';//output users name whose logged in
    } else {
        echo 'Signup / Login';
    }
}


function check_login_errors()
{
    if (isset($_SESSION['Errors_login'])) {
        $errors = $_SESSION['Errors_login'];

        echo '<br>';

        foreach ($errors as $error) {
            echo "<h3>" . $error . "</h3>";
        }
        unset($_SESSION['Errors_login']);
    } elseif (isset($_GET['login']) && $_GET['login'] === 'success') {
        echo '<br>';
        echo '<h3>login Success</h3>';
    }
}