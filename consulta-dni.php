<?php
$token = 'apis-token-3745.OrnUFLRfWLBBDeLZAtgMPL6zAsGmmdTm';
$dni = $_POST['dni'];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $dni,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 2,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => [
        'Referer: https://apis.net.pe/consulta-dni-api',
        'Authorization: Bearer ' . $token,
    ],
]);
$response = curl_exec($curl);
curl_close($curl);
echo $response;
?>