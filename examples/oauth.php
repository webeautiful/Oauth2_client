<?php
$access_key = 'bb#pigai*@#';

//$bbid = '123456';
//$uinfo = '{"name": "xiongfs", "email": "121023254@qq.com", "role": 2, "school": "华中科技大学", "stuNo": 20161024, "class": "机电一班", "schoolType": 5}';
$bbid = 'd7d73b3';
$uinfo = '{"name":"bbtest2","email":"xiongfs@gmail.com","role":1,"school":"","stuNo":"12345678","class":"","schoolType":0}';
$ts = time();
$params = array(
    'ts'=>$ts,
    'bbid'=> $bbid,
    'uinfo'=>$uinfo
);
ksort($params);
$str = http_build_query($params);
$sign = md5($str.$access_key);
$url = 'http://w64.pigai.org/d3/bb/login.php?'.$str.'&sign='.$sign;
echo $url;
