<?php

class Progress_report_model extends CI_Model
{
    var $tbl_user = 'users';
    var $tbl_sumber_dana = 'sumber_dana';
    var $tbl_kegiatan = 'kegiatan';
    var $tbl_subkegiatan = 'subkegiatan';
    var $tbl_detail_subkegiatan = 'detail_subkegiatan';
    var $tbl_jenis_lelang = 'jenis_lelang';
    var $tbl_tahap_lelang = 'tahap_lelang';
    var $tbl_document = 'documents';

    public function __construct()
    {
        parent::__construct();
    }

    function get_user()
    {
        $data=$this->db->select('*')->from($this->tbl_user)->get();
        return $data;
    }

    public function sumber_dana()
    {
        $data = $this->db->select('*')->from($this->tbl_sumber_dana)->get();
        return $data;
    }

    public function get_sumber_dana($id)
    {
        $data = $this->db->select('*')->from($this->tbl_sumber_dana)->where('id_dana', $id)->get();
        return $data;
    }

    public function get_kegiatan($id)
    {
        $data = $this->db->select('*')->from($this->tbl_kegiatan)->where('id_kegiatan', $id)->get();
        return $data;
    }

    public function get_subkegiatan($id)
    {
        $data = $this->db->select('*')->from($this->tbl_subkegiatan)->where('id_subkegiatan', $id)->get();
        return $data;
    }

    public function get_detail_subkegiatan($id)
    {
        $data = $this->db->select('*')->from($this->tbl_detail_subkegiatan)->where('id_detail_subkegiatan', $id)->get();
        return $data;
    }

    public function get_redo_detail_subkegiatan($id)
    {
        $data = $this->db->select('detail_subkegiatan_name, id_jenis_lelang, id_subkegiatan')->from($this->tbl_detail_subkegiatan)->where('id_detail_subkegiatan', $id)->get();
        return $data;
    }

    public function jenis_lelang()
    {
        $data = $this->db->select('*')->from($this->tbl_jenis_lelang)->get();
        return $data;
    }

    public function get_jenis_lelang($id)
    {
        $data = $this->db->select('*')->from($this->tbl_jenis_lelang)->where('id_jenis_lelang', $id)->get();
        return $data;
    }

    public function get_all_jenis_lelang()
    {
        $data = $this->db->select('*')->get($this->tbl_jenis_lelang);

        return $data;
    }

    public function get_like_jenis_lelang($term)
    {
        $data = $this->db->select('*')->like('jenis_lelang_name', $term)->get($this->tbl_jenis_lelang, 10);

        return $data;
    }

    public function get_tahap_lelang($id)
    {
        $data = $this->db->select('*')->from($this->tbl_tahap_lelang)->where('id_tahap_lelang', $id)->get();
        return $data;
    }

    public function create_sumber_dana($data)
    {
        $this->db->insert($this->tbl_sumber_dana, $data);
        return TRUE;
    }

    public function create_kegiatan($data)
    {
        $this->db->insert($this->tbl_kegiatan, $data);
        return TRUE;
    }

    public function create_subkegiatan($data)
    {
        $this->db->insert($this->tbl_subkegiatan, $data);
        return $this->db->insert_id();
    }

    public function create_detail_subkegiatan($data)
    {
        $this->db->insert($this->tbl_detail_subkegiatan, $data);
        return TRUE;
    }

    public function create_jenis_lelang($data)
    {
        $this->db->insert($this->tbl_jenis_lelang, $data);
        return TRUE;
    }

    public function create_tahap_lelang($data)
    {
        $this->db->insert($this->tbl_tahap_lelang, $data);
        return TRUE;
    }

    public function edit_sumber_dana($id, $data)
    {
        $this->db->where("id_dana", $id);
        $this->db->update($this->tbl_sumber_dana, $data);
        return $data;
    }

    public function edit_kegiatan($id, $data)
    {
        $this->db->where("id_kegiatan", $id);
        $this->db->update($this->tbl_kegiatan, $data);
        return $data;
    }

    public function edit_subkegiatan($id, $data)
    {
        $this->db->where("id_subkegiatan", $id);
        $this->db->update($this->tbl_subkegiatan, $data);
        return $data;
    }

    public function edit_detail_subkegiatan($id, $data)
    {
        $this->db->where("id_detail_subkegiatan", $id);
        $this->db->update($this->tbl_detail_subkegiatan, $data);
        return $data;
    }

