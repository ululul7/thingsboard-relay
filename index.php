<?php
header('Content-Type: application/json');

$data = array_map('intval', $_GET);
$token = "Wa4nK96lenwA6JkNN751";
$url = "https://thingsboard.cloud/api/v1/$token/telemetry";

if (!empty($data)) {
    $payload = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    echo json_encode([
        "status" => "forwarded",
        "http_code" => $http_code,
        "response" => $response,
        "curl_error" => $curl_error
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "⛔ Data kosong atau tidak valid"
    ]);
}
?>
