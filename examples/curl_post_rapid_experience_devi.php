<?php
/*
* 模拟post请求
* 写作API(带跑题检测)
*/
require '../src/Oauth2_client/Autoloader.php';
Oauth2_client\Autoloader::register();
use Oauth2_client\Curl;

$token = 'xxxx';

$solution = json_encode(array("Driven by the economic development, going abroad for a holiday has become a way of leisure for the Chinese. China’s outbound tourists reached as many as 83 million last year. Chinese families are becoming used to taking vacations abroad. Parents usually take their annual leave in the summer vacation to travel with their children. An analysis report of the World Tourism Organization shows that Chinese tourists are the most powerful holiday consumer group.", "They have become a significant force in overseas shopping and created a great consumption value."));
//$solution = 'As economy booms, going abroad for holidays has become a way of leisure for the Chinese. In the last year, the number of Chinese tourists reached 83 million. Chinese families are becoming accustomed to going abroad for holidays. Parents usually ask for annual leave in summer holidays to go traveling with their children. An analysis report of the World Tourism Organization shows that the Chinese tourists are the most powerful consumer group in holidays. They have become a major force in overseas shopping, creating a huge consumption value.';
$data = array(
    'access_token'=>$token,
    'title'=> "The Toad and the Frog",
    'comcontext'=> urlencode('As economy booms, going abroad for holidays has become a way of leisure for the Chinese. In the last year, the number of Chinese tourists reached 83 million. Chinese families are becoming accustomed to going abroad for holidays. Parents usually ask for annual leave in summer holidays to go traveling with their children. An analysis report of the World Tourism Organization shows that the Chinese tourists are the most powerful consumer group in holidays. They have become a major force in overseas shopping, creating a huge consumption value.'),
    'solution'=> $solution,
    'scope'=> 'all_json'
);

$http_start = microtime(true);

//echo http_build_query($data);die;
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
