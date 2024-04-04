<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        // Error handlers
        $errors = [];

        if (is_InputEmpty($email, $password)) {
            $errors['empty input'] = 'Fill in all fields!';
        }

        $result = getUser($pdo, $email);

        if (isEmailWrong($result)) {
            $errors['login_incorrect'] = 'Incorrect login info!';
        }

        if (!isEmailWrong($result) && isPasswordWrong($password, $result['Pwd'])) {
            $errors['login_incorrect'] = 'Incorrect login info!';
        }

        require_once 'config_session.inc.php';

        if ($errors) {
            $_SESSION['Errors_login'] = $errors;
            header("Location: ../index.php?page=cart");
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["CustomerID"];
        session_id($sessionId);

        $_SESSION['user_id'] = $result["CustomerID"];
        $_SESSION['user_firstname'] = htmlspecialchars($result["FirstName"]);//might have to change or remove

        $_SESSION['prev_regeneration'] = time();
        header("Location: ../index.php?page=cart&login=success");//send user to home or look at the last video to see how you can do it 
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
