<?php

/**
 * Class Dokumentasi
 * @property Evaluation $dokumentasi
 * @property Evaluation_model $dokumentasi_model
 * @property DT_Evaluation_Model $dt
 */
class Evaluation extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->load->model('evaluation/evaluation_model');
        $this->load->model('evaluation/DT_Kriteria_model', 'dtk');
        $this->load->model('evaluation/DT_Parameter_model', 'dtp');
        $this->load->helper(array('form_helper', 'modal_helper', 'bs_helper', 'url'));
        $this->load->library('upload');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['title'] = 'Evaluation';
        $data['evaluation'] = 'active';
        // $data['folder'] = $this->dokumentasi_model->folder()->result();

        $this->template->main('evaluation/index', $data);
    }

    public function fetch_data()
    {
        $fetch_data = $this->dt->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '<a href="' . base_url('dokumentasi/subfolder') . '/' . $row->id_folder . '"><i class="fa fa-folder"></i>&nbsp;' . $this->excerpt($row->folder_name) . '</a>';
            $sub_array[] = $row->create_date;
            if($row->id_folder == 1 || $row->id_folder == 2){
                $sub_array[] = ajax_modal('dokumentasi/edit/' . $row->id_folder, 'Edit', array('warning', 'pencil'));
            } else {
            $sub_array[] = ajax_modal('dokumentasi/edit/' . $row->id_folder, 'Edit', array('warning', 'pencil')) . ' ' . ajax_modal('dokumentasi/delete/' . $row->id_folder, 'Delete', array(
                    'danger',
                    'trash'
                ));
            }
            $data[] = $sub_array;
        }

        $output = array(
            'draw'            => intval($_POST['draw']),
            'recordsTotal'    => $this->dt->get_all_data(),
            'recordsFiltered' => $this->dt->get_filtered_data(),
            'data'            => $data
        );
        echo json_encode($output);
    }

    public function api_user()
    {
        $id = $this->input->get('id');
        if ($id == null){
            $data = $this->dokumentasi_model->get_user_api()->result_array();

        }else{
            $data = $this->dokumentasi_model->get_first_user($id)->row_array();
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
