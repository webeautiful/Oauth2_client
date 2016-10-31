<?php
/*
* 模拟post请求
* file_get_contents的性能较差,建议生产环境使用curl
*/
$token = 'xxx';

$post_data = array(
    'access_token'=>$token,
    'title'=> "Listening is more important than talking. You can cite examples to illustrate the importance of pay attention to others' opinions.",
    'comcontext'=> "Nowadays it is comment to hear listening is more important than talking. I think this is definitely right. For example, in our english study, only you could understand what he said, and then you could talking with someone in english. Certainly, Listening is more importance.

    As listening is more importance, so how do we learn the it ? First of all, rules should be made by school to encourage us more practice listening. In the second, we are more and more realize the importance of listening in basic knowledge, in other words, this may be one of our primary concern in the english learnig. The thirdly, students study hard for listening, and obtain much knowledge from it.  Finanlly, only after listening to clearly, and we could to talk more confident.  

    From the reasons above, we may draw the conclusion that it is importance of listening than talking. There is no doubt that further attention must be paid to it.",
    'scope'=> 'all_json'
);

$api = 'http://api.pigai.org/essays/rapid_experience';
$ret = send_post($api, $post_data);
if($ret) {
    die($ret);
} else {
    die('Failure!');
}
/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */
function send_post($url, $post_data) {

  $postdata = http_build_query($post_data);
  $options = array(
    'http' => array(
      'method' => 'POST',
      'header' => 'Content-type:application/x-www-form-urlencoded',
      'content' => $postdata,
      'timeout' => 15 * 60 // 超时时间（单位:s）
    )
  );
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);

  return $result;
}
?>
