<?php

class Dokumentasi_model extends CI_Model{
	var $tbl_folder='folder';
	var $tbl_user='users';
	var $tbl_document = 'documents';
	var $tbl_access_folder = 'access_folder';
    var $tbl_log = 'log';

    public function __construct(){
        parent::__construct();
    }

    function get_folder($id){
        $data = $this->db->where('id_folder',$id)->get($this->tbl_folder);
        return $data;
    }

    public function folder(){
        $query = $this->db->where('parent',0)->get($this->tbl_folder);
        return $query;
    }

    public function get_subfolder($id){
        $query = $this->db->where('parent',$id)->get($this->tbl_folder);
        return $query;
    }

    public function create($data){
       $this->db->insert($this->tbl_folder, $data);
       return TRUE;
    }

    public function create_subfolder($data){
       $this->db->insert($this->tbl_folder, $data);
       return TRUE;
    }

    function get_edit($id){
    	$data=$this->db->select('*')->from($this->tbl_folder)->where('id_folder',$id)->get();
    	return $data;
    }

    function get_document($id){
        $data=$this->db->select('*')->from($this->tbl_document)->where('id_doc',$id)->get();
        return $data;
    }

    function get_document_folder($id){
        $data=$this->db->select('*')->from($this->tbl_document)->where('id_folder',$id)->get();
        return $data;
    }

    function get_log_document($id){
        $this->db->select('*')->from($this->tbl_log);
        $this->db->like('new','"id_doc":"'.$id.'"');
        $this->db->join($this->tbl_user, $this->tbl_log.'.id_user='.$this->tbl_user. '.id' );
        $data = $this->db->get();
        return $data;
    }

    function get_user(){
    	$data=$this->db->select('*')->from($this->tbl_user)->get();
    	return $data;
    }
    
    function get_user_api(){
        $data=$this->db->select("id,concat(first_name,' ',last_name) as name")
            ->from($this->tbl_user)
            ->get();
        return $data;
    }

    function get_first_user($id){
        $data=$this->db
            ->select("id,concat(first_name,' ',last_name) as name")
            ->where('id',$id)
            ->from($this->tbl_user)
            ->get();

        return $data;
    }

    function get_tipe($id){
        $data = $this->db->where('id', $id)->get($this->tbl_user);
    }
   
    public function edit($id,$data)
    {
       $this->db->where("id_folder",$id);
       $this->db->update($this->tbl_folder, $data);
       return $data;
    }

    public function edit_document($id,$data){
       $this->db->where("id_doc",$id);
       $this->db->update($this->tbl_document, $data);
       return $data;
    }

    function flush_akses($id){
        $this->db->where("id_folder",$id);
        $this->db->delete($this->tbl_access_folder);
        return true;
    }

    public function delete($id){
    	$this->db->where("id_folder",$id)->update($this->tbl_folder,array('deleted_at'=>date('Y-m-d H:i:s')));

    	return TRUE;
    }

    public function delete_document($id){
        $this->db->where("id_doc",$id)->update($this->tbl_document,array('deleted_at'=>date('Y-m-d H:i:s')));
        return TRUE;
    }

	function uploadFiles($data){
		$this->db->insert($this->tbl_document,$data);

		return $this->db->insert_id();
	}

	function get_bc($id){
        $data = $this->db->where('id_folder',$id)->get($this->tbl_folder);
        if ($data->row()->parent != 0){
            return $this->get_bc($data->row()->parent) . ' / ' . '<a href="'.base_url('dokumentasi/subfolder').'/'.$data->row()->id_folder.'">'.$data->row()->folder_name.'</a>' ;
        }else{
            return '<a href="'.base_url('dokumentasi/subfolder').'/'.$data->row()->id_folder.'">'.$data->row()->folder_name.'</a>';
        }
    }

    function create_dokumen($data){
        $this->db->insert($this->tbl_document,$data);
        return true;
    }

    function create_access_folder($id_folder,$id_user){
        $data = array(
            'id_folder' => $id_folder,
            'id_user'   => $id_user
        );
        $this->db->insert($this->tbl_access_folder,$data);
        return true;
    }

    function update_access_download($id_folder,$id_user){
        $data = array(
            'download_permission'   => 1
        );
        $this->db->where("id_folder",$id_folder);
        $this->db->where("id_user",$id_user);
        $this->db->update($this->tbl_access_folder,$data);
        return true;
    }

    function access($id_folder,$id_user){
        $c = $this->db->where(array(
            'id_folder' => $id_folder,
            'id_user'   => $id_user
        ))->count_all_results($this->tbl_access_folder);

        if ($c > 0){
            return true;
        }else{
            return false;
        }
    }

    function access_download($id_folder,$id_user){
        $c = $this->db->where(array(
            'id_folder'             => $id_folder,
            'id_user'               => $id_user,
            'download_permission'   => 1
        ))->count_all_results($this->tbl_access_folder);

        if ($c > 0){
            return true;
        }else{
            return false;
        }
    }

    function access_subfolder($id_folder,$id_user){
        $c = $this->db->where(array(
            'id_folder' => $id_folder,
            'id_user'   => $id_user
        ))->get($this->tbl_access_folder);
        return $c;
    }

}
