<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Controller
 *
 * @property MY_Controller $my_controller My_Controller Module
 * @property Ion_auth $ion_auth Ion_auth Module
 * @property Template $template Template Module
 */
class MY_Controller extends MX_Controller{
	public $template;
    public function __construct() {
		parent::__construct();
		$this->load->library(array('ion_auth','encrypt'));
		$this->load->helper('pixel_admin_helper');
		$this->load->model('log_model');
		$this->load->library(array('session','user_agent'));
		$this->template = Modules::load('template');
	    setlocale (LC_TIME, 'id_ID.utf8');
	}
}