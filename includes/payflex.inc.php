<?php

require_once 'buyerdata.inc.php';
$result = buyerdata($pdo);
$data = addressdata($pdo);

if ($result !== null && $data !== null) {
    $_SESSION['user_firstname'] = htmlspecialchars($result["FirstName"]);
    $_SESSION['user_lastname'] = htmlspecialchars($result["LastName"]);
    $_SESSION['user_email'] = htmlspecialchars($result["Email"]);


    $url = 'https://api.payflex.co.za/order';
    $accessToken = 'Bearer [access_token]'; // Replace [access_token] with your actual access token

    $data = array(
        'amount' => 105.00,
        'consumer' => array(
            'phoneNumber' => '64274123456',
            'givenNames' => $_SESSION['user_firstname'],
            'surname' => $_SESSION['user_lastname'],
            'email' => $_SESSION['user_email']
        ),
        'billing' => array(
            'addressLine1' => '23 Duncan Tce',
            'addressLine2' => '',
            'suburb' => 'Kilbirnie',
            'city' => 'Wellington',
            'postcode' => '1000',
            'state' => ''
        ),
        'shipping' => array(
            'addressLine1' => '23 Duncan Tce',
            'addressLine2' => '',
            'suburb' => 'Kilbirnie',
            'city' => 'Wellington',
            'postcode' => '1000',
            'state' => ''
        ),
        'description' => '',
        'items' => array(
            array(
                'description' => 'test',
                'name' => 'test',
                'sku' => 'test',
                'quantity' => 1,
                'price' => 100.00
            )
        ),
        'merchant' => array(
            'redirectConfirmUrl' => 'https://merchantsite.com/confirm',
            'redirectCancelUrl' => 'https://merchantsite.com/cancel',
            'statusCallbackUrl' => 'https://merchantsite.com/callback'
        ),
        'merchantReference' => 'test',
        'taxAmount' => 0,
        'shippingAmount' => 5
    );

    $data_string = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        )
    );

    $result = curl_exec($ch);

    curl_close($ch);

    echo $result;
}


?>