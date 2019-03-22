<?php

/**
 * Class Api
 * @property Api $api
 * @property Api_model $api_model
 */
class Api extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->load->model('api/api_model');
    }

    public function dosen()
    {
        if (!$this->input->is_ajax_request()) {
            show_error("ajax request required", "404");
        }

        if ($this->input->get('q') != null) {
            $data = $this->api_model->get_like_dosen($this->input->get('q'));
        } elseif ($this->input->get('nip') != null) {
            $data = $this->api_model->get_dosen($this->input->get('nip'));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function sync($nip = null, $ug_id = null)
    {
        if (empty($nip)) { /* if nip != null */

            $dosen = $this->api_model->get_all_dosen()->result();
            foreach ($dosen as $data) {
                try {
                    $json = @file_get_contents('http://pengabdianUGM:4gMPengaBdian2016@10.13.247.146/rest/sdm/dosen_kkn/param/' . $data->nip);
                    if ($json === false) {
                        throw new Exception("not found", 404);
                    }
                    $dat = json_decode($json);
                    $u_id = explode("@", $dat[0]->EMAIL1);
                    $arr = array(
                        'nama'               => $dat[0]->NAMA,
                        'nama_publikasi'     => $dat[0]->NAMA_PUBLIKASI,
                        'nidn'               => $dat[0]->NIDN,
                        'no_hp'              => $dat[0]->NO_HP,
                        'unit_kerja'         => $dat[0]->UNITKERJA,
                        'nama_bank'          => $dat[0]->NAMA_BANK,
                        'bank_cabang'        => $dat[0]->BANK_CABANG,
                        'no_rekening'        => $dat[0]->NO_REKENING,
                        'atas_nama_rekening' => $dat[0]->ATAS_NAMA_REKENING,
                        'tipe_rekening'      => $dat[0]->TIPE_REKENING,
                        'golongan'           => $dat[0]->GOLONGAN,
                        'jabatan_fungsional' => $dat[0]->JABFUNG,
                        'pendidikan'         => $dat[0]->PENDIDIKAN,
                        'email_ugm'          => $dat[0]->EMAIL1,
                        'ugm_id'             => $u_id[0],
                        'email'              => $dat[0]->EMAIL2,
                    );

                } catch (Exception $e) {
                    if ($e->getCode() == 404) {
                        try {
                            $ugm_id = $this->api_model->get_dosen($data->nip);
                            $json = @file_get_contents('http://pengabdianUGM:4gMPengaBdian2016@10.13.247.146/rest/sdm/dosen_by_email/email/' . $ugm_id->ugm_id);
                            if ($json === false) {
                                throw new Exception("not found", 404);
                            }
                            $dat = json_decode($json);
                            $arr = array(
                                'nama'               => $dat[0]->NAMA,
                                'nama_publikasi'     => $dat[0]->NAMA_PUBLIKASI,
                                'nidn'               => $dat[0]->NIDN,
                                'no_hp'              => $dat[0]->NO_HP,
                                'unit_kerja'         => $dat[0]->UNITKERJA,
                                'nama_bank'          => $dat[0]->NAMA_BANK,
                                'bank_cabang'        => $dat[0]->BANK_CABANG,
                                'no_rekening'        => $dat[0]->NO_REKENING,
                                'atas_nama_rekening' => $dat[0]->ATAS_NAMA_REKENING,
                                'tipe_rekening'      => $dat[0]->TIPE_REKENING,
                                'golongan'           => $dat[0]->GOLONGAN,
                                'jabatan_fungsional' => $dat[0]->JABFUNG,
                                'pendidikan'         => $dat[0]->PENDIDIKAN,
                                'nip'                => $dat[0]->NIP,
                                'email_ugm'          => $dat[0]->EMAIL1,
                                'email'              => $dat[0]->EMAIL2,
                            );
                        } catch (Exception $ex) {
                            show_error("NIP / Email tidak ditemukan pada webservice (mungkin sudah pensiun)", 404, "Error not found in webervice");
                        }
                    }
                }


                if ($this->api_model->update_dosen($data->nip, $arr) != true) {
                    show_error("Ada sesuatu yang bermasalah dengan server, silahkan kontak Pengembang, sertakan screenshot, tanggal dan jam kegiatan, dan urlnya", 500);
                }
            }
            $this->session->set_flashdata('notice', 'Berhasil memperbaharui dosen');
            redirect(site_url('/'));
        } else {

            if (count($this->api_model->get_dosen($nip)) > 0) { /* if dosen != null then update dosen */
                try {
                    $json = @file_get_contents('http://pengabdianUGM:4gMPengaBdian2016@10.13.247.146/rest/sdm/dosen_kkn/param/' . $nip);
                    if ($json === false) {
                        throw new Exception("not found", 404);
                    }
                    $dat = json_decode($json);
                    $u_id = explode("@", $dat[0]->EMAIL1);
                    $arr = array(
                        'nama'               => $dat[0]->NAMA,
                        'nama_publikasi'     => $dat[0]->NAMA_PUBLIKASI,
                        'nidn'               => $dat[0]->NIDN,
                        'no_hp'              => $dat[0]->NO_HP,
                        'unit_kerja'         => $dat[0]->UNITKERJA,
                        'nama_bank'          => $dat[0]->NAMA_BANK,
                        'bank_cabang'        => $dat[0]->BANK_CABANG,
                        'no_rekening'        => $dat[0]->NO_REKENING,
                        'atas_nama_rekening' => $dat[0]->ATAS_NAMA_REKENING,
                        'tipe_rekening'      => $dat[0]->TIPE_REKENING,
                        'golongan'           => $dat[0]->GOLONGAN,
                        'jabatan_fungsional' => $dat[0]->JABFUNG,
                        'pendidikan'         => $dat[0]->PENDIDIKAN,
                        'email_ugm'          => $dat[0]->EMAIL1,
                        'ugm_id'             => $u_id[0],
                        'email'              => $dat[0]->EMAIL2,
                    );
                } catch (Exception $e) {
                    if ($e->getCode() == 404) {
                        try {
                            $ugm_id = $this->api_model->get_dosen($nip);
                            $json = @file_get_contents('http://pengabdianUGM:4gMPengaBdian2016@10.13.247.146/rest/sdm/dosen_by_email/email/' . $ugm_id->ugm_id);
                            if ($json === false) {
                                throw new Exception("not found", 404);
                            }
                            $dat = json_decode($json);
                            $arr = array(
                                'nama'               => $dat[0]->NAMA,
                                'nama_publikasi'     => $dat[0]->NAMA_PUBLIKASI,
                                'nidn'               => $dat[0]->NIDN,
                                'no_hp'              => $dat[0]->NO_HP,
                                'unit_kerja'         => $dat[0]->UNITKERJA,
                                'nama_bank'          => $dat[0]->NAMA_BANK,
                                'bank_cabang'        => $dat[0]->BANK_CABANG,
                                'no_rekening'        => $dat[0]->NO_REKENING,
                                'atas_nama_rekening' => $dat[0]->ATAS_NAMA_REKENING,
                                'tipe_rekening'      => $dat[0]->TIPE_REKENING,
                                'golongan'           => $dat[0]->GOLONGAN,
                                'jabatan_fungsional' => $dat[0]->JABFUNG,
                                'pendidikan'         => $dat[0]->PENDIDIKAN,
                                'nip'                => $dat[0]->NIP,
                                'email_ugm'          => $dat[0]->EMAIL1,
                                'email'              => $dat[0]->EMAIL2,
                            );
                        } catch (Exception $ex) {
                            show_error("NIP / Email tidak ditemukan pada webservice (mungkin sudah pensiun)", 404, "Error not found in webervice");
                        }
                    }
                }
                if ($this->api_model->update_dosen($nip, $arr)) {
                    $this->session->set_flashdata('notice', 'Berhasil memperbaharui dosen');
                    redirect(site_url('data_dosen'));
                } else {
                    show_error("Ada sesuatu yang bermasalah dengan server, silahkan kontak Pengembang, sertakan screenshot, tanggal dan jam kegiatan, dan urlnya", 500);
                }
            } else { /* if dosen == null then insert new dosen */
                try {
                    $json = @file_get_contents('http://pengabdianUGM:4gMPengaBdian2016@10.13.247.146/rest/sdm/dosen_kkn/param/' . $nip);
                    if ($json === false) {
                        throw new Exception("not found", 404);
                    }
                    $dat = json_decode($json);
                    $u_id = explode("@", $dat[0]->EMAIL1);
                    $arr = array(
                        'nip'                => $nip,
                        'nama'               => $dat[0]->NAMA,
                        'nama_publikasi'     => $dat[0]->NAMA_PUBLIKASI,
                        'nidn'               => $dat[0]->NIDN,
                        'no_hp'              => $dat[0]->NO_HP,
                        'unit_kerja'         => $dat[0]->UNITKERJA,
                        'nama_bank'          => $dat[0]->NAMA_BANK,
                        'bank_cabang'        => $dat[0]->BANK_CABANG,
                        'no_rekening'        => $dat[0]->NO_REKENING,
                        'atas_nama_rekening' => $dat[0]->ATAS_NAMA_REKENING,
                        'tipe_rekening'      => $dat[0]->TIPE_REKENING,
                        'golongan'           => $dat[0]->GOLONGAN,
                        'jabatan_fungsional' => $dat[0]->JABFUNG,
                        'pendidikan'         => $dat[0]->PENDIDIKAN,
                        'email_ugm'          => $dat[0]->EMAIL1,
                        'ugm_id'             => $u_id[0],
                        'email'              => $dat[0]->EMAIL2,
                    );

                } catch (Exception $e) {
                    if ($e->getCode() == 404) {
                        try {
                            $json = @file_get_contents('http://pengabdianUGM:4gMPengaBdian2016@10.13.247.146/rest/sdm/dosen_by_email/email/' . $ug_id);
                            if ($json === false) {
                                throw new Exception("not found", 404);
                            }
                            $dat = json_decode($json);
                            $arr = array(
                                'nama'               => $dat[0]->NAMA,
                                'nama_publikasi'     => $dat[0]->NAMA_PUBLIKASI,
                                'nidn'               => $dat[0]->NIDN,
                                'no_hp'              => $dat[0]->NO_HP,
                                'unit_kerja'         => $dat[0]->UNITKERJA,
                                'nama_bank'          => $dat[0]->NAMA_BANK,
                                'bank_cabang'        => $dat[0]->BANK_CABANG,
                                'no_rekening'        => $dat[0]->NO_REKENING,
                                'atas_nama_rekening' => $dat[0]->ATAS_NAMA_REKENING,
                                'tipe_rekening'      => $dat[0]->TIPE_REKENING,
                                'golongan'           => $dat[0]->GOLONGAN,
                                'jabatan_fungsional' => $dat[0]->JABFUNG,
                                'pendidikan'         => $dat[0]->PENDIDIKAN,
                                'nip'                => $dat[0]->NIP,
                                'email_ugm'          => $dat[0]->EMAIL1,
                                'email'              => $dat[0]->EMAIL2,
                            );
                        } catch (Exception $ex) {
                            show_error("NIP / Email tidak ditemukan pada webservice", 404, "Error not found in webervice");
                        }
                    }
                }
                if ($this->api_model->insert_dosen($arr)) {
                    $this->session->set_flashdata('notice', 'Berhasil menambah data');
                    redirect(site_url('/'));
                }

            }
        }
    }

    public function kecamatan()
    {
        $q = $this->input->get('q');
        if (!$this->input->is_ajax_request()) {
            show_error('Ajax only', 500);
        }

        $data = $this->api_model->get_like_kecamatan($q)->result();

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function kabupaten()
    {
        $q = $this->input->get('q');
        if (!$this->input->is_ajax_request()) {
            show_error('Ajax only', 500);
        }

        $data = $this->api_model->get_like_kabupaten($q)->result();

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function provinsi()
    {
        $q = $this->input->get('q');
        if (!$this->input->is_ajax_request()) {
            show_error('Ajax only', 500);
        }

        $data = $this->api_model->get_like_provinsi($q)->result();

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function loker()
    {
        $q = $this->input->get('q');
        if (!$this->input->is_ajax_request()) {
            show_error('Ajax only', 500);
        }

        $data = $this->api_model->get_like_loker($q)->result();

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function first_lokasi()
    {
        $tingkat = $this->input->get('tingkat');
        $id = $this->input->get('id');
        $data = $this->api_model->first_lokasi($tingkat, $id);
        if (empty($data)) {
            $data = array('error' => 'Data tidak ditemukan', 'code' => 404);
        } else {
            $data = $data->row();
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function surat()
    {
        $tipe = $this->input->get('tipe');
        $tahun = $this->input->get('tahun');
        $data = '';
        if ($tipe == 'surat_masuk') {
            $data = $this->api_model->get_lokasi_surat_masuk($tahun);
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    public function unit_ugm()
    {
        $q = $this->input->get('q');
        if (!$this->input->is_ajax_request()) {
            show_error('Ajax only', 404);
        }

        $data = $this->api_model->get_like_unit_ugm($q);

        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

	public function pegawai(  ) {
		if (!$this->input->is_ajax_request()) {
			show_error("ajax request required", "404");
		}
		if ($this->input->get('q') != null) {
			$data = $this->api_model->get_like_pegawai($this->input->get('q'));
		} elseif ($this->input->get('id_pegawai') != null) {
			$data = $this->api_model->get_id_pegawai($this->input->get('id_pegawai'));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}