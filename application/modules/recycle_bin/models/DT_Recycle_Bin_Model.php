<?php


class DT_Recycle_Bin_Model extends Datatable_Model
{
    var $table = 'documents';

    var $search_column = array(
        'doc_name'
    );
    var $select_column = array(
        'id_doc',
        'doc_name',
        'extension',
        'deleted_at',
        'id_folder',
    );
    var $order_column = array(
        'doc_name'
    );
    var $join = array();
    var $soft_delete = '';
    var $where = 'documents.deleted_at is not null';
    var $primary_key = 'id_doc';
    var $tbl_access_folder = 'access_folder';
    var $tbl_folder = 'folder';

    // public function set_folder()
    // {
    //      $this->db->join('folder', 'documents.id_folder=folder.id_folder', 'left');
    // }

    private function allowed($id_folder_now){
        // $access = $this->db->where(array('id_user'=>$this->ion_auth->user()->row()->id,'id_folder' => $id_folder_now))->get($this->tbl_access_folder);
        $access = $this->db->select('id_folder')->from($this->table)->join($this->tbl_folder,$this->table.'.id_folder = '.$this->tbl_folder.'.id_folder')->join($this->tbl_access_folder,$this->tbl_folder.'.id_folder = '.$this->tbl_access_folder.'.id_folder')->where($this->table.'.id_folder',$id_folder_now)->get();

        if ($access->row() != null) {
            return true;
        }else{
            $data = $this->db->where('id_folder',$id_folder_now)->get($this->tbl_folder);
            $par  = $this->db->where(array('id_folder'=>$data->parent))->get($this->tbl_folder);
            if ($par->parent != 0) {
                // return true;
                allowed($par->id_folder);
            }else{
                // if parent and allowed?
                return false;
            }
        }
    }
}
