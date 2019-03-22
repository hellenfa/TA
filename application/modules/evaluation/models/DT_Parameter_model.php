<?php

class DT_Parameter_model extends Datatable_Model
{
    var $table = 'parameter';

    var $search_column = array(
        'parameter_name'
    );
    var $select_column = array(
        'id_parameter',
        'parameter_name'
    );
    var $order_column = array(
        'parameter_name',
    );
    var $primary_key = 'id_parameter';
}
