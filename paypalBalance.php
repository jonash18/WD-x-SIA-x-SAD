<?php
// Sandbox credentials
$clientId = "AScI4_3SDMrltP0uA-w5PS9KDjk27hlGMs7q3x0VrXGJgiuTaoBXkatjqBCxe4FUiAP2vP6ttxpRSAW0";
$secret   = "EJAcN-u_rjVFrdHzk3dIT5UPl3TnHO31yCl9I98uy2Kp5phESUccJaX9Ebd1gm0il8-dpcDV8A-V7-NA";

// Step 1: Get access token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept: application/json", "Accept-Language: en_US"]);
curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
$token = $result['access_token'] ?? null;

// Step 2: Get balance
$balanceValue = "0.00";
$balanceCurrency = "N/A";

if ($token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/reporting/balances");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $balances = json_decode($response, true);

    if (!empty($balances['balances'])) {
        // Pick the primary currency balance
        foreach ($balances['balances'] as $bal) {
            if (!empty($bal['primary']) && $bal['primary'] == 1) {
                $balanceValue = $bal['total_balance']['value'];
                $balanceCurrency = $bal['total_balance']['currency_code'];
                break;
            }
        }
    }
}
