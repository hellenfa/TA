<?php


class DT_Log_Dokumentasi_model extends Datatable_Model{
    var $table = 'log';

    var $search_column = array(
        'username'
    );
    var $select_column = array(
        'log.id',
        'users.username',
        'created_at',
        'activity',
        'new'
    );
    var $order_column = array(
        'users.username',
        'created_at',
        'activity',
    );
    var $join = array();
    var $soft_delete = false;
    var $where = null;
    var $primary_key = 'id';

    var $tbl_user = 'users';

    function get_log_document($id){
        $this->join=[
            array($this->tbl_user, $this->table.'.id_user='.$this->tbl_user. '.id' )
        ];
        $this->where= 'new like \'%"id_doc":"'.$id.'"%\'';
        // $this->db->like('new','"id_doc":"'.$id.'"');
    }
}