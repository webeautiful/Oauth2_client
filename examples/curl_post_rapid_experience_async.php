<?php
/*
* 模拟post请求
* 写作API
*/
require '../src/Oauth2_client/Autoloader.php';
Oauth2_client\Autoloader::register();
use Oauth2_client\Curl;

$token = 'd10a600323a82662dbbc9d6fd1b7f7f500596c1e';

$txt = "
Dear Mary,

I would like to take this opportunity to express my heartfelt gratitude to you for your help when I was in difficulty. You have been very kind and helpful since we knew each other.

Last week, I caught a bad cold and had to stay at home for a week. When I was worrying about the lessons, you came to my home after school and helped me with every subject. With your help, I didn't fall behind others.

Again, thanks so much for your enthusiastic help. Even though you are to about to go abroad for further education, I know that I will always stay in touch with you. I wish you every success in the future and I hope we can exchange more viewpoints on study.

Please keep in touch, and drop in and visit us whenever you are in this part of the world.

Very sincerely,

Peter";
$data = array(
    'access_token'=>$token,
    'title' => 'My First Day of College',
    'comcontext' => $txt,//"On August 27th, I arrived at Hunan University with excitement and anticipation.\n Before coming to Hunan University, I always imagined what my college, which has a history of thousands of years, would be like. Amazing that I fell in love with it at my first sight. Although there are no tall buildings, antique buildings made me feel the accumulation of culture. In the process of the enrollment, an enthusiastic senior took a photo for me to record my first day of college. Then another senior, who happened to be my fellow-townsman, did me a favor by carrying luggage and introduced the basic situation of campus. Unconsciously, because the night was coming, I have to face the departure of my parents. Nevertheless thanks to my three extremely friendly roommates' encouragement, I could contain my raw emotions.\n I'll never forget the day I stepped into Hunan University which is always my dream college.I hope I can spend four years of memorable time.",
    'solution'=> $txt,
    'scope'=> 'all_json',
    'key'=> 'hujiang',
    'lang'=>'zh_cn'
);

$http_start = microtime(true);

$http = new Curl();
$header = array(
    'Content-Type: application/x-www-form-urlencoded'
);
//$http->setOpt(CURLOPT_HTTPHEADER, $header);
$api = 'http://api.pigai.org/dessays/rapid_experience_async';
$http->post($api, http_build_query($data));

$http_end = microtime(true);
$elapsed_time = $http_end - $http_start;
echo $http->rawResponse;

//echo '---'.$elapsed_time.'---';

?>
