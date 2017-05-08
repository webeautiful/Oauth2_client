<?php
namespace Oauth2_client;
use Oauth2_client\Cache_file;
use Oauth2_client\Curl;

class Token
{
    private $cache;
    private $curl;

    private $cacheTokenKey;
    private $clientId;
    private $clientSecret;
    private $authUrl;
    private $timeoutEarly;

    function __construct($config = array())
    {
        $config = array_merge(array(
            'cache_path'=> '',
            'base_url'=> null,
            'cache_token_key'=>'access_token',//缓存token的键名,也即缓存文件名
            'client_id'=>null,
            'client_secret'=>null,
            'auth_url'=>'',
            'timeout_early'=> 30 //更新token时间提前30s
        ), $config);
        $path = $config['cache_path'];
        $base_url = $config['base_url'];
        $this->cache = new Cache_file($path);
        $this->curl = new Curl($base_url);

        $this->cacheTokenKey = $config['cache_token_key'];
        $this->clientId = $config['client_id'];
        $this->clientSecret = $config['client_secret'];
        $this->authUrl = $config['auth_url'];
        $this->timeoutEarly = intval($config['timeout_early']);
    }

    function getCache($path = ''){
        return $this->cache;
    }
    function getCurl(){
        return $this->curl;
    }

    function getValidAccessToken($grant_type)
    {
        switch($grant_type){
            case 'client_credentials':
                return $this->receiveClientToken();
                break;
            default :
                die('授权方式错误!');
                break;
        }
    }
    function receiveImplicitToken()
    {
    }
    function receiveClientToken() 
    {
        if(!$this->cacheTokenKey || !$this->clientId || !$this->clientSecret || !$this->authUrl){
            return ;
        }
        $key = $this->cacheTokenKey;
        if(!$access_token = $this->cache->get($key)){
            $this->curl->setBasicAuthentication($this->clientId, $this->clientSecret);
            $data = array(
                'grant_type'=>'client_credentials'
            );  
            $this->curl->post($this->authUrl, $data);
            $token = $this->curl->response;
            if(is_object($token) && isset($token->access_token)){
                $access_token = $token->access_token;
                $this->cache->save($key, $access_token, $token->expires_in, $this->timeoutEarly);
            }else{
                die('配置参数错误或接口返回值错误');
            }
        }
        return $access_token;
    }
}
?>
