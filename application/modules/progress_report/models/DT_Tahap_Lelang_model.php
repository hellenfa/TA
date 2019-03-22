<?php


class DT_Tahap_Lelang_model extends Datatable_Model
{
    var $table = 'tahap_lelang';

    var $search_column = array(
        'tahap_lelang_name'
    );
    var $select_column = array(
        'id_tahap_lelang',
        'tahap_lelang_name',
        'id_jenis_lelang'
    );
    var $order_column = array(
        'tahap_lelang_name',
    );
    var $join = array();
    var $soft_delete = '';
    var $where = null;
    var $primary_key = 'id_tahap_lelang';

    public function set_jenis_lelang($id)
    {
        $this->where='id_jenis_lelang='.$id;
    }
}