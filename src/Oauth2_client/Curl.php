<?php
namespace Oauth2_client;

class Curl
{
    const DEFAULT_TIMEOUT = 30;

    public $curl;

    public $baseUrl = null;
    public $url = null;

    private $options = array();

    private $jsonDecoder = null;

    /**
     * Construct
     *
     * @access public
     * @param  $base_url
     * @throws \ErrorException
     */
    public function __construct($base_url = null)
    {
        if (!extension_loaded('curl')) {
            throw new \ErrorException('cURL library is not loaded');
        }

        $this->curl = curl_init();
        $this->setDefaultJsonDecoder();
        $this->setDefaultTimeout();
        $this->setOpt(CURLINFO_HEADER_OUT, true);
        $this->setOpt(CURLOPT_RETURNTRANSFER, true);
        $this->setURL($base_url);
    }
    /**
     * Get
     *
     * @access public
     * @param  $url
     * @param  $data
     *
     * @return string
     */
    public function get($url, $data = array())
    {
        if (is_array($url)) {
            $data = $url;
            $url = $this->baseUrl;
        }
        $this->setURL($url, $data);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'GET');
        $this->setOpt(CURLOPT_HTTPGET, true);
        return $this->exec();
    }

    /**
     * Get Opt
     *
     * @access public
     * @param  $option
     *
     * @return mixed
     */
    public function getOpt($option)
    {
        return $this->options[$option];
    }

    /**  
     * Post
     *
     * @access public
     * @param  $url
     * @param  $data
     *
     * @return string
     */
    public function post($url, $data = array())
    {    
        if (is_array($url)) {
            $data = $url;
            $url = $this->baseUrl;
        }    

        $this->setURL($url);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'POST');
        $this->setOpt(CURLOPT_POST, true);
        $this->setOpt(CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }  
    /**
     * Exec
     *
     * @access public
     * @param  $ch
     *
     * @return string
     */
    public function exec()
    {   
        $this->rawResponse = curl_exec($this->curl);
        $response = $this->rawResponse;
        $json_decoder = $this->jsonDecoder;
        //if (is_callable($json_decoder)) {
            $this->response = $json_decoder($response);
        //}
        return $this->response;
    }

    /**
     * Set Url
     *
     * @access public
     * @param  $url
     * @param  $data
     */
    public function setURL($url, $data = array())
    {
        $this->baseUrl = $url;
        $this->url = $this->buildURL($url, $data);
        $this->setOpt(CURLOPT_URL, $this->url);
    }
    /**
     * Build Url
     *
     * @access private
     * @param  $url
     * @param  $data
     *
     * @return string
     */
    private function buildURL($url, $data = array())
    {
        return $url . (empty($data) ? '' : '?' . http_build_query($data));
    }
    /**
     * Set Default JSON Decoder
     *
     * @access public
     */
    public function setDefaultJsonDecoder()
    {
        $this->jsonDecoder = function($response) {
            $json_obj = json_decode($response, false);
            if (!($json_obj === null)) {
                $response = $json_obj;
            }
            return $response;
        };
    }
    /**
     * Set Default Timeout
     *
     * @access public
     */
    public function setDefaultTimeout()
    {
        $this->setTimeout(self::DEFAULT_TIMEOUT);
    }
    /**
     * Set Timeout
     *
     * @access public
     * @param  $seconds
     */
    public function setTimeout($seconds)
    {
        $this->setOpt(CURLOPT_TIMEOUT, $seconds);
    }
    /**
     * Set Opt
     *
     * @access public
     * @param  $option
     * @param  $value
     *
     * @return boolean
     */
    public function setOpt($option, $value)
    {
        $required_options = array(
            CURLOPT_RETURNTRANSFER => 'CURLOPT_RETURNTRANSFER',
        );

        if (in_array($option, array_keys($required_options), true) && !($value === true)) {
            trigger_error($required_options[$option] . ' is a required option', E_USER_WARNING);
        }

        $this->options[$option] = $value;
        return curl_setopt($this->curl, $option, $value);
    }
    /**
     * Set Basic Authentication
     *
     * @access public
     * @param  $username
     * @param  $password
     */
    public function setBasicAuthentication($username, $password = '')
    {
        $this->setOpt(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $this->setOpt(CURLOPT_USERPWD, $username . ':' . $password);
    }

    /**
     * Close
     *
     * @access public
     */
    public function close()
    {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }
        $this->options = null;
        $this->jsonDecoder = null;
    }
    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {
        $this->close();
    }
}
?>