    public function edit_jenis_lelang($id, $data)
    {
        $this->db->where("id_jenis_lelang", $id);
        $this->db->update($this->tbl_jenis_lelang, $data);
        return $data;
    }

    public function edit_tahap_lelang($id, $data)
    {
        $this->db->where("id_tahap_lelang", $id);
        $this->db->update($this->tbl_tahap_lelang, $data);
        return $data;
    }

    public function delete_sumber_dana($id)
    {
        $this->db->delete($this->tbl_sumber_dana, "id_dana=" . $id);
        return TRUE;
    }

    public function delete_kegiatan($id)
    {
        $this->db->delete($this->tbl_kegiatan, "id_kegiatan=" . $id);
        return TRUE;
    }

    public function delete_subkegiatan($id)
    {
        $this->db->delete($this->tbl_subkegiatan, "id_subkegiatan=" . $id);
        return TRUE;
    }

    public function delete_detail_subkegiatan($id)
    {
        $this->db->delete($this->tbl_detail_subkegiatan, "id_detail_subkegiatan=" . $id);
        return TRUE;
    }

    function delete_file($id){
        $this->db->where('id_detail_subkegiatan',$id)->set(array(
            'deleted_at'=>date('Y-m-d H:i:s')))->update($this->tbl_document);
        return true;
    }

    function get_document($id){
        $data=$this->db->select('*')->from($this->tbl_document)->where('id_doc',$id)->get();
        return $data;
    }

    function uploadFiles($data)
    {
        $this->db->insert($this->tbl_document, $data);
        return $this->db->insert_id();
    }

    function is_exist_file($id)
    {
        $data=$this->db->where('id_detail_subkegiatan',$id)->count_all_results($this->tbl_document);
        if($data > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function edit_document($id,$data){
       $this->db->where("id_doc",$id);
       $this->db->update($this->tbl_document, $data);
       return $data;
    }

    function get_string_detail_subkegiatan($id_jenis_lelang)
    {
        $tahap = $this->db->select('*')->where('id_jenis_lelang', $id_jenis_lelang)->get($this->tbl_tahap_lelang)->result();
        $data = '';
        if (count($tahap ) < 1){
            return "";
        }
        return $tahap;

        
        // for ($i=0; $i<count($tahap)-1; $i++) {
        //     $data = $data . $tahap[$i]->tahap_lelang_name . ' > ';
        // }
        // $data = $data.$tahap[count($tahap)-1]->tahap_lelang_name;

        // return $data;
    }

    function arr_user()
    {
        $result = $this->db->select('*')->get($this->tbl_user);
        
        $dd[''] = 'Please Select';
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
            // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                $dd[$row->id] = $row->user;
            }
        }
        return $dd;
    }

    function get_bc_sumber_dana($id){
       $data = $this->db->where('id_dana',$id)->get($this->tbl_sumber_dana);
       return '<a href="'.base_url('progress_report/sumber_dana').'/'.$data->row()->id_dana.'">'.$data->row()->dana_name.'</a>' ;
    }

    function get_bc_kegiatan($id){
       $data = $this->db->where('id_kegiatan',$id)->get($this->tbl_kegiatan);
       return '<a href="'.base_url('progress_report/kegiatan').'/'.$data->row()->id_kegiatan.'">'.$data->row()->kegiatan_name.'</a>' ;
    }

    function get_bc_subkegiatan($id){
       $data = $this->db->where('id_subkegiatan',$id)->get($this->tbl_subkegiatan);
       return '<a href="'.base_url('progress_report/subkegiatan').'/'.$data->row()->id_subkegiatan.'">'.$data->row()->subkegiatan_name.'</a>' ;
    }

    function get_sumber($id_subkegiatan){
        $data = $this->db->select('sumber_dana')->from($this->tbl_subkegiatan)->join($this->tbl_kegiatan,$this->tbl_subkegiatan.'.id_kegiatan = '.$this->tbl_kegiatan.'.id_kegiatan')->join($this->tbl_sumber_dana,$this->tbl_kegiatan.'.sumber_dana = '.$this->tbl_sumber_dana.'.id_dana')->where($this->tbl_subkegiatan.'.id_subkegiatan',$id_subkegiatan)->get();
        return $data;
    }

}
