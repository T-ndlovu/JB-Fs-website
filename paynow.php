<?php

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
?>


<form action="https://www.payfast.co.za/eng/process" method="post">
    <!-- merchant -->
    <input type="hidden" name="merchant_id" value="10000100">
    <input type="hidden" name="merchant_key" value="46f0cd694581a">
    <input type="hidden" name="return_url" value="https://www.example.com/success">
    <input type="hidden" name="cancel_url" value="https://www.example.com/cancel">
    <input type="hidden" name="notify_url" value="https://www.example.com/notify">
    <!-- customer -->
    <input type="hidden" name="name_first" value="John">
    <input type="hidden" name="name_last" value="Doe">
    <input type="hidden" name="email_address" value="john@doe.com">
    <input type="hidden" name="cell_number" value="0823456789">
    <!-- transaction -->
    <input type="hidden" name="m_payment_id" value="01AB">
    <input type="hidden" name="amount" value="100.00">
    <input type="hidden" name="item_name" value="Test Item">
    <!-- submit -->
    <input type="submit">
</form>