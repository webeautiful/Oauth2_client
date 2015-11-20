<?php
namespace Oauth2_client;

/*
* file cache
*
* @author xiongfusong@gmail
* @date 2015-11-20
*/

class Cache_file
{
    /**
     * Directory in which to save cache files
     *
     * @var string
     */
    protected $_cache_path;

    /**
     * Initialize file-based cache
     *
     * @return  void
     */
    public function __construct($path = '')
    {
        $this->_cache_path = ($path === '') ? dirname(__FILE__).'/cache/' : $path;
    }

    /**
     * Fetch from cache
     *
     * @param   string  $id Cache ID
     * @return  mixed   Data on success, FALSE on failure
     */
    public function get($id)
    {
        $data = $this->_get($id);
        return is_array($data) ? $data['data'] : FALSE;
    }

    /**
     * Save into cache
     *
     * @param   string  $id Cache ID
     * @param   mixed   $data   Data to store
     * @param   int $ttl    Time to live in seconds
     * @param   bool    $raw    Whether to store the raw value (unused)
     * @return  bool    TRUE on success, FALSE on failure
     */
    public function save($id, $data, $ttl = 60, $raw = FALSE)
    {
        $contents = array(
            'time'      => time(),
            'ttl'       => $ttl,
            'data'      => $data
        );

        if (self::write_file($this->_cache_path.$id, serialize($contents)))
        {
            chmod($this->_cache_path.$id, 0640);
            return TRUE;
        }

        return FALSE;
    }
    /**
     * Delete from Cache
     *
     * @param   mixed   unique identifier of item in cache
     * @return  bool    true on success/false on failure
     */
    public function delete($id)
    {
        return file_exists($this->_cache_path.$id) ? unlink($this->_cache_path.$id) : FALSE;
    }
    /**
     * Get all data
     *
     * Internal method to get all the relevant data about a cache item
     *
     * @param   string  $id Cache ID
     * @return  mixed   Data array on success or FALSE on failure
     */
    protected function _get($id)
    {
        if ( ! is_file($this->_cache_path.$id))
        {
            return FALSE;
        }

        $data = unserialize(file_get_contents($this->_cache_path.$id));

        if ($data['ttl'] > 0 && time() > $data['time'] + $data['ttl'])
        {
            unlink($this->_cache_path.$id);
            return FALSE;
        }

        return $data;
    }
    // ------------------------------------------------------------------------
    /** 
     * Write File
     *
     * Writes data to the file specified in the path.
     * Creates a new file if non-existent.
     *
     * @param   string  $path   File path
     * @param   string  $data   Data to write
     * @param   string  $mode   fopen() mode (default: 'wb')
     * @return  bool
     */
    public static function write_file($path, $data, $mode = 'wb')
    {   
        if ( ! $fp = @fopen($path, $mode))
        {   
            return FALSE;
        }   

        flock($fp, LOCK_EX);

        for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result)
        {   
            if (($result = fwrite($fp, substr($data, $written))) === FALSE)
            {   
                break;
            }   
        }   

        flock($fp, LOCK_UN);
        fclose($fp);

        return is_int($result);
    }   
}
?>
