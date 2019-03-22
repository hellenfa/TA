<?php

/**
 * Class progress_report
 * @property progress_report $progress_report
 * @property progress_report_model $progress_report_model
 * @property DT_progress_report_Model $dt
 */
class Progress_Report extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->load->model('progress_report/progress_report_model');
        $this->load->model('progress_report/dt_sumber_dana_model', 'dt');
        $this->load->model('progress_report/dt_kegiatan_model', 'dts');
        $this->load->model('progress_report/dt_subkegiatan_model', 'dtsk');
        $this->load->model('progress_report/dt_detail_subkegiatan_model', 'dtd');
        $this->load->model('progress_report/dt_jenis_lelang_model', 'dtj');
        $this->load->model('progress_report/dt_tahap_lelang_model', 'dtt');
        $this->load->helper(array('form_helper', 'modal_helper', 'bs_helper', 'url'));
        $this->load->library('upload');
        $this->load->library('pdf');
    }

    public function index()
    {
        $data['title'] = 'Progress Report';
        $data['progress_report'] = 'active';
        $data['sumber_dana'] = $this->progress_report_model->sumber_dana()->result();

        $this->template->main('progress_report/index', $data);
    }

    public function fetch_data()
    {
        $fetch_data = $this->dt->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '<a href="' . base_url('progress_report/sumber_dana') . '/' . $row->id_dana . '">' . $this->excerpt($row->dana_name) . '</a>';
            $sub_array[] = ajax_modal('progress_report/edit_sumber_dana/' . $row->id_dana, 'Edit', array('warning', 'pencil')) . ' ' . ajax_modal('progress_report/delete_sumber_dana/' . $row->id_dana, 'Hapus', array(
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

    //menampilkan daftar kegiatan
    public function sumber_dana($id)
    {
        $this->load->model('progress_report/dt_kegiatan_model', 'dts');
        $data = array(
            'title'           => 'Progress Report',
            'progress_report' => 'active',
            'data'            => $this->progress_report_model->get_kegiatan($id)->result(),
            'id'              => $id,
            'bc_sumber_dana'     => $this->progress_report_model->get_bc_sumber_dana($id),
        );
        $this->template->main('progress_report/sumber_dana', $data);
    }

    public function fetch_data_kegiatan($id_dana)
    {
        $this->load->model('progress_report/dt_kegiatan_model', 'dts');
        $this->dts->set_dana($id_dana);
        $fetch_data = $this->dts->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '<a href="' . base_url('progress_report/kegiatan') . '/' . $row->id_kegiatan . '">' . $this->excerpt($row->kegiatan_name) . '</a>';
            $sub_array[] = $row->create_date;
            $sub_array[] = ajax_modal('progress_report/edit_kegiatan/' . $row->id_kegiatan, 'Edit', array('warning', 'pencil')) . ' ' . ajax_modal('progress_report/delete_kegiatan/' . $row->id_kegiatan, 'Delete', array(
                    'danger',
                    'trash'
                ));
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

    //menampilkan daftar subkegiatan
    public function kegiatan($id)
    {
        $this->load->model('progress_report/dt_subkegiatan_model', 'dtsk');
        $kegiatan = $this->progress_report_model->get_kegiatan($id);
        $data = array(
            'title'           => 'Progress Report',
            'progress_report' => 'active',
            'data'            => $this->progress_report_model->get_subkegiatan($id)->result(),
            'id'              => $id,
            'bc_sumber_dana'  => $this->progress_report_model->get_bc_sumber_dana($kegiatan->row()->sumber_dana),
            'bc_kegiatan'     => $this->progress_report_model->get_bc_kegiatan($id),
        );
        $this->template->main('progress_report/kegiatan', $data);
    }

    public function fetch_data_subkegiatan($id_kegiatan)
    {
        $this->load->model('progress_report/dt_kegiatan_model', 'dtsk');
        $this->dtsk->set_kegiatan($id_kegiatan);
        $fetch_data = $this->dtsk->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '<a href="' . base_url('progress_report/subkegiatan') . '/' . $row->id_subkegiatan . '">' . $this->excerpt($row->subkegiatan_name) . '</a>';
            $sub_array[] = $row->create_date;
            // $sub_array[] = $row->status;
            $sub_array[] = ajax_modal('progress_report/edit_subkegiatan/' . $row->id_subkegiatan, 'Edit', array('warning', 'pencil')) . ' ' . ajax_modal('progress_report/delete_subkegiatan/' . $row->id_subkegiatan, 'Hapus', array(
                    'danger',
                    'trash'
                ));
            $data[] = $sub_array;
        }

        $output = array(
            'draw'            => intval($_POST['draw']),
            'recordsTotal'    => $this->dtsk->get_all_data(),
            'recordsFiltered' => $this->dtsk->get_filtered_data(),
            'data'            => $data
        );
        echo json_encode($output);
    }

    public function subkegiatan($id)
    {
        $this->load->model('progress_report/dt_detail_subkegiatan_model', 'dtd');
        $get_sumber_dana = $this->progress_report_model->get_sumber($id);
        $subkegiatan     = $this->progress_report_model->get_subkegiatan($id);
        $kegiatan        = $this->progress_report_model->get_kegiatan($subkegiatan->row()->id_kegiatan);
        $data = array(
            'title'           => 'Progress Report',
            'progress_report' => 'active',
            'data'            => $this->progress_report_model->get_detail_subkegiatan($id)->result(),
            'id'              => $id,
            'bc_sumber_dana'  => $this->progress_report_model->get_bc_sumber_dana($kegiatan->row()->sumber_dana),
            'bc_kegiatan'     => $this->progress_report_model->get_bc_kegiatan($subkegiatan->row()->id_kegiatan),
            'bc_subkegiatan'  => $this->progress_report_model->get_bc_subkegiatan($id),
        );
        $this->template->main('progress_report/subkegiatan', $data);
    }

    public function fetch_data_detail_subkegiatan($id_subkegiatan)
    {
        $this->load->model('progress_report/dt_detail_subkegiatan_model', 'dtd');
        $this->dtd->set_subkegiatan($id_subkegiatan);
        $this->dtd->set_dokumen();
        $fetch_data = $this->dtd->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array   = array();
            $sub_array[] = $this->excerpt($row->detail_subkegiatan_name);
            $sub_array[] = date('d-m-Y', strtotime($row->plan_start));
            $sub_array[] = date('d-m-Y', strtotime($row->plan_finish));
            if($row->actual_start != null){
                $sub_array[] = date('d-m-Y', strtotime($row->actual_start));
            }
            else{
                // if($this->ion_auth->user()->row()->type!='admin'){
                    $sub_array[] = ajax_modal('progress_report/start_detail_subkegiatan/' . $row->id_detail_subkegiatan, 'Start', array('info', 'start'));
                // } else {
                //     $sub_array[] = null;    
                // }
            }
            if($row->actual_finish != null){
                $sub_array[] = date('d-m-Y', strtotime($row->actual_finish));
            }
            else{
                if($row->doc_name != null){
                    if($this->ion_auth->user()->row()->type!='admin'){
                        $sub_array[] = '<center>' . ajax_modal('progress_report/request_finish/' . $row->id_detail_subkegiatan, '', array('warning', 'exclamation')) . '</center>';
                    } else {
                        $sub_array[] = null;
                    }
                } else {
                    $sub_array[] = null;
                }
            }
            if ($row->doc_name != null) {
                $sub_array[] = ajax_text_modal('progress_report/document' . '/' . $row->id_doc, '<i class="fa fa-file-o"></i>&nbsp;' . $this->excerpt($row->doc_name),array(),'target="_blank"');
                if($this->ion_auth->user()->row()->type!='admin'){
                    $sub_array[] = ajax_modal('progress_report/upload/' . $row->id_detail_subkegiatan, '', array('success', 'upload'));
                } else {
                    $sub_array[] = ajax_modal('progress_report/upload/' . $row->id_detail_subkegiatan, '', array('success', 'upload')) . ' ' . '<a href="' . base_url('progress_report/get_document') . '/' . $row->id_doc . '">' . '<i class="fa fa-download"></i>' . '</a>';
                }
            } else {
                if($row->status=='Berjalan'){
                    $sub_array[] = ajax_modal('progress_report/upload/' . $row->id_detail_subkegiatan, '', array('success', 'upload'));
                    $sub_array[] = null;
                } else {
                    $sub_array[] = null;
                    $sub_array[] = null;
                }
            }
            if ($row->status != 'Selesai' && $row->doc_name != null && $this->ion_auth->user()->row()->type=='admin') {
                $sub_array[] = ajax_modal('progress_report/finish_detail_subkegiatan/' . $row->id_detail_subkegiatan, '', array('info', 'check')) . '  ' . ajax_modal('progress_report/revisi_detail_subkegiatan/' . $row->id_detail_subkegiatan, '', array('warning', 'pencil'));
            } else {
                if ($this->ion_auth->user()->row()->type=='admin') {
                    $sub_array[] = null;
                }
            }
            $sub_array[] = $row->status;
            if ($this->ion_auth->user()->row()->type=='admin') {
                if($row->status != 'Selesai') {
                    if($row->notes != null){
                        $sub_array[] = ajax_modal('progress_report/view_notes/' . $row->id_detail_subkegiatan, '', array('info', 'search'));
                    } else {
                        $sub_array[] = null;
                    }
                    $sub_array[] = ajax_modal('progress_report/edit_detail_subkegiatan/' . $row->id_detail_subkegiatan, 'Edit', array('warning', 'pencil'));
                    
                } else {
                    $sub_array[] = null;
                    $sub_array[] = ajax_modal('progress_report/redo_detail_subkegiatan/' . $row->id_detail_subkegiatan, '', array('success', 'refresh'));
                }
            } else {
                if($row->notes != null){
                        $sub_array[] = ajax_modal('progress_report/view_notes/' . $row->id_detail_subkegiatan, '', array('info', 'search'));
                    } else {
                        $sub_array[] = null;
                    }
            }
            $data[] = $sub_array;
        }

        $output = array(
            'draw'            => intval($_POST['draw']),
            'recordsTotal'    => $this->dtd->get_all_data(),
            'recordsFiltered' => $this->dtd->get_filtered_data(),
            'data'            => $data
        );
        echo json_encode($output);
    }

    public function jenis_lelang()
    {
        $this->load->model('progress_report/dt_jenis_lelang_model', 'dtj');
        $data = array(
            'title'           => 'Progress Report',
            'jenis_lelang'    => 'active',
            'data'            => $this->progress_report_model->jenis_lelang()->result()
        );
        $this->template->main('progress_report/jenis_lelang', $data);
    }

    public function fetch_data_jenis_lelang()
    {
        $this->load->model('progress_report/dt_jenis_lelang_model', 'dtj');
        $fetch_data = $this->dtj->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = '<a href="' . base_url('progress_report/tahap_lelang') . '/' . $row->id_jenis_lelang . '">' . $row->jenis_lelang_name . '</a>';
            $sub_array[] = ajax_modal('progress_report/edit_jenis_lelang/' . $row->id_jenis_lelang, 'Edit', array('warning', 'pencil')) . ' ' . ajax_modal('progress_report/delete_jenis_lelang/' . $row->id_jenis_lelang, 'Hapus', array(
                    'danger',
                    'trash'
                ));
            $data[] = $sub_array;
        }

        $output = array(
            'draw'            => intval($_POST['draw']),
            'recordsTotal'    => $this->dtj->get_all_data(),
            'recordsFiltered' => $this->dtj->get_filtered_data(),
            'data'            => $data
        );
        echo json_encode($output);
    }

    public function tahap_lelang($id)
    {
        $this->load->model('progress_report/dt_tahap_lelang_model', 'dtt');
        $data = array(
            'title'           => 'Progress Report',
            'jenis_lelang'    => 'active',
            'data'            => $this->progress_report_model->get_tahap_lelang($id)->result(),
            'id'              => $id
        );
        $this->template->main('progress_report/tahap_lelang', $data);
    }

    public function fetch_data_tahap_lelang($id_jenis_lelang)
    {
        $this->load->model('progress_report/dt_tahap_lelang_model', 'dtt');
        $this->dtt->set_jenis_lelang($id_jenis_lelang);
        $fetch_data = $this->dtt->make_datatables();
        $data = array();

        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->tahap_lelang_name;
            $sub_array[] = ajax_modal('progress_report/edit_tahap_lelang/' . $row->id_tahap_lelang, 'Edit', array('warning', 'pencil')) . ' ' . ajax_modal('progress_report/delete_tahap_lelang/' . $row->id_tahap_lelang, 'Hapus', array(
                    'danger',
                    'trash'
                ));
            $data[] = $sub_array;
        }

        $output = array(
            'draw'            => intval($_POST['draw']),
            'recordsTotal'    => $this->dtt->get_all_data(),
            'recordsFiltered' => $this->dtt->get_filtered_data(),
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

    public function create_sumber_dana()
    {
        if (count($_POST) > 0) {
            $data = array(
                'dana_name' => $this->input->post('nama_sumber_dana'),
            );
            $this->progress_report_model->create_sumber_dana($data);
            $this->session->set_flashdata('notice', 'Berhasil menambah Sumber Dana Baru');
            redirect('progress_report/index');
        } else {
            if ($this->input->is_ajax_request()) {
                $this->load->view("progress_report/create_sumber_dana");
            } else {
                $this->template->main("progress_report/create_sumber_dana");
            }
        }
    }

    public function create_kegiatan($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'kegiatan_name' => $this->input->post('activity_name'),
                'sumber_dana'   => $id,
                'id_user'       => $this->ion_auth->user()->row()->id,
            );
            $this->progress_report_model->create_kegiatan($data);
            $this->session->set_flashdata('notice', 'Activity added successfully.');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array('id' => $id);
            if ($this->input->is_ajax_request()) {
                $this->load->view("progress_report/create_kegiatan", $data);
            } else {
                $this->template->main("progress_report/create_kegiatan", $data);
            }
        }
    }

    public function create_subkegiatan($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'subkegiatan_name' => $this->input->post('subactivity_name'),
                'id_kegiatan'      => $id,
                'id_user'          => $this->ion_auth->user()->row()->id
            );
            $id_subkegiatan = $this->progress_report_model->create_subkegiatan($data);
            $this->create_detail_subkegiatan($id_subkegiatan);
            $this->session->set_flashdata('notice', 'Berhasil menambah subkegiatan baru');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'id'           => $id,
                'jenis_lelang' => $this->progress_report_model->get_all_jenis_lelang()->result(),
                'users'        => $this->progress_report_model->get_user()->result()
            );
            if ($this->input->is_ajax_request()) {
                $this->load->view("progress_report/create_subkegiatan", $data);
            } else {
                $this->template->main("progress_report/create_subkegiatan", $data);
            }
        }
    }

    public function create_detail_subkegiatan($id)
    {
        foreach($this->input->post('id_jenis_lelang') as $key => $value){   
            $data = array(
                'detail_subkegiatan_name' => $this->input->post('nama_sub_kegiatan')[$key],
                'plan_start'              => $this->input->post('plan_start')[$key],
                'plan_finish'             => $this->input->post('plan_finish')[$key],
                'id_subkegiatan'          => $id,
                'id_jenis_lelang'         => $value,
                'id_user'                 => $this->ion_auth->user()->row()->id,
            );
            $this->progress_report_model->create_detail_subkegiatan($data);
        }
    }

    public function create_detail_subkegiatan_manually($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'detail_subkegiatan_name' => $this->input->post('detail_subactivity_name'),
                'plan_start'              => $this->input->post('plan_start'),
                'plan_finish'             => $this->input->post('plan_finish'),
                'id_subkegiatan'          => $id,
                'id_user'                 => $this->ion_auth->user()->row()->id,
                // 'id_verificator'          => $this->input->post('verificator'),
                // 'id_staff'                =>  $this->input->post('staff'),
            );
            $id_subkegiatan = $this->progress_report_model->create_detail_subkegiatan($data);
            $this->session->set_flashdata('notice', 'Berhasil menambah detail subkegiatan baru');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array('id' => $id);
            if ($this->input->is_ajax_request()) {
                $this->load->view("progress_report/create_detail_subkegiatan", $data);
            } else {
                $this->template->main("progress_report/create_detail_subkegiatan", $data);
            }
        }
    }

    function get_string_detail_subkegiatan(){
        $id   = $this->input->get('id');
        $data = array(
                'detailsub' => $this->progress_report_model->get_string_detail_subkegiatan($id),
                'users'     => $this->progress_report_model->get_user()->result()
            );
        // $data = $this->progress_report_model->get_string_detail_subkegiatan($id);
        echo json_encode($data);
    }

    public function create_jenis_lelang()
    {
        if (count($_POST) > 0) {
            $data = array(
                'jenis_lelang_name' => $this->input->post('nama_jenis_lelang')
            );
            $this->progress_report_model->create_jenis_lelang($data);
            $this->session->set_flashdata('notice', 'Berhasil menambah jenis lelang baru');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if ($this->input->is_ajax_request()) {
                $this->load->view("progress_report/create_jenis_lelang");
            } else {
                $this->template->main("progress_report/create_jenis_lelang");
            }
        }
    }

    public function create_tahap_lelang($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'tahap_lelang_name' => $this->input->post('auction_step_name'),
                'id_jenis_lelang'   => $id
            );
            $this->progress_report_model->create_tahap_lelang($data);
            $this->session->set_flashdata('notice', 'Auction step added successfully.');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array('id' => $id);
            if ($this->input->is_ajax_request()) {
                $this->load->view("progress_report/create_tahap_lelang", $data);
            } else {
                $this->template->main("progress_report/create_tahap_lelang", $data);
            }
        }
    }

    public function edit_sumber_dana($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'dana_name' => $this->input->post('dana_name'),
            );
            $this->progress_report_model->edit_sumber_dana($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil mengubah Sumber Dana');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'sumberdana' => $this->progress_report_model->get_sumber_dana($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/edit_sumber_dana', $data);
            } else {
                $this->template->main('progress_report/edit_sumber_dana', $data);
            }
        }
    }

    public function edit_kegiatan($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'kegiatan_name' => $this->input->post('kegiatan_name'),
            );
            $this->progress_report_model->edit_kegiatan($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil mengubah Kegiatan');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'kegiatans' => $this->progress_report_model->get_kegiatan($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/edit_kegiatan', $data);
            } else {
                $this->template->main('progress_report/edit_kegiatan', $data);
            }
        }
    }

    public function edit_subkegiatan($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'subkegiatan_name' => $this->input->post('subkegiatan_name'),
            );
            $this->progress_report_model->edit_subkegiatan($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil mengubah Subkegiatan');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'subkegiatan' => $this->progress_report_model->get_subkegiatan($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/edit_subkegiatan', $data);
            } else {
                $this->template->main('progress_report/edit_subkegiatan', $data);
            }
        }
    }

    public function edit_detail_subkegiatan($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'plan_start'  => $this->input->post('plan_start'),
                'plan_finish' => $this->input->post('plan_finish'),
            );
            $this->progress_report_model->edit_detail_subkegiatan($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil mengubah detail subkegiatan');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'detailsubkegiatan' => $this->progress_report_model->get_detail_subkegiatan($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/edit_detail_subkegiatan', $data);
            } else {
                $this->template->main('progress_report/edit_detail_subkegiatan', $data);
            }
        }
    }

    public function edit_jenis_lelang($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'jenis_lelang_name' => $this->input->post('jenis_lelang_name'),
            );
            $this->progress_report_model->edit_jenis_lelang($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil mengubah jenis lelang');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'jenislelang' => $this->progress_report_model->get_jenis_lelang($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/edit_jenis_lelang', $data);
            } else {
                $this->template->main('progress_report/edit_jenis_lelang', $data);
            }
        }
    }

    public function edit_tahap_lelang($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'tahap_lelang_name' => $this->input->post('tahap_lelang_name'),
            );
            $this->progress_report_model->edit_tahap_lelang($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil mengubah tahap lelang');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'tahaplelang' => $this->progress_report_model->get_tahap_lelang($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/edit_tahap_lelang', $data);
            } else {
                $this->template->main('progress_report/edit_tahap_lelang', $data);
            }
        }
    }

    public function delete_sumber_dana($id)
    {
        if (count($_POST) > 0) {
            $this->progress_report_model->delete_sumber_dana($id);
            $this->session->set_flashdata('notice', 'Berhasil Menghapus Sumber Dana');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if ($this->progress_report_model->get_sumber_dana($id)->row() == null) {
                redirect("progress_report");
            }

            $data = array(
                'judul' => 'sumber dana ' . $this->progress_report_model->get_sumber_dana($id)->row()->dana_name,
                'uri'   => '/progress_report/delete_sumber_dana/' . $id
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('modals/delete', $data);
            } else {
                $this->template->main('modals/delete', $data);
            }
        }
    }

    public function delete_kegiatan($id)
    {
        if (count($_POST) > 0) {
            $this->progress_report_model->delete_kegiatan($id);
            $this->session->set_flashdata('notice', 'Berhasil Menghapus Kegiatan');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if ($this->progress_report_model->get_kegiatan($id)->row() == null) {
                redirect("progress_report");
            }

            $data = array(
                'judul' => 'Kegiatan ' . $this->progress_report_model->get_kegiatan($id)->row()->kegiatan_name,
                'uri'   => '/progress_report/delete_kegiatan/' . $id
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('modals/delete', $data);
            } else {
                $this->template->main('modals/delete', $data);
            }
        }
    }

    public function delete_subkegiatan($id)
    {
        if (count($_POST) > 0) {
            $this->progress_report_model->delete_subkegiatan($id);
            $this->session->set_flashdata('notice', 'Berhasil Menghapus Subkegiatan');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if ($this->progress_report_model->get_subkegiatan($id)->row() == null) {
                redirect("progress_report");
            }

            $data = array(
                'judul' => 'Subkegiatan ' . $this->progress_report_model->get_subkegiatan($id)->row()->subkegiatan_name,
                'uri'   => '/progress_report/delete_subkegiatan/' . $id
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('modals/delete', $data);
            } else {
                $this->template->main('modals/delete', $data);
            }
        }
    }

    public function delete_jenis_lelang($id)
    {
        if (count($_POST) > 0) {
            $this->progress_report_model->delete_jenis_lelang($id);
            $this->session->set_flashdata('notice', 'Berhasil menghapus jenis lelang');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if ($this->progress_report_model->get_jenis_lelang($id)->row() == null) {
                redirect("progress_report");
            }

            $data = array(
                'judul' => 'jenis lelang ' . $this->progress_report_model->get_jenis_lelang($id)->row()->jenis_lelang_name,
                'uri'   => '/progress_report/delete_jenis_lelang/' . $id
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('modals/delete', $data);
            } else {
                $this->template->main('modals/delete', $data);
            }
        }
    }

    public function delete_tahap_lelang($id)
    {
        if (count($_POST) > 0) {
            $this->progress_report_model->delete_tahap_lelang($id);
            $this->session->set_flashdata('notice', 'Berhasil menghapus tahap lelang');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            if ($this->progress_report_model->get_tahap_lelang($id)->row() == null) {
                redirect("progress_report");
            }

            $data = array(
                'judul' => 'tahap lelang ' . $this->progress_report_model->get_tahap_lelang($id)->row()->jenis_lelang_name,
                'uri'   => '/progress_report/delete_tahap_lelang/' . $id
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('modals/delete', $data);
            } else {
                $this->template->main('modals/delete', $data);
            }
        }
    }

    public function get_document($id)
    {
        $this->load->helper('file');
        $PATH = BASEPATH . '../storage/dokumen/';
        $file_name = $this->progress_report_model->get_document($id)->row();
            $path = $PATH . $file_name->id_doc . $file_name->extension;
            $this->load->helper('download');
            force_download($path, null);
            exit;
    }

    public function get_view_document($id)
    {
        $this->load->helper('file');
        $PATH = BASEPATH . '../storage/dokumen/';
        $file_name = $this->progress_report_model->get_document($id)->row();
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

    public function document($id)
    {
        $file = $this->progress_report_model->get_document($id)->row();
        $data = array(
            'id'       => $id,
            'doc_name' => $this->progress_report_model->get_document($id)->row()->doc_name,
        );
            $this->get_view_document($id);
    }

    public function upload($id)
    {
        if (count($_POST) > 0) {
            // save data local storage
            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());

                $this->load->view('upload_form', $error);
            } else {
                // ke db
                $data = array(
                    'doc_name'       => $this->input->post(''),
                    // 'id_folder'      => $this->input->post(''),
                    'upload_date'    => $this->input->post(''),
                    'id_user'        => $this->input->post(''),
                    'id_detail_subkegiatan' => $this->input->post(''),
                );
                // $this->progress_report_model->create_dokumen($data);

                // $data = array('upload_data' => $this->upload->data());

                // $this->load->view('upload_success', $data);
            }
        } else {
            $data = array(
                'id' => $id
            );
            $this->load->view("progress_report/upload", $data);
        }
    }

    public function do_upload($id)
    {
        $data = array();
            $_FILES['file']['name'] = $_FILES['files']['name'];
            $_FILES['file']['type'] = $_FILES['files']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'];
            $_FILES['file']['error'] = $_FILES['files']['error'];
            $_FILES['file']['size'] = $_FILES['files']['size'];

            //Set preference
            $config['upload_path'] = BASEPATH . '/../storage/dokumen';
            $config['allowed_types'] = 'pdf';

            if($this->progress_report_model->is_exist_file($id)){
                $this->progress_report_model->delete_file($id);
            }

            $uploadData['doc_name'] = $_FILES['file']['name'];
            $uploadData['id_detail_subkegiatan'] = $id;
            $uploadData['id_user'] = $this->ion_auth->user()->row()->id;
            $config['file_name'] = $this->progress_report_model->uploadFiles($uploadData);

            //Load upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            //upload file
            $this->upload->do_upload('file');

            //update extension
            $upload_data = $this->upload->data();
            $this->progress_report_model->edit_document($config['file_name'], array('extension' => $upload_data['file_ext']));

        if (!empty($uploadData)) {
            // Insert files data into the database
            $this->session->set_flashdata('notice', 'Berhasil mengunggah dokumen');
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $this->session->set_flashdata('warning', $this->upload->display_errors());
        redirect($_SERVER["HTTP_REFERER"]);
    }

    public function start_detail_subkegiatan($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'actual_start' => date("Y-m-d"),
                'status'       => 'Berjalan',
            );
            $this->progress_report_model->edit_detail_subkegiatan($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil memulai detail subkegiatan');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'start_detail_subkegiatan' => $this->progress_report_model->get_detail_subkegiatan($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/start_detail_subkegiatan', $data);
            } else {
                $this->template->main('progress_report/start_detail_subkegiatan', $data);
            }
        }
    }

    public function request_finish($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'status'        => 'Request Selesai',
            );
            $this->progress_report_model->edit_detail_subkegiatan($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil mengirimkan permintaan selesai');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'request_finish_detail_subkegiatan' => $this->progress_report_model->get_detail_subkegiatan($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/request_finish_detail_subkegiatan', $data);
            } else {
                $this->template->main('progress_report/request_finish_detail_subkegiatan', $data);
            }
        }
    }

    public function finish_detail_subkegiatan($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'actual_finish' => date("Y-m-d"),
                'status'        => 'Selesai',
                'notes'         => null,
                // 'id_verifivator'=> $this->ion_auth->user()->row()->id,
            );
            $this->progress_report_model->edit_detail_subkegiatan($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil menyelesaikan detail subkegiatan');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'finish_detail_subkegiatan' => $this->progress_report_model->get_detail_subkegiatan($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/finish_detail_subkegiatan', $data);
            } else {
                $this->template->main('progress_report/finish_detail_subkegiatan', $data);
            }
        }
    }

    public function revisi_detail_subkegiatan($id)
    {
        if (count($_POST) > 0) {
            $data = array(
                'status' => 'Revisi',
                'notes'  => $this->input->post('notes'),
            );
            $this->progress_report_model->edit_detail_subkegiatan($id, $data);

            $this->session->set_flashdata('notice', 'Berhasil merevisi detail subkegiatan');
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $data = array(
                'revisi_detail_subkegiatan' => $this->progress_report_model->get_detail_subkegiatan($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/revisi_detail_subkegiatan', $data);
            } else {
                $this->template->main('progress_report/revisi_detail_subkegiatan', $data);
            }
        }
    }

    public function view_notes($id)
    {
            $data = array(
                'view_notes' => $this->progress_report_model->get_detail_subkegiatan($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/view_notes', $data);
            } else {
                $this->template->main('progress_report/view_notes', $data);
            }
    }

    public function redo_detail_subkegiatan($id)
    {
            $data = array(
                'redo_detail_subkegiatan' => $this->progress_report_model->get_redo_detail_subkegiatan($id)->row()
            );

            if ($this->input->is_ajax_request()) {
                $this->load->view('progress_report/redo_detail_subkegiatan', $data);
            } else {
                $this->template->main('progress_report/redo_detail_subkegiatan', $data);
            }
    }

    public function redo2_detail_subkegiatan()
    {
        
            $data = array(
                'detail_subkegiatan_name' => $this->input->post('detail_subkegiatan_name'),
                'id_jenis_lelang'         => $this->input->post('id_jenis_lelang'),
                'id_subkegiatan'          => $this->input->post('id_subkegiatan'),
                'plan_start'              => $this->input->post('plan_start'),
                'plan_finish'             => $this->input->post('plan_finish'),
                'id_user'                 => $this->ion_auth->user()->row()->id,
            );
            $this->progress_report_model->create_detail_subkegiatan($data);

            $this->session->set_flashdata('notice', 'Berhasil merevisi detail subkegiatan');
            redirect($_SERVER["HTTP_REFERER"]);
    }
}
