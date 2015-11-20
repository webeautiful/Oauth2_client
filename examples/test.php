<?php
require '../src/Oauth2_client/Autoloader.php';
Oauth2_client\Autoloader::register();

use Oauth2_client\Token;
$client = new Token();

$cache = $client->getCache();

$key = 'access_token';
if(!$access_token = $cache->get($key)){
    $access_token = time();
    $cache->save('access_token', $access_token, 7);
}
echo $access_token;
?>
