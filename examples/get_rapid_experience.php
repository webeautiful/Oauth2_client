<?php
$token = 'xxxxx';
$api = 'http://api.pigai.org/essays/rapid_experience?title=english&comcontext=english&scope=all_json&access_token='.$token;
$ctx = stream_context_create(array(
    'http' => array(
        'timeout' => 5 //设置一个超时时间，单位为s
    )
));
$ret = @file_get_contents($api, 0, $ctx);
if($ret) {
    print_r($ret);
} else {
    die('Failure!');
}
?>
