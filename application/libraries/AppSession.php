<?php

/**
 * @ignore
 */
defined('BASEPATH') OR exit;

/**
 * AppSession
 */
class AppSession
{
    protected $_id;
    protected $_has_started = false;
    protected $_data = array();
    
    public function __construct()
    {
        $this->initialize();
    }
    
    public function __destruct()
    {
        $this->close();
    }
    
    public function close()
    {
        /* void */
    }
    
    public function destroy()
    {
        session_destroy();
    }
    
    public function getAll()
    {
        return $this->_data;
    }
    
    public function &getAllByRef()
    {
        return $this->_data;
    }
    
    public function get($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function set($key, $value)
    {
        $this->_data[$key] = $value;
    }
    
    public function remove($key)
    {
        if( isset($this->_data[$key]) )
        {
            unset($this->_data[$key]);
            return true;
        }
        
        return false;
    }
    
    public function exists($key)
    {
        return isset($this->_data[$key]);
    }
    
    public function regenerateId($delete_old_session = false)
    {
        if( $delete_old_session )
        {
            $this->_data = array();
            $this->_id   = null;
        }
        
        session_regenerate_id($delete_old_session);
        
        $this->_id = session_id();
    }
    
    protected function initialize()
    {
        if( !($this->_has_started = session_start()) )
        {
            throw new Exception('Unable to start session.');
        }
        
        $this->_id = session_id();
        $this->_data = &$_SESSION;
    }
    
    public function __toString()
    {
        return '[ ' . __CLASS__ . '] ' . $this->_id;
    }
}