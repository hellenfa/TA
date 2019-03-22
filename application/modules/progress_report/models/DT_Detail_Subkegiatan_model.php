<?php


class DT_Detail_Subkegiatan_model extends Datatable_Model
{
    var $table = 'detail_subkegiatan';

    var $search_column = array(
        'detail_subkegiatan_name'
    );
    var $select_column = array(
        'detail_subkegiatan.id_detail_subkegiatan',
        'detail_subkegiatan_name',
        'plan_start',
        'plan_finish',
        'actual_start',
        'actual_finish',
        'id_doc',
        'doc_name',
        'status',
        'notes'
    );
    var $order_column = array(
        'detail_subkegiatan_name',
        'plan_start',
    );
    var $join = array();
    var $soft_delete = '';
    var $where = 'documents.deleted_at is null';
    var $primary_key = 'id_detail_subkegiatan';

    public function set_dokumen()
    {
         $this->db->join('documents', 'detail_subkegiatan.id_detail_subkegiatan=documents.id_detail_subkegiatan', 'left');
         $this->db->where('documents.deleted_at',null);
    }

    public function set_subkegiatan($id)
    {
        $this->where='id_subkegiatan='.$id;
    }
}