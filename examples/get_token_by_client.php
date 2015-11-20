<?php
require '../src/Oauth2_client/Autoloader.php';
Oauth2_client\Autoloader::register();
use Oauth2_client\Token;

$key = 'client_token';
$client = new Token(array(
    'cache_token_key'=> $key,
    'client_id'=> 'demoapp',
    'client_secret'=> 'demopass',
    'auth_url'=> 'http://api67.pigai.org/oauth2/access_token'
));
$access_token = $client->getValidAccessToken('client_credentials');

var_dump($access_token);
?>
