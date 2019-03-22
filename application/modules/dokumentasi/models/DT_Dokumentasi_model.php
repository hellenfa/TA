<?php


class DT_Dokumentasi_Model extends Datatable_Model
{
    var $table = 'folder';

    var $search_column = array(
        'folder_name'
    );
    var $select_column = array(
        'folder.id_folder',
        'folder_name',
        'create_date',
        'parent'
    );
    var $order_column = array(
        'folder_name',
        'create_date'
    );
    var $join = array();
    var $soft_delete = true;
    var $where = '';
    var $primary_key = 'id_folder';

    public function __construct()
    {
        parent::__construct();
        if ($this->ion_auth->user()->row()->type != 'admin'){
            $this->join = array(
                array('access_folder', 'folder.id_folder=access_folder.id_folder')
            );
            $this->where = $this->where . 'access_folder.id_user=' . $this->ion_auth->user()->row()->id;
            // $this->where = $this->where . ' and parent=0';
        }else{
            $this->where = 'parent=0';
        }
    }
}
