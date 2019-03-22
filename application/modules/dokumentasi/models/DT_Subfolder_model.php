<?php


class DT_Subfolder_model extends Datatable_Model{
    var $table = 'v_folder_documents';

    var $search_column = array(
        'name'
    );
    var $select_column = array(
        'id',
        'name',
        'create_date',
        'type',
        'extension'
    );
    var $order_column = array(
        'name',
        'create_date'
    );
    var $join = array();
    var $soft_delete = true;
    var $where = null;
    var $primary_key = 'id';
    var $tbl_access_folder = 'access_folder';
    var $tbl_folder = 'folder';

    public function set_parent($id)
    {
        $this->where='parent='.$id;
    }

    public function __construct()
    {
        parent::__construct();
        // if ($this->ion_auth->user()->row()->type != 'admin' && !$this->allowed($this->uri->segment('3'))) {
        //     redirect('dokumentasi');
        // }
    }

    private function allowed($id_folder_now){
        $access = $this->db->where(array('id_user'=>$this->ion_auth->user()->row()->id,'id_folder' => $id_folder_now))->get($this->tbl_access_folder);
        if ($access->row() != null) {
            return true;
        }else{
            $data = $this->db->where('id_folder',$id_folder_now)->get($this->tbl_folder);
            $par = $this->db->where(array('id_folder'=>$data->parent))->get($this->tbl_folder);
            if ($par->parent != 0) {
                // return true;
                allowed($par->id_folder);
            }else{
                // if parent and allowed?
                return false;
            }
        }
    }
}