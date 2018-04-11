<?php

$url_base_autenticacao = "https://autenticacao.info.ufrn.br/";
$client_id = "<my_client_id>";
$client_secret = "<my_client_secret>";

$url_base = "https://api.info.ufrn.br/";
$x_api_key = "<my_x_api_key>";
$versao = "<versao_api>";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url_base_autenticacao . "authz-server/oauth/token?client_id=" . $client_id . "&" . "client_secret=" . $client_secret . "&grant_type=client_credentials",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST"
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

echo("<br /><br />");

#Pegando as informações do Json retornado
$jsonData = json_decode($response, true);

$token = $jsonData['access_token'];
$token_type = $jsonData['token_type'];


#Inicializando a consulta de teste.
$curlConsulta = curl_init();

curl_setopt_array($curlConsulta, array(
  CURLOPT_URL => $url_base . "curso/" . $versao . "/modalidades-educacao",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
   CURLOPT_HTTPHEADER => array(
    "Authorization: " . $token_type . " " . $token,
    "x-api-key: " . $x_api_key
  ),
));

$response = curl_exec($curlConsulta);
$err = curl_error($curlConsulta);

curl_close($curlConsulta);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

?>
