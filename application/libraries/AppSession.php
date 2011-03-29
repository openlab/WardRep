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
    /**
     * @var string      Contains the session id.
     */
    protected $_id;
    
    /**
     * @var array       Contains the session data. Ref of $_SESSION
     */
    protected $_data = array();
    
    /**
     * __construct
     *
     * @access: public
     * @param:  void
     * @return: void
     */
    public function __construct()
    {
        $this->initialize();
    }
    
    /**
     * __destruct
     *
     * @access: public
     * @param:  void
     * @return: void
     */
    public function __destruct()
    {
        $this->close();
    }
    
    /**
     * close
     *
     * Method stub for later use.
     *
     * @access: public
     * @param:  void
     * @return: void
     */
    public function close()
    {
        /* void */
    }
    
    /**
     * destroy
     *
     * Destroys the session.
     *
     * @access: public
     * @param:  void
     * @return: void
     */
    public function destroy()
    {
        session_destroy();
        
        $this->_id = null;
        $this->_data = array();
    }
    
    /**
     * getAll
     *
     * Access all the stored session data.
     *
     * @access: public
     * @param:  void
     * @return: array
     */
    public function getAll()
    {
        return $this->_data;
    }
    
    /**
     * getAllByRef
     *
     * Returns all the stored session data by reference.
     *
     * @access: public
     * @param:  void
     * @return: array
     */
    public function &getAllByRef()
    {
        return $this->_data;
    }
    
    /**
     * get
     *
     * Access to a single session item. Returns NULL if it does not exist.
     *
     * @access: public
     * @param:  string
     * @return: mixed
     */
    public function get($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }
    
    /**
     * getId
     *
     * Accessor for the session id.
     *
     * @access: public
     * @param:  void
     * @return: string
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * set
     *
     * Mutator method for a single session key value pair.
     *
     * @access: public
     * @param:  string
     * @param:  mixed
     * @return: void
     */
    public function set($key, $value)
    {
        $this->_data[$key] = $value;
    }
    
    /**
     * remove
     *
     * @access: public
     * @param:  string
     * @return: bool
     */
    public function remove($key)
    {
        if( isset($this->_data[$key]) )
        {
            unset($this->_data[$key]);
            return true;
        }
        
        return false;
    }
    
    /**
     * exists
     *
     * @access: public
     * @param:  string
     * @return: bool
     */
    public function exists($key)
    {
        return isset($this->_data[$key]);
    }
    
    /**
     * regenerateId
     *
     * @access: public
     * @param:  bool
     * @return: void
     */
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
    
    /**
     * initialize
     *
     * Handles the class and session initializing.
     *
     * @access: protected
     * @param:  void
     * @return: void
     */
    protected function initialize()
    {
        if( !($this->_has_started = session_start()) )
        {
            throw new Exception('Unable to start session.');
        }
        
        $this->_id = session_id();
        $this->_data = &$_SESSION;
    }
    
    /**
     * __toString
     *
     * @access: public
     * @param:  void
     * @return: string
     */
    public function __toString()
    {
        return '[ ' . __CLASS__ . '] ' . $this->_id;
    }
}