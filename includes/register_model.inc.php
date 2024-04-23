<?php

declare(strict_types=1);

function getEmail(object $pdo, string $email)
{
    $query = "SELECT Email FROM customer WHERE Email= :email;";//edit line make sure correct db
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $firstName, string $lastName, string $email, string $telephone, string $password)
{
    $query = "INSERT INTO customer (FirstName, LastName, Email, Telephone, Pwd) VALUES (:firstname, :lastname, :email,:telephone, :pwd)";//ensure you name password in db as pwd and ensure db name is the same
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12,
    ];
    $hashedPwd = password_hash($password, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":firstname", $firstName);
    $stmt->bindParam(":lastname", $lastName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":telephone", $telephone);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        function set_user_data(object $pdo, string $alternativeNumb, string $address1, string $address2, string $city, string $region, string $postcode, string $country)
        {
            $CustomerID = $pdo->lastInsertId();

            $query = "INSERT INTO deliveryaddress (CustomerID, Alternative_Number, AddressLine1, AddressLine2, City, Province, ZipCode, Country) VALUES (:CustomerID, :altTelephone, :address1, :address2, :city, :region, :postcode, :country)";//ensure you name password in db as pwd and ensure db name is the same
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':CustomerID', $CustomerID, PDO::PARAM_INT);
            $stmt->bindParam(":altTelephone", $alternativeNumb);
            $stmt->bindParam(":address1", $address1);
            $stmt->bindParam(":address2", $address2);
            $stmt->bindParam(":city", $city);
            $stmt->bindParam(":region", $region);
            $stmt->bindParam(":postcode", $postcode);
            $stmt->bindParam(":country", $country);
            $stmt->execute();
        }
    }
}


