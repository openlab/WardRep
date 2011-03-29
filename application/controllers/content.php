<?php

/**
 * @ignore
 */
defined('BASEPATH') OR exit;

/**
 * Content
 */
class Content extends AppController {
    /* Member variables */
    /**
     * __construct
     *
     * @access: public
     * @param: void
     * @return: void
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * index
     *
     * @access: public
     * @param: void
     * @return: void
     */
    public function index() {
        redirect('/');
        exit;
    }
    
    /**
     * about
     *
     * @access: public
     * @param: void
     * @return: void
     */
    public function about() {
        $this->render(array('header', 'about', 'footer'));
    }
    
    /**
     * feedback
     *
     * @access: public
     * @param: void
     * @return: void
     */
    public function feedback() {
        $this->load->helper('form');
        
        $has_errors = false;
        $name = $email = $message = '';
        if( $this->input->post('submit') )
        {
            $name    = trim($this->input->post('name'));
            $email   = trim($this->input->post('email'));
            
            $message = trim($this->input->post('message'));
            $message = strip_tags($message);
            
            if( empty($name) || empty($email) || empty($message) )
            {
                $this->_view_vars['error_message'] = 'All fields marked with an asterisk are required.';
                $this->_view_vars['has_error'] = $has_errors = true;
            }
            
            if( !$has_errors )
            {
                $this->load->helper('email');
                if( !valid_email($email) )
                {
                    $this->_view_vars['error_message'] = 'The entered email address is invalid.';
                    $this->_view_vars['has_error'] = $has_errors = true;
                }
            }
            
            if( !$has_errors )
            {
                $this->load->library('email');
                $this->email->from($emai, $name);
                $this->email->to($this->config->item('site_email'));
                
                $this->email->subject('[ WARDREP.CA ] Contact and Feedback Form');
                $this->email->message($message);
                
                if( $this->email->send() )
                {
                    $this->_view_vars['success_message'] = 'Thank you for contacting us, we will get back to you as soon as possible.';
                    $this->_view_vars['has_error'] = $has_errors = false;
                    $this->_view_vars['is_success'] = true;
                }
            }
        }
        
        $this->_view_vars += array(
            'name' => $name,
            'email' => $email,
            'message' => $message
        );
        
        $this->render(array('header', 'feedback', 'footer'));
    }
    
    /**
     * legal
     *
     * @access: public
     * @param: void
     * @return: void
     */
    public function legal() {
        $this->render(array('header', 'legal', 'footer'));
    }
}