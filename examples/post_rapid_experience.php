<?php
/*
* 模拟post请求
* file_get_contents的性能较差,建议生产环境使用curl
*/
$token = 'your_token_cache_name';

$data = array(
    'access_token'=>$token,
    'title'=> "Here is a title",
    'comcontext'=> ' This is the main message.',
    'scope'=> 'all_json'
);

$http_start = microtime(true);
$api = 'http://api.pigai.org/essays/rapid_experience';
//$api = 'http://api67.pigai.org/essays/rapid_experience2';
$data = http_build_query($data);
$ctx = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                    ."Content-Length:" . strlen($data) . "\r\n",
        'content' => $data,
        'timeout' => 30 //设置一个超时时间，单位为s
    )
));
$ret = @file_get_contents($api, false, $ctx);
if($ret) {
    print_r($ret);
    $http_end = microtime(true);
    $elapsed_time = $http_end - $http_start;
    //echo '---'.$elapsed_time.'---';
} else {
    die('Failure!');
}
?>
