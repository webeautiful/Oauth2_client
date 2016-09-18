<?php
/*
* 模拟post请求
*/
require '../src/Oauth2_client/Autoloader.php';
Oauth2_client\Autoloader::register();
use Oauth2_client\Curl;

$token = 'xxxx';

$data = array(
    'access_token'=>$token,
    'title'=> "Here is a title",
    'comcontext'=> ' This is the main message.',
    'scope'=> 'all_json'
);

$http_start = microtime(true);

$http = new Curl();
$header = array(
    'Content-Type: application/x-www-form-urlencoded'
);
//$http->setOpt(CURLOPT_HTTPHEADER, $header);
$api = 'http://api.pigai.org/essays/rapid_experience';
$http->post($api, http_build_query($data));

$http_end = microtime(true);
$elapsed_time = $http_end - $http_start;
echo $http->rawResponse;

//echo '---'.$elapsed_time.'---';

?>
