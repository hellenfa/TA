<?php


class DT_Subkegiatan_model extends Datatable_Model
{
    var $table = 'subkegiatan';

    var $search_column = array(
        'subkegiatan_name'
    );
    var $select_column = array(
        'id_subkegiatan',
        'subkegiatan_name',
        'create_date',
        // 'status'
    );
    var $order_column = array(
        'subkegiatan_name',
        'create_date'
    );
    var $join = array();
    var $soft_delete = '';
    var $where = null;
    var $primary_key = 'id_subkegiatan';

    public function set_kegiatan($id)
    {
        $this->where='id_kegiatan='.$id;
    }
}