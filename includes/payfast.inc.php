<?php
//* Pay now server code
/**
 * @param array $data
 * @param null $passPhrase
 * @return string
 */

//*  The signature will create a hash that all the form values are submitting
require_once 'buyerdata.inc.php';
$result = buyerdata($pdo);


function generateSignature($data, $passPhrase = null)
{
    // Create parameter string
    $pfOutput = '';
    foreach ($data as $key => $val) {
        if ($val !== '') {
            $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
        }
    }
    // Remove last ampersand
    $getString = substr($pfOutput, 0, -1);
    if ($passPhrase !== null) {
        $getString .= '&passphrase=' . urlencode(trim($passPhrase));
    }
    return md5($getString);
}


//* We are moving our statically generated form data to the server so that we can use use it in the signature generation
// Construct variables
if ($result !== null) {
    $_SESSION['user_firstname'] = htmlspecialchars($result["FirstName"]);
    $_SESSION['user_lastname'] = htmlspecialchars($result["LastName"]);
    $_SESSION['user_email'] = htmlspecialchars($result["Email"]);


    $cartTotal = $subtotal; // This amount needs to be sourced from your application
    $passphrase = 'jt7NOE43FZPn';
    $data = array(
        // Merchant details

        'merchant_id' => '10033404',
        'merchant_key' => 'mfur1f44r6s4n',
        'return_url' => 'https://74f7-102-220-77-186.ngrok-free.app/JB-Fs-website/index.php?page=placeorder',
        'notify_url' => 'https://74f7-102-220-77-186.ngrok-free.app/JB-Fs-website/includes/payfast-notify.inc.php',


        // Buyer details

        'name_first' => $_SESSION['user_firstname'],
        'name_last' => $_SESSION['user_lastname'],
        'email_address' => $_SESSION['user_email'],


        // Transaction details

        'm_payment_id' => $sessionId, //Unique payment ID to pass through to notify_url
        'amount' => number_format(sprintf('%.2f', $cartTotal), 2, '.', ''),
        'item_name' => 'hhh'
    );

    $signature = generateSignature($data);
    $data['signature'] = $signature;

    // If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
    $testingMode = true;
    $pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
    $htmlForm = '<form action="https://' . $pfHost . '/eng/process" method="post">';
    foreach ($data as $name => $value) {
        $htmlForm .= '<input name="' . $name . '" type="hidden" value=\'' . $value . '\' />';
    }
    $htmlForm .= '<input type="submit" value="Pay Now" /></form>';
    echo $htmlForm;
}


?>