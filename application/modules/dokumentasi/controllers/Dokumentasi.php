<?php

/**
 * Class Dokumentasi
 * @property Dokumentasi $dokumentasi
 * @property Dokumentasi_model $dokumentasi_model
 * @property DT_Dokumentasi_Model $dt
 */
class Dokumentasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->load->model('dokumentasi/dokumentasi_model');
        $this->load->model('dokumentasi/dt_dokumentasi_model', 'dt');
        $this->load->model('dokumentasi/dt_subfolder_model', 'dts');
        $this->load->model('dokumentasi/dt_folder_progress_report_model', 'dtp');
        $this->load->model('dokumentasi/dt_log_dokumentasi_model', 'dtl');
        $this->load->helper(array('form_helper', 'modal_helper', 'bs_helper', 'url'));
        $this->load->library('upload');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['title'] = 'Documentation';
        $data['dokumentasi'] = 'active';
        $data['folder'] = $this->dokumentasi_model->folder()->result();

        $this->template->main('dokumentasi/index', $data);
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


    public function subfolder($id)
    {
        if($id == 1){
           $this->load->model('dokumentasi/DT_Folder_Progress_Report_model', 'dtp');
            $data = array(
            'title'       => 'Documentation',
            'dokumentasi' => 'active',
            // 'data'        => $this->dokumentasi_model->get_document_folder($id)->result(),
            'bc'          => $this->dokumentasi_model->get_bc($id),
            'id'          => $id
            );
            $this->template->main('dokumentasi/folder_progress_report', $data); 
        } else {
        $this->load->model('dokumentasi/dt_subfolder_model', 'dts');
        $data = array(
            'title'       => 'Documentation',
            'dokumentasi' => 'active',
            'data'        => $this->dokumentasi_model->get_subfolder($id)->result(),
            'bc'          => $this->dokumentasi_model->get_bc($id),
            'id'          => $id
        );
        $this->template->main('dokumentasi/subfolder', $data);
        }
    }

    public function fetch_data_subfolder($id_parent)
    {
        $this->load->model('dokumentasi/dt_subfolder_model', 'dts');
        $this->dts->set_parent($id_parent);
        $fetch_data = $this->dts->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            if ($row->type == "document" && $row->extension == '.pdf') {
                $sub_array[] = ajax_text_modal('dokumentasi/document' . '/' . $row->id, '<i class="fa fa-file-pdf-o"></i>&nbsp;' . $this->excerpt($row->name) ,array(),'target="_blank"');
            }elseif ($row->type == "document" && $row->extension == '.png' || $row->extension == '.jpg' || $row->extension == '.jpeg') {
                $sub_array[] = ajax_text_modal('dokumentasi/document' . '/' . $row->id, '<i class="fa fa-file-image-o"></i>&nbsp;' . $this->excerpt($row->name) ,array());
            } elseif ($row->type == "document") {
                $sub_array[] ='<a title="' . $row->name . '" href="' . base_url('dokumentasi/download_document') . '/' . $row->id . '">' . '<i class="fa fa-file-o"></i>&nbsp;' . $this->excerpt($row->name) .'</a>';

            }
            else {
                $sub_array[] = '<a title="' . $row->name . '" href="' . base_url('dokumentasi/subfolder') . '/' . $row->id . '">' . '<i class="fa fa-folder"></i>&nbsp;' . $this->excerpt($row->name) . '</a>';
            }
            $sub_array[] = $row->create_date;
            if ($row->type == "document") {
                $sub_array[] = ajax_modal('dokumentasi/edit_document/' . $row->id, 'Edit', array('warning', 'pencil')) . ' ' . ajax_modal('dokumentasi/delete_document/' . $row->id, 'Delete', array(
                        'danger',
                        'trash'
                    ));
            } else {
                $sub_array[] = ajax_modal('dokumentasi/edit_subfolder/' . $row->id, 'Edit', array('warning', 'pencil')) . ' ' . ajax_modal('dokumentasi/delete/' . $row->id, 'Delete', array(
                        'danger',
                        'trash'
                    ));
            }
            if ($row->type == "document") {
                $sub_array[] = ajax_modal('dokumentasi/log_document_view/' . $row->id, 'Log', array('success', 'search'));
            } else {
                $sub_array[] = null;
            }
            $data[] = $sub_array;
        }

        $output = array(
            'draw'            => intval($_POST['draw']),
            'recordsTotal'    => $this->dts->get_all_data(),
            'recordsFiltered' => $this->dts->get_filtered_data(),
            'data'            => $data
        );
        echo json_encode($output);
    }

    public function fetch_data_folder_progress_report($id)
    {
        $this->load->model('dokumentasi/dt_folder_progress_report_model', 'dtp');
        $fetch_data = $this->dtp->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            if ($row->extension == '.pdf') {
                $sub_array[] = ajax_text_modal('dokumentasi/document' . '/' . $row->id_doc, '<i class="fa fa-file-pdf-o"></i>&nbsp;' . $this->excerpt($row->doc_name) ,array(),'target="_blank"');
            }elseif ($row->extension == '.png' || $row->extension == '.jpg' || $row->extension == '.jpeg') {
                $sub_array[] = ajax_text_modal('dokumentasi/document' . '/' . $row->id_doc, '<i class="fa fa-file-image-o"></i>&nbsp;' . $this->excerpt($row->doc_name) ,array());
            } else {
                $sub_array[] ='<a title="' . $row->doc_name . '" href="' . base_url('dokumentasi/download_document') . '/' . $row->id_doc . '">' . '<i class="fa fa-file-o"></i>&nbsp;' . $this->excerpt($row->doc_name) .'</a>';
            }
            $sub_array[] = $row->upload_date;
            $sub_array[] = $row->id_detail_subkegiatan;
            $sub_array[] = ajax_modal('dokumentasi/edit_document/' . $row->id_doc, 'Edit', array('warning', 'pencil')) . ' ' . ajax_modal('dokumentasi/delete_document/' . $row->id_doc, 'Delete', array(
                        'danger',
                        'trash'
                    ));
            $sub_array[] = ajax_modal('dokumentasi/log_document_view/' . $row->id_doc, 'Log', array('success', 'search'));
            $data[] = $sub_array;
        }

        $output = array(
            'draw'            => intval($_POST['draw']),
            'recordsTotal'    => $this->dtp->get_all_data(),
            'recordsFiltered' => $this->dtp->get_filtered_data(),
            'data'            => $data
        );
        echo json_encode($output);
    }

    function log_document_view($id)
    {
        // $file = $this->dokumentasi_model->get_log_document($id)->result();
        // $file = 
        if($this->input->is_ajax_request()){
            $this->load->view('dokumentasi/log_document',array('id'=>$id));
        }else{
            $this->template->main('dokumentasi/log_document',array('id'=>$id));
        }
    }

    public function fetch_data_log_document($id)
    {
        $this->dtl->get_log_document($id);
        $fetch_data = $this->dtl->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->username;
            $sub_array[] = $row->created_at;
            $sub_array[] = $row->activity;
            $data[] = $sub_array;
        }

        $output = array(
            'draw'            => intval($_POST['draw']),
            'recordsTotal'    => $this->dtl->get_all_data(),
            'recordsFiltered' => $this->dtl->get_filtered_data(),
            'data'            => $data
        );
        echo json_encode($output);
    }

    function excerpt($string, $panjang = 30)
    {
        if (strlen($string) >= 30) {
            return substr($string, 0, $panjang) . "...";
        } else {
            return $string;
        }
    }

    public function create()
    {
        if (count($_POST) > 0) {
            $data = array(
                'folder_name' => $this->input->post('folder_name'),
                'parent'      => 0,
                'id_user'     => $this->ion_auth->user()->row()->id
            );
            $this->dokumentasi_model->create($data);
            $this->session->set_flashdata('notice', 'Berhasil menambah Folder Baru');
            redirect('dokumentasi/index');
        } else {
            if($this->input->is_ajax_request()){
                $this->load->view("dokumentasi/create_folder");
            }else{
                $this->template->main("dokumentasi/create_folder");
            }
        }
    }

    public function create_subfolder($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'folder_name' => $this->input->post('folder_name'),
                'parent'      => $id,
                'id_user'     => $this->ion_auth->user()->row()->id
            );
            $this->dokumentasi_model->create($data);
            $this->session->set_flashdata('notice', 'Berhasil menambah Folder Baru');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array('id' => $id);
            if($this->input->is_ajax_request()){
                $this->load->view("dokumentasi/create_subfolder", $data);
            }else{
                $this->template->main("dokumentasi/create_subfolder", $data);
            }
        }
    }

    public function edit($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'folder_name' => $this->input->post('folder_name'),
            );
            $this->dokumentasi_model->edit($id, $data);
            $this->dokumentasi_model->flush_akses($id);
            foreach ($this->input->post('akses') as $d) {
                $this->dokumentasi_model->create_access_folder($this->input->post('id_folder'), $d);
            }
            foreach ($this->input->post('akses_download') as $a) {
                $this->dokumentasi_model->update_access_download($this->input->post('id_folder'), $a);
            }
            $this->session->set_flashdata('notice', 'Folder updated successfully.');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'dokumentasis' => $this->dokumentasi_model->get_edit($id)->row(),
                'users'        => $this->dokumentasi_model->get_user()->result()
            );

            if($this->input->is_ajax_request()){
                $this->load->view('dokumentasi/edit', $data);
            }else{
                $this->template->main('dokumentasi/edit', $data);
            }
        }
    }

    public function edit_subfolder($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'folder_name' => $this->input->post('folder_name'),
            );
            $this->dokumentasi_model->edit($id, $data);
            $this->session->set_flashdata('notice', 'Folder updated successfully.');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'dokumentasis' => $this->dokumentasi_model->get_edit($id)->row()
            );

            if($this->input->is_ajax_request()){
                $this->load->view('dokumentasi/edit_subfolder', $data);
            }else{
                $this->template->main('dokumentasi/edit_subfolder', $data);
            }
        }
    }

    public function edit_document($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'doc_name' => $this->input->post('doc_name'),
            );
            $this->dokumentasi_model->edit_document($id, $data);
    
            $this->session->set_flashdata('notice', 'Documen updated successfully.');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'dokumentasi' => $this->dokumentasi_model->get_document($id)->row()
            );

            if($this->input->is_ajax_request()){
                $this->load->view('dokumentasi/edit_document', $data);
            }else{
                $this->template->main('dokumentasi/edit_document', $data);
            }
        }
    }

    public function delete($id)
    {
        if (count($_POST) > 0) {
            $this->dokumentasi_model->delete($id);
            $this->session->set_flashdata('notice', 'Folder deleted successfully.');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if($this->dokumentasi_model->get_folder($id)->row()==null){
                redirect("dokumentasi");
            }

            $data = array(
                'judul' => 'Folder ' . $this->dokumentasi_model->get_folder($id)->row()->folder_name,
                'uri'   => '/dokumentasi/delete/' . $id
            );

            if($this->input->is_ajax_request()){
                $this->load->view('modals/delete', $data);
            }else{
                $this->template->main('modals/delete', $data);
            }
        }
    }

    public function delete_document($id)
    {
        if (count($_POST) > 0) {
            $this->dokumentasi_model->delete_document($id);
            $this->session->set_flashdata('notice', 'Document deleted successfully.');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if($this->dokumentasi_model->get_document($id)->row()==null){
                redirect("dokumentasi");
            }

            $data = array(
                'judul' => 'Document ' . $this->dokumentasi_model->get_document($id)->row()->doc_name,
                'uri'   => '/dokumentasi/delete_document/' . $id
            );

            if($this->input->is_ajax_request()){
                $this->load->view('modals/delete', $data);
            }else{
                $this->template->main('modals/delete', $data);
            }
        }
    }

    public function download_document($id)
    {
        $file = $this->dokumentasi_model->get_document($id)->row();
        $this->log_model->add($_SERVER['REMOTE_ADDR'], 'DOWNLOAD DOCUMENT','SUCCESS',json_encode($file));
        $this->load->helper('file');
        $PATH = BASEPATH . '../storage/dokumen/';
        $file_name = $this->dokumentasi_model->get_document($id)->row();
            $path = $PATH . $file_name->id_doc . $file_name->extension;
            $this->load->helper('download');
            force_download($path, null);
            exit;
    }

    public function get_document($id)
    {
        $this->load->helper('file');
        $PATH = BASEPATH . '../storage/dokumen/';
        $file_name = $this->dokumentasi_model->get_document($id)->row();
        if ($file_name->extension == '.pdf') {
            $path = $PATH . $file_name->id_doc . $file_name->extension;
            header('Content-Length: ' . filesize($path));
            header("Content-type: application/pdf");
            readfile($path);
            exit;
        } else {
            echo file_get_contents($PATH . $file_name->id_doc . $file_name->extension);
        }
    }

    function document($id)
    {
        $file = $this->dokumentasi_model->get_document($id)->row();
        $data = array(
                'id'        => $id,
                'doc_name'  => $this->dokumentasi_model->get_document($id)->row()->doc_name
            );

        if($this->ion_auth->user()->row()->type!='admin'){
            $getAccFolder = $this->dokumentasi_model->access_subfolder($file->id_folder,$this->ion_auth->user()->row()->id)->row();
            $data['download']  = ($getAccFolder)?$getAccFolder->download_permission:0;
        }else{
            $data['download'] = 1;
        }
        $this->log_model->add($_SERVER['REMOTE_ADDR'], 'VIEW DOCUMENT','SUCCESS',json_encode($file));
        if ($file->extension == '.jpg' || $file->extension == '.jpeg' || $file->extension == '.png') {
            if($this->input->is_ajax_request()){
                $this->load->view('dokumentasi/view_pic', $data);
            }else{
                $this->template->main('dokumentasi/view_pic', $data);
            }
        } else {
            $this->get_document($id);
        }
    }

    

    public function upload($id)
    {
        if (count($_POST) > 0) {
            // $config['upload_path'] = BASEPATH . '/../storage/dokumen';
            // $config['allowed_types'] = 'jpeg|jpg|png|pdf';
            // $this->load->library('upload', $config);


            // save data local storage
            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());

                $this->load->view('upload_form', $error);
            } else {
                // ke db
                $data = array(
                    'doc_name'       => $this->input->post(''),
                    'id_folder'      => $this->input->post(''),
                    'upload_date'    => $this->input->post(''),
                    'id_user'        => $this->input->post(''),
                    'id_subkegiatan' => $this->input->post(''),
                );
                // $this->dokumentasi_model->create_dokumen($data);

                // $data = array('upload_data' => $this->upload->data());

                // $this->load->view('upload_success', $data);
            }

            // $this->session->set_flashdata('notice', 'Berhasil menambah Dokumen Baru');
            // redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = array(
                'id' => $id
            );
            $this->load->view("dokumentasi/upload", $data);
        }
    }

    public function do_upload($id)
    {
        $data = array();

        //Count total files
        $filesCount = count($_FILES['files']['name']);

        //Looping all files
        for ($i = 0; $i < $filesCount; $i++) {
            //Define new $_FILES array - $_FILES['file']
            $_FILES['file']['name'] = $_FILES['files']['name'][$i];
            $_FILES['file']['type'] = $_FILES['files']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
            $_FILES['file']['error'] = $_FILES['files']['error'][$i];
            $_FILES['file']['size'] = $_FILES['files']['size'][$i];

            //Set preference
            $config['upload_path'] = BASEPATH . '/../storage/dokumen';
            $config['allowed_types'] = '*';
            // $config['max_size'] = 5000; //in kb

            $uploadData[$i]['doc_name'] = $_FILES['file']['name'];
            $uploadData[$i]['id_folder'] = $id;
            $uploadData[$i]['id_user'] = $this->ion_auth->user()->row()->id;
            $config['file_name'] = $this->dokumentasi_model->uploadFiles($uploadData[$i]);

            //Load upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            //upload file
            $this->upload->do_upload('file');

            //update extension
            $upload_data = $this->upload->data();
            $this->dokumentasi_model->edit_document($config['file_name'], array('extension' => $upload_data['file_ext']));
        }

        if (!empty($uploadData)) {
            // Insert files data into the database
            $this->session->set_flashdata('notice', 'File uploaded successfully.');
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $this->session->set_flashdata('warning', $this->upload->display_errors());
        redirect($_SERVER["HTTP_REFERER"]);
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