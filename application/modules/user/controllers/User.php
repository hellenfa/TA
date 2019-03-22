<?php

/**
 * Class User
 * @property User $user
 * @property User_model $user_model
 * @property DT_User_model $dt
 */
class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        if ($this->ion_auth->user()->row()->type != 'admin'){
            redirect('auth/login');
        }
        $this->load->library( array( 'ion_auth', 'form_validation' ) );
        $this->form_validation->set_error_delimiters( $this->config->item( 'error_start_delimiter', 'ion_auth' ), $this->config->item( 'error_end_delimiter', 'ion_auth' ) );
        $this->load->model('user/user_model');
        $this->load->model('user/dt_user_model', 'dt');
        $this->load->model( 'auth/ion_auth_model', 'ion_auth_model' );
        $this->load->helper(array('form_helper','url','modal_helper','bs_helper'));

        //$this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Pengguna';
        $data['user'] = 'active';
        $data['users'] = $this->user_model->user()->result();

        $this->template->main('user/index', $data);
    }

    public function fetch_data()
    {
        $fetch_data = $this->dt->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->type;
            $sub_array[] = $row->username;
            $sub_array[] = $row->first_name;
            $sub_array[] = $row->last_name;
            $sub_array[] = $row->email;
            $sub_array[] = $row->phone;
            $sub_array[] = ($row->active==1)?'<span class="label label-success">Aktif</span>':'<span class="label label-danger">Tidak Aktif</span>';
            $btn = ajax_modal('user/detail/' . $row->id, 'Detail', array('info', 'info')).' ';
            $btn .= ajax_modal('user/edit/' . $row->id, 'Ubah', array('warning', 'pencil')).' ';
            if($row->active == 1){
            $btn .= ajax_modal('user/update_status/' . $row->id, 'Tidak aktif', array('danger', ''));
            }else
            $btn .= ajax_modal('user/update_status/' . $row->id, 'Aktif', array('success', ''));
            $sub_array[] = $btn;
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

    public function create()
    {
        //post form tambah folder
        if (count($_POST) > 0) {
            $data = array(
                'type'     => $this->input->post('tipe'),
                'username' => $this->input->post('nama_pengguna'),
                'first_name' => $this->input->post('nama_depan'),
                'last_name' => $this->input->post('nama_belakang'),
                'email'    => $this->input->post('email'),
                'phone' => $this->input->post('nomor_telepon'),
                'password' => password_hash( $this->input->post( 'kata_sandi' ), PASSWORD_BCRYPT )
            );
            $this->user_model->create($data);
            $this->session->set_flashdata('notice', 'Data berhasil ditambahkan');
            redirect('user/index');
        } //klik button tambah folder
        if($this->input->is_ajax_request()){
            $this->load->view('user/create');
        }else{
            $this->template->main('user/create');
        }
    }
    public function edit($id)
    {

        if (count($_POST) > 0) {

            $data = array(
                'type'     => $this->input->post('tipe'),
                'username' => $this->input->post('nama_pengguna'),
                'first_name' => $this->input->post('nama_depan'),
                'last_name' => $this->input->post('nama_belakang'),
                'email'    => $this->input->post('email'),
                'phone' => $this->input->post('nomor_telepon'),
                'password' => password_hash( $this->input->post( 'kata_sandi' ), PASSWORD_BCRYPT )

            );
            $this->user_model->edit($id, $data);
            foreach ($this->input->post('akses') as $d){
                $this->user_model->create_access_folder($this->input->post('id'),$d);
            }
            $this->session->set_flashdata('notice', 'Berhasil mengubah data pengguna');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
        
            $data = array(
                'users'  => $this->user_model->get_edit($id)->row(),
                'folder' => $this->user_model->get_folder($id)->result()
            );
            if($this->input->is_ajax_request()){
                $this->load->view('user/edit', $data);
            }else{
                $this->template->main('user/edit', $data);
            }
        }
    }
    public function detail($id) {
        
        $data = array();
        $data["userakses"] = $this->user_model->get_akses($id);
        if($this->input->is_ajax_request()){
            $this->load->view('user/detail', $data);
        }else{
            $this->template->main('user/detail', $data);
        }

    }
    public function update_status($id) {
        if (count($_POST) > 0) {
            if($this->user_model->get_user($id)->row()->active==1){
            $data = array(
            'active'=> 0);
            }else{
            $data = array(
            'active'=> 1);
            }
            $this->user_model->update_status($id, $data);
            redirect($_SERVER["HTTP_REFERER"]);
        }else{
            $data=array(
            'id'=> $id,
            'users'=> $this->user_model->get_user($id)->row() );
            if($this->input->is_ajax_request()){
                if($this->user_model->get_user($id)->row()->active==1){
                $this->load->view('user/deactive', $data);
                }else{
                $this->load->view('user/active', $data);
            }
            }else{
                if($this->user_model->get_user($id)->row()->active==1){
                $this->template->main('user/deactive', $data);
            }else{
                $this->template->main('user/active', $data);
            }
            }
            
        }
        
    }
    public function active($id) {

            $this->load->view('user/active');
    }
      public function non_active($id) {

            $this->load->view('user/non_active');
    }
}