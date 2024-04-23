<?php

declare(strict_types=1);

function isInputEmpty(string $firstName, string $lastName, string $email, string $telephone, string $address1, string $city, string $postcode, string $country, string $region, string $password)
{
    if (empty($firstName) || empty($lastName) || empty($email) || empty($telephone) || empty($address1)) {
        return true;
    } elseif (empty($city) || empty($postcode) || empty($country) || empty($region) || empty($password)) {
        return true;
    } else {
        return false;
    }

}

function isEmailInvalid(string $email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function isEmailTaken(object $pdo, string $email)
{
    if (getEmail($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function create_user(object $pdo, string $firstName, string $lastName, string $email, string $telephone, string $password)
{
    set_user($pdo, $firstName, $lastName, $email, $telephone, $password);
}

function create_user_data(object $pdo, string $alternativeNumb, string $address1, string $address2, string $city, string $region, string $postcode, string $country)//will edit for other data not added
{
    set_user_data($pdo, $alternativeNumb, $address1, $address2, $city, $region, $postcode, $country);
}