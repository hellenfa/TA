<?php
/**
 * Class Recycle_bin
 * @property Recycle_bin $recycle_bin
 * @property Recycle_bin_model $recycle_bin_model
 */

class Recycle_bin extends MY_Controller{
	public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->load->model('recycle_bin/recycle_bin_model');
        $this->load->model('recycle_bin/dt_recycle_bin_model', 'dt');
        $this->load->helper(array('form_helper', 'modal_helper', 'bs_helper', 'url'));
    }

    public function index()
    {
        $data = array(
        	'title'			=> 'Recycle Bin',
            'recycle_bin' 	=> 'active',
        );

        $this->template->main('recycle_bin/index',$data);
    }

    public function fetch_data()
    {
        $fetch_data = $this->dt->make_datatables();
        // $this->dt->set_folder();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array		= array();
            if($row->extension == '.pdf') {
                $sub_array[] = ajax_text_modal('recycle_bin/document' . '/' . $row->id_doc, '<i class="fa fa-file-o"></i>&nbsp;' . $this->excerpt($row->doc_name) ,array(),'target="_blank"');
            } else {
                $sub_array[] = ajax_text_modal('recycle_bin/document' . '/' . $row->id_doc, '<i class="fa fa-file-o"></i>&nbsp;' . $this->excerpt($row->doc_name) ,array());
            }
            $sub_array[] = ajax_modal('recycle_bin/restore/' . $row->id_doc, 'Restore', array('info', 'refresh')) . ' ' . ajax_modal('recycle_bin/delete_recycle_bin/' . $row->id_doc, 'Delete', array(
                    'danger',
                    'trash'
                ));
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

    function excerpt($string, $panjang = 30)
    {
        if (strlen($string) >= 30) {
            return substr($string, 0, $panjang) . "...";
        } else {
            return $string;
        }
    }

    public function delete_recycle_bin($id)
    {
        if (count($_POST) > 0) {
        	$PATH = BASEPATH . '../storage/dokumen/';
        	$file_name = $this->recycle_bin_model->get_document($id)->row();
            $doc_file = $PATH . $file_name->id_doc . $file_name->extension;

			unlink($doc_file);
            $this->recycle_bin_model->delete_recycle_bin($id);

            $this->session->set_flashdata('notice', 'Berhasil menghapus dokumen');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if ($this->recycle_bin_model->get_document($id)->row() == null) {
                redirect("recycle_bin");
            }

            $data = array(
                'judul' => 'dokumen ' . $this->recycle_bin_model->get_document($id)->row()->doc_name,
                'uri'   => '/recycle_bin/delete_recycle_bin/' . $id
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('modals/delete', $data);
            } else {
                $this->template->main('modals/delete', $data);
            }
        }
    }

    function restore($id)
    {
    	if (count($_POST) > 0) {
            $data = array(
                'deleted_at' => null,
                'id_detail_subkegiatan' => null,
            );
            $this->recycle_bin_model->restore_document($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil memulihkan dokumen');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'restore_document' => $this->recycle_bin_model->get_document($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('recycle_bin/restore_document', $data);
            } else {
                $this->template->main('recycle_bin/restore_document', $data);
            }
        }
    }

    public function get_document($id)
    {
        $this->load->helper('file');
        $PATH = BASEPATH . '../storage/dokumen/';
        $file_name = $this->recycle_bin_model->get_document($id)->row();
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
        $file = $this->recycle_bin_model->get_document($id)->row();
        $data = array(
                'id'        => $id,
                'doc_name'  => $this->recycle_bin_model->get_document($id)->row()->doc_name
            );
        
        if ($file->extension == '.jpg' || $file->extension == '.jpeg' || $file->extension == '.png') {
            if($this->input->is_ajax_request()){
                $this->load->view('recycle_bin/view_pic', $data);
            }else{
                $this->template->main('recycle_bin/view_pic', $data);
            }
        } else {
            $this->get_document($id);
        }
    }
}