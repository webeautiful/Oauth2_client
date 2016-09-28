<?php
/*
* 句子翻译接口
*/
require '../src/Oauth2_client/Autoloader.php';
Oauth2_client\Autoloader::register();
use Oauth2_client\Curl;

test_trans();

function test_trans(){
    $token = 'xxxxxx';
    $answer = array("With the keys held in his hand");
    $solution = json_encode(array('Urbanization presents a process that rural people migrate into the cities.', 'A key index of a nation’s urbanization level is the distribution of its population in urban and rural areas.', 'Urbanization presents a process that rural people migrate into the cities. A key index of a nation’s urbanization level is the distribution of its population in urban and rural areas. The urbanization rate of China registered over 50% last year, which marks that our country has stepped into a new “city-based society”. Urbanization becomes an important part of our society and economic development. By offering better education and job opportunities to urban citizens, it not only improves people’s living standards, but also it makes their culture colorful.'));
    //$solution = 'Urbanization presents a process that rural people migrate into the cities. A key index of a nation’s urbanization level is the distribution of its population in urban and rural areas. The urbanization rate of China registered over 50% last year, which marks that our country has stepped into a new “city-based society”. Urbanization becomes an important part of our society and economic development. By offering better education and job opportunities to urban citizens, it not only improves people’s living standards, but also it makes their culture colorful.';
    $info_word = array("held");
    $data = array (
        "comcontext"=>"Urbanization presents a process that rural people migrate into the cities. A key index of a nation’s urbanization level is the distribution of its population in urban and rural areas. The urbanization rate of China registered over 50% last year, which marks that our country has stepped into a new “city-based society”. Urbanization becomes an important part of our society and economic development. By offering better education and job opportunities to urban citizens, it not only improves people’s living standards, but also it makes their culture colorful.",//这个字段放翻译好的句子
        "solution"=>$solution,//参考译文，放一个一维数组就array(参考译文1,参考译文2), 注: 至少有一篇参考译文的句子数等于snt的句子数
        //"info_word"=>json_encode($info_word),//这个是限定词，有的话就是个数组，一个限定词是一个数组元素，没有的话是一个空的array()
        'access_token'=>$token,
        //'scope'=> 'all_json'
        //'do'=> 'debug'
    );
    //print_r(http_build_query($data));die;
    $http = new Curl();
    $api = 'http://api.pigai.org/translation/trans_sentence';
    $query_string = http_build_query($data);
    $http->post($api, $query_string);
    echo $http->rawResponse;
}
?>
