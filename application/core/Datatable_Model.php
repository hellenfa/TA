<?php


class Datatable_Model extends CI_Model{
    /*
     * here is editable
     */
    var $table = '';
    var $search_column = array();
    var $select_column = array();
    var $order_column = array();
    var $join = array();
    var $soft_delete = true;
    var $where = '';
    var $primary_key = 'id';

    /*
     * restricted to edit
     */
    public function __construct()
    {
        $this->load->helper('pixel_admin_helper');
    }

    function make_datatables()
    {
        make_query($this->table,$this->select_column,$this->search_column,$this->order_column,$this->join,$this->primary_key);

        if ($_POST['length'] != -1){
            $this->db->limit($_POST['length'],$_POST['start']);
        }
        if (!empty($this->where)){
            $this->db->where($this->where);
        }
        if ($this->soft_delete){
            $this->db->where($this->table.'.deleted_at',null);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function get_filtered_data()
    {
        make_query($this->table,$this->order_column,$this->search_column,$this->order_column,$this->join,$this->primary_key);
        if (!empty($this->where)){
            $this->db->where($this->where);
        }
        if ($this->soft_delete){
            $this->db->where($this->table.'.deleted_at',null);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        if (count($this->join) > 0){
            foreach ($this->join as $item) {
                $this->db->join($item[0],$item[1]);
            }
        }
        if (!empty($this->where)){
            $this->db->where($this->where);
        }
        if ($this->soft_delete){
            $this->db->where($this->table.'.deleted_at',null);
        }
        return $this->db->count_all_results();
    }
}
