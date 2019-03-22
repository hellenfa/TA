<?php

class Evaluation_model extends CI_Model
{
    var $tbl_kriteria = 'kriteria';
    var $tbl_parameter = 'parameter';


    public function __construct()
    {
        parent::__construct();
    }

    function get_kriteria()
    {
        $data=$this->db->select('*')->from($this->$tbl_kriteria)->get();
        return $data;
    }

    public function parameter()
    {
        $data = $this->db->select('*')->from($this->$tbl_parameter)->get();
        return $data;
    }

}
