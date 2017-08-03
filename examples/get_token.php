<?php
$url = 'http://api67.pigai.org/oauth2/access_token';
$data = array(
    'grant_type'=> 'client_credentials',
    'client_id'=> 'xxxx',
    'client_secret'=> 'xxxx',
);

cpost($url, $data);
$tokenInfo = json_decode($data, true);
$access_token = $tokenInfo['access_token'];
$expires_in = $tokenInfo['expires_in'];//7200s
echo $access_token.'---'.$expires_in;die;

function cpost( $url , &$data, $timeout=0 ,$header= array() ) {
    $ch = curl_init();
    $res= curl_setopt ($ch, CURLOPT_URL, $url );
    if( strpos($url,'https')!== false  ){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    }
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    if( $data!="" ){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
    }
    if( $timeout>0 ){
        curl_setopt ($ch, CURLOPT_TIMEOUT, $timeout );
    }

    if( $header  ) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

    $data  = curl_exec ($ch);
    $data = trim($data);
    $info= curl_getinfo( $ch );
    curl_close ($ch);
    return $info['http_code'];
}
?>
