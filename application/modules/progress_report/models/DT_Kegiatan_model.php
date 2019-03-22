<?php


class DT_Kegiatan_model extends Datatable_Model
{
    var $table = 'kegiatan';

    var $search_column = array(
        'kegiatan_name'
    );
    var $select_column = array(
        'id_kegiatan',
        'kegiatan_name',
        'create_date',
        'sumber_dana'
    );
    var $order_column = array(
        'kegiatan_name',
        'create_date'
    );
    var $join = array();
    var $soft_delete = '';
    var $where = null;
    var $primary_key = 'id_kegiatan';

    public function set_dana($id)
    {
        $this->where='sumber_dana='.$id;
    }
}