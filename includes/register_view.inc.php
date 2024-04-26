<?php

declare(strict_types=1);

function check_register_errors()
{
    if (isset($_SESSION['Error register'])) {
        $errors = $_SESSION['Error register'];

        echo "<br>";

        foreach ($errors as $error) {
            echo "<h3>" . $error . "</h3>";
        }
        unset($_SESSION['Error register']);

    } else if (isset($_GET['register']) && $_GET['register'] === 'success') {
        echo '<br>';
        echo '<h3  class="green-text">Registration Successful!</h3>';
        echo '<h3 class="green-text">Please Login. TO CHECKOUT</h3>';
    }
}
?>
<style>
    .green-text {
        color: green;
        font-weight: bold;
        background-color: #dff0d8;
        padding: 10px;
        border: 1px solid #d6e9c6;
        border-radius: 5px;

    }
</style>