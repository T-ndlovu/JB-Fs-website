<?php

if (isset($_POST["reset-password-submit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordConfirm = $_POST["pwd-repeat"];

    if (empty($password) || empty($passwordConfirm)) {
        header("Location: ../create-new-password.php?newpwd=empty");
        exit;
    } elseif ($password != $passwordConfirm) {
        header("Location: ../create-new-password.php?newpwd=pwdnotsame");
        exit;
    }

    $today = date("U");

    require_once "dbh.inc.php";

    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        echo "There was an error!";
        exit();
    } else {
        $stmt->execute([$selector, $today]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo "Resubmit your reset request";
            exit;
        } else {
            $tokenbin = hex2bin($validator);
            $tokencheck = password_verify($tokenbin, $row['pwdResetToken']);

            if ($tokencheck === false) {
                echo 'Resubmit your reset request';
                exit;
            } elseif ($tokencheck === true) {
                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM customers WHERE Email = ?";
                $stmt = $pdo->prepare($sql);

                if (!$stmt) {
                    echo "There was an error!";
                    exit();
                } else {
                    $stmt->execute([$tokenEmail]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (!$result) {
                        echo "There was an error";
                        exit;
                    } else {
                        $sqlupdate = "UPDATE customers SET Pwd=? WHERE Email=?";
                        $stmt = $pdo->prepare($sqlupdate);
                        if (!$stmt) {
                            echo "There was an error!";
                            exit();
                        } else {
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            $stmt->execute([$newPwdHash, $tokenEmail]);
                            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                            $stmt = $pdo->prepare($sql);
                            if (!$stmt) {
                                echo "There was an error!";
                                exit();
                            } else {
                                $stmt->execute([$tokenEmail]);
                                header('Location: ../index.php?page=create-new-password&newpwd=passwordupdated');
                            }
                        }
                    }
                }
            }
        }
    }
} else {
    header('Location: ../index');
    exit;
}
