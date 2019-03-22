<?php


class DT_Sumber_Dana_Model extends Datatable_Model
{
    var $table = 'sumber_dana';

    var $search_column = array(
        'dana_name'
    );
    var $select_column = array(
        'id_dana',
        'dana_name'
    );
    var $order_column = array(
        'dana_name'
    );
    var $join = array();
    var $soft_delete = '';
    var $where = '';
    var $primary_key = 'id_dana';
}
