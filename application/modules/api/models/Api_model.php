<?php

class Api_model extends CI_Model
{
    var $tbl_kecamatan = 'ref_kecamatan';
    var $tbl_kabupaten = 'ref_kabupaten';
    var $tbl_provinsi = 'ref_provinsi';
    var $tbl_users = 'tbl_users';

    public function get_like_dosen($q)
    {
        $data = $this->db->select('nama_publikasi,nip,unit_kerja')
            ->from('tbl_dosen')
            ->where('deleted_at', null)
            ->like('nama_publikasi', $q)
            ->or_like('nip', $q)
            ->limit(10)
            ->get();

        return $data->result();
    }

    public function get_dosen($nip)
    {
        $data = $this->db->select('nama_publikasi,nip,ugm_id')
            ->from('tbl_dosen')
            ->where('nip', $nip)
            ->where('deleted_at', null)
            ->limit(1)
            ->get();

        return $data->row();
    }

    public function staff($q)
    {
        $data = $this->db->select('CONCAT(first_name," ",last_name) as nama,id')
            ->from('users')
            ->where('deleted_at', null)
            ->like('first_name', $q)
            ->or_like('last_name', $q)
            ->limit(10)
            ->get();

        return $data->result();
    }

    public function get_all_dosen()
    {
        $data = $this->db->select('*')->from('tbl_dosen')->where('deleted_at', null)->get();

        return $data;
    }

    public function update_dosen($nip, $arr = array())
    {
        $this->db->where('nip', $nip);
        $this->db->update('tbl_dosen', $arr);

        return true;
    }

    public function insert_dosen($arr = array())
    {
        $this->db->insert('tbl_dosen', $arr);

        return true;
    }

    public function get_like_kecamatan($q)
    {
        $data = $this->db->select($this->tbl_kecamatan . '.id as id, CONCAT(' . $this->tbl_kecamatan . '.kecamatan," KABUPATEN ",' . $this->tbl_kabupaten . '.kabupaten," PROVINSI ",' . $this->tbl_provinsi . '.provinsi) as kecamatan')
            ->from($this->tbl_kecamatan)
            ->join($this->tbl_kabupaten, $this->tbl_kecamatan.'.kabupaten_id = ' . $this->tbl_kabupaten . '.id')
            ->join($this->tbl_provinsi, $this->tbl_kabupaten . '.provinsi_kode = ' . $this->tbl_provinsi . '.kode')
            ->like($this->tbl_kecamatan.'.kecamatan', $q)
            ->limit(10)->get();

        return $data;
    }

    public function get_like_kabupaten($q)
    {
        $data = $this->db->select($this->tbl_kabupaten . '.id as id,CONCAT(' . $this->tbl_kabupaten . '.kabupaten," PROVINSI ",' . $this->tbl_provinsi . '.provinsi) as kabupaten')
            ->from($this->tbl_kabupaten)
            ->join($this->tbl_provinsi, $this->tbl_kabupaten . '.provinsi_kode = ' . $this->tbl_provinsi . '.kode')
            ->like($this->tbl_kabupaten.'.kabupaten', $q)->limit(10)->get();

        return $data;
    }

    public function get_like_provinsi($q)
    {
        $data = $this->db->select('kode as id, provinsi')
            ->from($this->tbl_provinsi)
            ->like('provinsi', $q)
            ->limit(10)
            ->get();

        return $data;
    }

    public function get_like_loker($q)
    {
        $data = $this->db->select('*')->from('tbl_surat_masuk_loker')->like('loker', $q)->limit(10)->get();

        return $data;
    }

    public function first_lokasi($tingkat, $id = null)
    {
        switch ($tingkat) {
            case "kecamatan":
                $data = $data = $this->db->select('*')->from('tbl_kecamatan')->where('id', $id)->get();
                break;
            case "kabupaten":
                $data = $data = $this->db->select('*')->from('tbl_kabupaten')->where('id', $id)->get();
                break;
            case "provinsi":
                $data = $data = $this->db->select('*')->from('tbl_provinsi')->where('kode', $id)->get();
                break;
            default:
                $data = null;
        }

        return $data;
    }

    public function get_lokasi_surat_masuk($tahun)
    {
        $data = $this->db->select('lat,lng,lokasi')->from('v_surat_masuk')->where('YEAR(tanggal)', $tahun)->where('lat IS NOT NULL')->get();

        return $data->result();
    }

    public function get_like_unit_ugm($q)
    {
        $data = $this->db->select('*')
            ->from('tbl_unit_ugm')
            ->like('unit', $q)
            ->limit(10)->get();

        return $data->result();
    }

	public function get_like_pegawai( $q ) {
		$data = $this->db->select('id,nama_publikasi')->from($this->tbl_users)->like('nama_publikasi',$q)->get();

		return $data->result();
    }

	public function get_id_pegawai( $id ) {
		$data = $this->db->select('id,nama_publikasi')->from($this->tbl_users)->where('id',$id)->get();

		return $data->row();
    }
}