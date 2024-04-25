<?php



// Function to make cURL requests
function makeCurlRequest($url, $method, $data = null, $headers = array())
{
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    // Set data for POST requests
    if ($method === 'POST' && $data !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    // Set headers
    $defaultHeaders = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer [access_token]' // Replace [access_token] with your actual access token
    );
    $headers = array_merge($defaultHeaders, $headers);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            echo 'HTTP Error: ' . $httpCode;
        }
    }

    // Close cURL session
    curl_close($ch);

    return $response;
}

// Function to set session data
function setSessionData($result, $data)
{
    if ($result !== null && $data !== null) {
        $_SESSION['ID'] = htmlspecialchars($result["CustomerID"]);
        $_SESSION['user_firstname'] = htmlspecialchars($result["FirstName"]);
        $_SESSION['user_lastname'] = htmlspecialchars($result["LastName"]);
        $_SESSION['user_email'] = htmlspecialchars($result["Email"]);
        $_SESSION['Telephone'] = htmlspecialchars($result["Telephone"]);
        $_SESSION['Add1'] = htmlspecialchars($data["AddressLine1"]);
        $_SESSION['Add2'] = htmlspecialchars($data["AddressLine2"]);
        $_SESSION['city'] = htmlspecialchars($data["City"]);
        $_SESSION['postal'] = htmlspecialchars($data["ZipCode"]);
        $_SESSION['province'] = htmlspecialchars($data["Province"]);
        return true;
    } else {
        return false;
    }
}

// Requesting access token
$accessTokenUrl = 'https://payflex-live.eu.auth0.com/oauth/token';
$accessTokenData = array(
    'client_id' => 'your_client_id', // Replace with your client ID
    'client_secret' => 'your_client_secret', // Replace with your client secret
    'audience' => 'https://auth-production.payflex.co.za',
    'grant_type' => 'client_credentials'
);
$accessTokenResponse = makeCurlRequest($accessTokenUrl, 'POST', $accessTokenData);

// Decode the access token response to extract the token
$accessToken = json_decode($accessTokenResponse)->access_token;

// Retrieving configuration
$configurationUrl = 'https://api.payflex.co.za/configuration';
$configurationResponse = makeCurlRequest($configurationUrl, 'GET', null, array('Authorization: Bearer ' . $accessToken));

// Fetching data from the database
require_once 'buyerdata.inc.php';
$result = buyerdata($pdo);
$data = addressdata($pdo);

// Set session data
if (setSessionData($result, $data)) {
    // Check if product data is available
    if (!empty($product['Description']) && !empty($product['Name']) && !empty($product['Quantity']) && !empty($product['Price'])) {
        $orderUrl = 'https://api.payflex.co.za/order';
        $orderData = array(
            // Construct order data
        );

        // Making the API request
        $orderResponse = makeCurlRequest($orderUrl, 'POST', $orderData, array('Authorization: Bearer ' . $accessToken));

        // Outputting the API response
        echo $orderResponse;
    }
}

// Product selection
if (setSessionData($result, $data)) {
    // Check if product data is available
    if (!empty($product['Description']) && !empty($product['Name']) && !empty($product['Quantity']) && !empty($product['Price'])) {
        $productSelectUrl = 'https://api.payflex.co.za/order/productSelect';
        $productSelectData = array(
            // Construct product select data
        );

        // Making the API request
        $productSelectResponse = makeCurlRequest($productSelectUrl, 'POST', $productSelectData, array('Authorization: Bearer ' . $accessToken));

        // Outputting the API response
        echo $productSelectResponse;
    }
}

// Product selection order
if (!empty($product['Description']) && !empty($product['Name']) && !empty($product['Quantity']) && !empty($product['Price'])) {
    $productSelectOrderUrl = 'https://api.payflex.co.za/order/productSelectOrder';
    $productSelectOrderData = array(
        // Construct product select order data
    );

    // Making the API request
    $productSelectOrderResponse = makeCurlRequest($productSelectOrderUrl, 'POST', $productSelectOrderData, array('Authorization: Bearer ' . $accessToken));

    // Outputting the API response
    echo $productSelectOrderResponse;
}

// Retrieving order details
$orderDetailUrl = 'https://api.payflex.co.za/order/151515556'; // Replace with actual order ID
$orderDetailResponse = makeCurlRequest($orderDetailUrl, 'GET', null, array('Authorization: Bearer ' . $accessToken));

// Outputting responses
echo "Access Token Response: $accessTokenResponse\n";
echo "Configuration Response: $configurationResponse\n";
echo "Order Detail Response: $orderDetailResponse\n";

?>