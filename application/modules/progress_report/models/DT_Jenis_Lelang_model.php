<?php

class DT_Jenis_Lelang_model extends Datatable_Model
{
    var $table = 'jenis_lelang';

    var $search_column = array(
        'jenis_lelang_name'
    );
    var $select_column = array(
        'id_jenis_lelang',
        'jenis_lelang_name'
    );
    var $order_column = array(
        'jenis_lelang_name',
    );
    var $join = array();
    var $soft_delete = '';
    var $where = null;
    var $primary_key = 'id_jenis_lelang';
}