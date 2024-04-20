<?php
//* Pay now server code
/**
 * @param array $data
 * @param null $passPhrase
 * @return string
 */

//*  The signature will create a hash that all the form values are submitting
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
$cartTotal = 10.00; // This amount needs to be sourced from your application
$passphrase = 'jt7NOE43FZPn';
$data = array(
    // Merchant details
    //TODO: Add merchant details here
    'merchant_id' => '10033404',
    'merchant_key' => 'mfur1f44r6s4n',

    // Buyer details
    //TODO: Add buyer details here
    'name_first' => 'First Name',
    'name_last'  => 'Last Name',
    'email_address' => 'test@test.com',
    'cell_number' => '012 345 6789',

    // Transaction details
    //TODO: Add transaction details here
    'm_payment_id' => '1234', //Unique payment ID to pass through to notify_url
    'amount' => $subtotal,
    'item_name' => 'Order#123'
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

?>

<?php echo $htmlForm; ?>
