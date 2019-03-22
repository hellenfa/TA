<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        if($this->ion_auth->user()->row()->username!='administrator'){
            redirect('dokumentasi/index');
        }
        $this->load->model('dashboard_model');
    }

    public function index()
    {
        redirect('dokumentasi');

        $data['js_view'] = array('https://maps.googleapis.com/maps/api/js?key=' . $this->config->item("gmaps_api_token") . '&callback=initMap');
        $data['title'] = 'Dashboard';
        $data['dashboard'] = 'active';
        $data['sppd_chart'] = array(30, 10, 13, 17, 19, 40, 60, 89, 34, 12, 34, 22);
        $data['spj_chart'] = array(0, 13, 23, 12, 11, 14, 16, 39, 14, 2, 11, 6);

        $this->template->main('dashboard/dashboard_v',$data);
    }

    public function index2($var)
    {

        $data = array(
            'var1' => $var,
            'title' => 'hello world',
            'grup' => $this->dashboard_model->grup()->result()
        );
//        die(var_dump($data));
        $this->template->main('dashboard/test',$data);
    }
}