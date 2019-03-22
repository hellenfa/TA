<?php

class Recycle_bin_model extends CI_Model{
	var $tbl_document = 'documents';

    public function __construct()
    {
        parent::__construct();
    }

    public function document()
    {
        $data = $this->db->select('*')->from($this->tbl_document)->get();
        return $data;
    }

    public function get_document($id){
        $data=$this->db->select('*')->from($this->tbl_document)->where('id_doc',$id)->get();
        return $data;
    }

    public function delete_recycle_bin($id)
    {
        $this->db->delete($this->tbl_document, "id_doc=" . $id);
        return TRUE;
    }

    public function restore_document($id, $data)
    {
        $this->db->where("id_doc", $id);
        $this->db->update($this->tbl_document, $data);
        return $data;
    }
}