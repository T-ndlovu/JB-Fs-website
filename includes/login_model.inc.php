<?php

declare(strict_types=1);

function getUser(object $pdo, string $email)
{
    $query = "SELECT * FROM customer WHERE Email= :email;";//edit line make sure correct db
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}