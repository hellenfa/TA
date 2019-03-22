<?php

/**
 * Class Logbook
 * @property Logbook $logbook
 * @property Logbook_model $logbook_model
 * @property DT_Logbook_Model $dt
 */
class Logbook extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }

        $this->load->model('logbook/logbook_model');
        $this->load->model('logbook/dt_Logbook_Model', 'dt');
        $this->load->model('logbook/dt_bagikan_dengan_saya_model', 'dts');
        $this->load->model('logbook/dt_bagikan_dengan_yang_lain_model', 'dtl');
        $this->load->helper(array('form_helper', 'url', 'modal_helper', 'bs_helper', 'url', 'pixel_admin_helper'));
        $this->load->model('auth/ion_auth_model', 'ion_auth_model');
        $this->load->library('upload');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['title'] = 'Logbook';
        $data['logbook'] = 'active';
        $data['logbooks'] = $this->logbook_model->logbook()->result();

        $this->template->main('logbook/index', $data);
    }

    public function fetch_data()
    {
        $this->dt->setConfig();
        $fetch_data = $this->dt->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
             $sub_array[] = "<a target='ajax-modal' href='" . base_url() .'logbook/edit/'.$row->id_logbook . '' . " btn-xs'>" . $row->logbook_name . "</a>";
            $sub_array[] = ajax_modal('logbook/share/' . $row->id_logbook, '', array('info', 'share-alt
                ')) . ' ';
            $sub_array[]=$row->logbook_name;
            $sub_array[] = date('d-m-Y h:i a',strtotime($row->updated_date));
            $sub_array[] = button('logbook/cetakpdf/' . $row->id_logbook,'').' ' . ajax_modal('logbook/delete/' . $row->id_logbook, '', array(
                    'danger', 'trash'));

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
            // insert keterangan logbook
            $data = array(
                'logbook_name' => $this->input->post('nama_logbook'),
                'updated_date' => $this->input->post('tanggal_logbook'),
                'description'  => $this->input->post('deskripsi'),
                'id_user'      => $this->ion_auth->user()->row()->id
            );
            $id = $this->logbook_model->create($data);
            $data = array();
            //Count total files
            $filesCount = count($_FILES['files']['name']);
            // die(var_dump($_FILES['files']['name']));
            //Looping all files
            for ($i = 0; $i < $filesCount; $i++) {
                //Define new $_FILES array - $_FILES['file']
                if ($_FILES['files']['name'][$i] == '') {
                    break;
                }
                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                //Set preference
                $config['upload_path'] = BASEPATH . '/../storage/lampiran';
                $config['allowed_types'] = 'jpeg|jpg|png|pdf';
                $config['max_size'] = 32000; //in kb

                $uploadData[$i]['attach_name'] = $_FILES['file']['name'];
                $uploadData[$i]['attach_size'] = $_FILES['file']['size'];
                $uploadData[$i]['id_logbook'] = $id;

                $config['file_name'] = $this->logbook_model->uploadFiles($uploadData[$i]);

                //Load upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                //upload file
                $this->upload->do_upload('file');


                //update extension
                $upload_data = $this->upload->data();
                $this->logbook_model->edit_attachment($config['file_name'], array('extension' => $upload_data['file_ext']));
            }

            if (!empty($uploadData)) {
                // Insert files data into the database
                $this->session->set_flashdata('notice', 'Berhasil menambahkan Berkas Lampiran');
                redirect($_SERVER["HTTP_REFERER"]);
            }
            $this->session->set_flashdata('warning', $this->upload->display_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        } //klik button tambah folder
        if ($this->input->is_ajax_request()) {
            $this->load->view('logbook/create');
        } else {
            $this->template->main('logbook/create');
        }
    }
    // function formatBytes($size, $precision = 2){
    //  $base = log($size) / log(1024);
    //  $suffixes = array('', ' KB', ' MB', ' GB', ' TB');
    // return round(pow(1024, $base – floor($base)), $precision) . $suffixes[floor($base)]; }


    public function delete($id)
    {
        if (count($_POST) > 0) {
            $this->logbook_model->delete($id);
            $this->session->set_flashdata('notice', 'Berhasil Menghapus Logbook');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if ($this->logbook_model->get_logbook($id)->row() == null) {
                redirect("logbook");
            }

            $data = array(
                'judul' => 'Logbook ' . $this->logbook_model->get_logbook($id)->row()->logbook_name,
                'uri'   => '/logbook/delete/' . $id
            );
            if ($this->input->is_ajax_request()) {
                $this->load->view('modals/delete', $data);
            } else {
                $this->template->main('modals/delete', $data);
            }
        }
    }

    public function delete_attachment($id)
    {
        if (count($_POST) > 0) {
            $this->logbook_model->delete_attachment($id);
            $this->session->set_flashdata('notice', 'Berhasil Menghapus Lampiran');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if ($this->logbook_model->get_attachment($id)->row() == null) {
                redirect("logbook");
            }

            $data = array(
                'judul' => 'Lampiran ' . $this->logbook_model->get_attachment($id)->row()->attach_name,
                'uri'   => '/logbook/delete_attachment/' . $id
            );
            if ($this->input->is_ajax_request()) {
                $this->load->view('modals/delete', $data);
            } else {
                $this->template->main('modals/delete', $data);
            }
        }
    }

    //  public function delete_attachment($id)
    // {
    //     $u = $this->uri->segment(3);
    //     $this->logbook_model->delete_attachment($u);
    //     redirect('logbook');
    // }
    public function download($id)
    {
        $this->load->helper('file');
        $PATH = BASEPATH . '../storage/lampiran/';
        $file_name = $this->logbook_model->download($id)->row();
        $path = $PATH . $file_name->id_attach . $file_name->extension;
        $this->load->helper('download');
        force_download($path, null);
        exit;
    }

    public function cetakpdf($id)
    {
        $this->load->library( 'pdf' );
        $this->pdf->folder( APPPATH . '/../storage/logbook/' );
        $this->pdf->filename( 'logbook_'.$id.'.pdf' );
        $this->pdf->paper( 'a4', 'portrait' );

        $data['lb'] = $this->logbook_model->get_logbook($id)->row();

        $this->pdf->html( $this->load->view( 'logbook/pdf_logbook', $data, true ) );

        $this->pdf->create();
    }

    public function edit($id)
    {

        if (count($_POST) > 0) {

            $data = array(
                'logbook_name' => $this->input->post('nama_logbook'),
                'description'  => $this->input->post('deskripsi')

            );
            $this->logbook_model->edit($id, $data);
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
                $config['upload_path'] = BASEPATH . '/../storage/lampiran';
                $config['allowed_types'] = 'jpeg|jpg|png|pdf';
                $config['max_size'] = 32000; //in kb

                $uploadData[$i]['attach_name'] = $_FILES['file']['name'];
                $uploadData[$i]['id_logbook'] = $id;

                $config['file_name'] = $this->logbook_model->uploadFiles($uploadData[$i]);

                //Load upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                //upload file
                $this->upload->do_upload('file');
                //update extension
                $upload_data = $this->upload->data();
                $this->logbook_model->edit_attachment($config['file_name'], array('extension' => $upload_data['file_ext']));
            }
            if (!empty($uploadData)) {
                // Insert files data into the database
                $this->session->set_flashdata('notice', 'Berhasil mengubah Logbook');
                redirect($_SERVER["HTTP_REFERER"]);
            }
            $this->session->set_flashdata('warning', $this->upload->display_errors());
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $data = array(
                'logbook'  => $this->logbook_model->get_edit($id)->row(),
                'lampiran' => $this->logbook_model->get_list_attachment($id)->result()

            );
            if ($this->input->is_ajax_request()) {
                $this->load->view('logbook/edit', $data);
            } else {
                $this->template->main('logbook/edit', $data);
            }
        }
    }

    public function share($id)
    {

        if (count($_POST) > 0) {
            $data = array(
                'logbook_name' => $this->input->post('logbook_name'),
            );
            $this->logbook_model->share($id, $data);
            $this->logbook_model->flush_akses($id);
            foreach ($this->input->post('bagikan') as $d) {
                $this->logbook_model->create_access_logbook($id, $d);
            }
            $this->session->set_flashdata('notice', 'Berhasil membagikan Logbook');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'logbooks' => $this->logbook_model->get_share($id)->row(),
                'users'    => $this->logbook_model->get_user()->result()
            );
            //die(var_dump($data['users']));
            if ($this->input->is_ajax_request()) {
                $this->load->view('logbook/share', $data);
            } else {
                $this->template->main('logbook/share', $data);
            }
        }
    }

    public function get_attachment($id)
    {
        $data = array(
            'id'        => $id,
            'doc_name'  => $this->logbook_model->get_attachment($id)->row()->attach_name
        );

        $this->load->helper('file');
        $PATH = BASEPATH . '../storage/lampiran/';
        $file = $this->logbook_model->get_attachment($id)->row();
        $data['download'] = 1;

        if ($file->extension == '.jpg' || $file->extension == '.jpeg' || $file->extension == '.png') {
            if($this->input->is_ajax_request()){
                $this->load->view('logbook/view_pic', $data);
            }else{
                $this->template->main('logbook/view_pic', $data);
            }
        } else {
            $this->get_document($id);
        }
    }

    public function get_document($id)
    {
        $this->load->helper('file');
        $PATH = BASEPATH . '../storage/lampiran/';
        $file_name = $this->logbook_model->get_attachment($id)->row();
        if ($file_name->extension == '.pdf') {
            $path = $PATH . $file_name->id_attach . $file_name->extension;
            header('Content-Length: ' . filesize($path));
            header("Content-type: application/pdf");
            readfile($path);
            exit;
        } else {
            echo file_get_contents($PATH . $file_name->id_attach . $file_name->extension);
        }
    }

    function attachment($id)
    {
        $file = $this->logbook_model->get_attachment($id)->row();
        $data = array(
            'id'          => $id,
            'attach_name' => $this->logbook_model->get_attachment($id)->row()->attach_name
        );

        if ($file->extension == '.jpg' || $file->extension == '.jpeg' || $file->extension == '.png') {
            if ($this->input->is_ajax_request()) {
                $this->load->view('logbook/view_pic', $data);
            } else {
                $this->template->main('logbook/view_pic', $data);
            }
        } else {
            $this->load->view("logbook/view_pdf", $data);
        }
    }

    public function bagikan_dengan_saya()
    {
        $this->load->model('logbook/dt_bagikan_dengan_saya_model', 'dts');
        $data = array(
            'title'               => 'Bagikan dengan Saya',
            'bagikan_dengan_saya' => 'active',
            'data'                => $this->logbook_model->bagikan_dengan_saya()->result()
        );
        $this->template->main('logbook/bagikan_dengan_saya', $data);

    }

    public function fetch_data_bagikan_dengan_saya()
    {
        $this->load->model('logbook/dt_bagikan_dengan_saya_model', 'dts');
        $this->dts->setConfig();
        $fetch_data = $this->dts->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = "<a target='ajax-modal' href='" . base_url() .'logbook/edit/'.$row->id_logbook . '' . " btn-xs'>" . $row->logbook_name . "</a>";
            $sub_array[] = ajax_modal('logbook/share/' . $row->id_logbook, '', array('info', 'share-alt
                ')) . ' ';
            $sub_array[] = $row->logbook_name;
            $sub_array[] = date('d-m-Y h:i a',strtotime($row->updated_date));
            $sub_array[] = button('logbook/cetakpdf/' . $row->id_logbook,'').' ' . ajax_modal('logbook/delete/' . $row->id_logbook, '', array(
                    'danger', 'trash'));

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

    public function bagikan_dengan_yang_lain()
    {
        $this->load->model('logbook/dt_bagikan_dengan_yang_lain_model', 'dtl');
        $data = array(
            'title'                    => 'Bagikan dengan yang Lain',
            'bagikan_dengan_yang_lain' => 'active',
            'data'                     => $this->logbook_model->bagikan_dengan_yang_lain()->result()
        );
        $this->template->main('logbook/bagikan_dengan_yang_lain', $data);

    }

    public function fetch_data_bagikan_dengan_yang_lain()
    {
        $this->load->model('logbook/dt_bagikan_dengan_yang_lain_model', 'dtl');
        $this->dtl->setConfig();
        $fetch_data = $this->dtl->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = "<a target='ajax-modal' href='" . base_url() .'logbook/edit/'.$row->id_logbook . '' . " btn-xs'>" . $row->logbook_name . "</a>";
            $sub_array[] = ajax_modal('logbook/share/' . $row->id_logbook, '', array('info', 'share-alt
                ')) . ' ';
            $sub_array[] = $row->logbook_name;
            $sub_array[] = date('d-m-Y h:i a',strtotime($row->updated_date));
            $sub_array[] = button('logbook/cetakpdf/' . $row->id_logbook,'').' ' . ajax_modal('logbook/delete/' . $row->id_logbook, '', array(
                    'danger', 'trash'));

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

    public function getuseraccess($idpermit, $iduser)
    {

        if ($this->logbook_model->access_logbook($idpermit, $iduser) == true) {
            return true;
        } else {
            return false;
        }


    }
}
