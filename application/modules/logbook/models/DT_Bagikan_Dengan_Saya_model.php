<?php


class DT_Bagikan_Dengan_Saya_Model extends Datatable_Model{
	var $table = 'logbook';
    var $tbl_access_logbook = 'access_logbook';
    var $search_column = array(
        'logbook_name'
    );
    var $select_column = array(
        'logbook.id_logbook',
        'logbook_name',
        'updated_date'
    );
    var $order_column = array(
        'logbook_name',
        'updated_date'
    );
    var $join = array();

    var $soft_delete = false;
    var $where = '';
    var $primary_key = 'id_logbook';

    public function setConfig()
    {
        $this->where = $this->tbl_access_logbook.'.id_user_tujuan='.$this->ion_auth->user()->row()->id;
        $this->join = array(array($this->tbl_access_logbook,$this->table.".id_logbook = ".$this->tbl_access_logbook.".id_logbook"));
    }
}