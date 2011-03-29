<?php

/**
 * @ignore
 */
defined('BASEPATH') OR exit;

/**
 * AppController
 */
class AppController extends Controller {
    /* Member variables */
    /**
     * @var array
     */
    protected $_view_vars = array();
    
    /**
     * @var AppSession
     */
    public $_session = null;
    
    /**
     * __construct
     *
     * @access: public
     * @param:  void
     * @return: void
     */
    public function __construct() {
        parent::Controller();
        
        $this->_view_vars = array(
            'base_path' => base_url(),
            'application_js' => array(
                'Application' => array(
                    'config' => array( 'base_path' => base_url() ),
                    'behaviors' => array()
                )
            )
        );
        
        $this->load->library('AppSession', null, '_session');
    }
    
    /**
     * __destruct
     *
     * @access: public
     * @param:  void
     * @return: void
     */
    public function __destruct() {
        unset($this->_session);
    }
    
    /**
     * render
     *
     * @access: protected
     * @param:  array   Contains an array of view files to render
     * @return: void
     */
    protected function render(array $views) {
        if( is_array($views) )
        {
            $this->before_render();
            
            foreach( $views as &$view )
            {
                $this->load->view($view, $this->_view_vars);
            }
            
            return true;
        }
        
        return false;
    }
    
    protected function before_render() {
        $app_js = '';
        foreach( $this->_view_vars['application_js'] as $var => &$data )
        {
            $app_js .= "var {$var} = " . to_javascript($data) . ";\n";
        }
        unset($data, $this->_view_vars['application_js']);
        
        $this->_view_vars['application_js'] = $app_js;
    }
}