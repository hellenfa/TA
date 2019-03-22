<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Template
 * @property Template $template Template Module
 */
class Template extends MY_Controller{
	public function main($view, $data = array() ) {
        $data['content_view']   = $view;

		$this->load->view('template/ugm_main_v', $data);
	}
}