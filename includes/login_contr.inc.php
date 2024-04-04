<?php


declare(strict_types=1);

function is_InputEmpty(string $email, string $password)
{
    if (empty ($email) || empty ($password)) {
        return true;
    } else {
        return false;
    }
}

function isEmailWrong(array|bool $result)
{
    if (!$result) {
        return true;
    } else {
        return false;
    }
}

function isPasswordWrong(string $password, string $hashedPwd)
{
    if (!password_verify($password, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}