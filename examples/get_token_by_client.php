<?php
require '../src/Oauth2_client/Autoloader.php';
Oauth2_client\Autoloader::register();
use Oauth2_client\Token;

$config = array(
    'cache_token_key'=> 'your_token_cache_name',
    'client_id'=> 'your_app_key',
    'client_secret'=> 'your_app_secret',
    'auth_url'=> 'http://api.pigai.org/oauth2/access_token'
)

$client = new Token($config));
$access_token = $client->getValidAccessToken('client_credentials');

var_dump($access_token);
?>
