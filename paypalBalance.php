<?php
$clientId = "AScI4_3SDMrltP0uA-w5PS9KDjk27hlGMs7q3x0VrXGJgiuTaoBXkatjqBCxe4FUiAP2vP6ttxpRSAW0";
$secret   = "EJAcN-u_rjVFrdHzk3dIT5UPl3TnHO31yCl9I98uy2Kp5phESUccJaX9Ebd1gm0il8-dpcDV8A-V7-NA";

// Step 1: Get access token
$ch = curl_init("https://api-m.sandbox.paypal.com/v1/oauth2/token");
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => ["Accept: application/json", "Accept-Language: en_US"],
    CURLOPT_USERPWD    => $clientId . ":" . $secret,
    CURLOPT_POSTFIELDS => "grant_type=client_credentials",
    CURLOPT_RETURNTRANSFER => true
]);

$response = curl_exec($ch);
if ($response === false) {
    die("Token error: " . curl_error($ch));
}
curl_close($ch);

$result = json_decode($response, true);
$token  = $result['access_token'] ?? null;

if (!$token) {
    die("Failed to get access token: " . json_encode($result));
}

// Step 2: Get balances
$ch = curl_init("https://api-m.sandbox.paypal.com/v1/reporting/balances");
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ],
    CURLOPT_RETURNTRANSFER => true
]);

$response = curl_exec($ch);
if ($response === false) {
    die("Balance error: " . curl_error($ch));
}
curl_close($ch);

$balances = json_decode($response, true);

// Step 3: Extract PHP balance
$balanceValue = "0.00";
$balanceCurrency = "N/A";

if (!empty($balances['balances'])) {
    foreach ($balances['balances'] as $bal) {
        if (!empty($bal['currency']) && $bal['currency'] === "PHP") {
            $balanceValue = $bal['total_balance']['value'] ?? "0.00";
            $balanceCurrency = $bal['total_balance']['currency_code'] ?? "PHP";
            break;
        }
    }
}
