<?php


class DT_Folder_Progress_Report_model extends Datatable_Model{
    var $table = 'documents';

    var $search_column = array(
        'doc_name'
    );
    var $select_column = array(
        'id_doc',
        'doc_name',
        'upload_date',
        'extension',
        'id_folder',
        'id_detail_subkegiatan',
    );
    var $order_column = array(
        'doc_name',
        'upload_date',
    );
    var $join = array();
    var $soft_delete = true;
    var $where = 'documents.id_folder=1';
    var $primary_key = 'id_doc';
}