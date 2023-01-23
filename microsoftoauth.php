<?php
session_start();
require_once("./vendor/autoload.php");


$clientId = "ed194303-ed67-478c-9ce5-9c1de7eab56b";
$tenantId = "common";
$secret = "2.w8Q~YKmdjncG6WTBBwQZxCecgcQNbEs_6Zvbw6";
$redirectUri = "http://localhost:8080/microsoftoauth.php";
$scopes = ['user.read', 'calendars.read'];
$baseOauthUri = "https://login.microsoftonline.com/" . $tenantId . "/oauth2/v2.0/";
$randomStringAsState = sha1(rand());


$oauthAuthorizationUri = $baseOauthUri . "authorize?" . http_build_query([
  'client_id' => $clientId,
  'response_type' => 'code',
  'redirect_uri' => $redirectUri,
  'scope' => implode(' ', $scopes),
  'response_mod' => 'query',
  'prompt' => 'consent',
  'state' => $randomStringAsState
]);

$oauthTokenUri = $baseOauthUri . "token";
$oauthTokenClient = new GuzzleHttp\Client(['base_uri' => $oauthTokenUri]);




//redirected from oauth authorize and state match
// sleep(5);
if ($_GET['code'] && $_GET['state'] == $_SESSION['state']) {
  //ask for token
  $body = [
    'client_id' => $clientId,
    'scope' => implode(' ', $scopes),
    'code' => $_GET['code'],
    'redirect_uri' => $redirectUri,
    'grant_type' => 'authorization_code',
    'client_secret' => $secret
  ];

  try {
    //code...
    $response = $oauthTokenClient->post('', ['form_params' => $body]);
    echo 'response: ' . $response->getBody();
  } catch (\GuzzleHttp\Exception\RequestException $e) {
    $response = $e->getResponse();
    if ($response) {
      $body = $response->getBody();
      echo '<pre>';
      var_dump($response);
      echo '<pre>';

      // Utiliser le corps de la réponse
    } else {
      echo '<pre>';
      var_dump($e);
      echo '<pre>';
    }
  }

} else {
  $_SESSION['state'] = $randomStringAsState;
  header("Location: " . $oauthAuthorizationUri);
}