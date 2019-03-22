<?php

class Logbook_model extends CI_Model{
	var $tbl_logbook='logbook';
	var $tbl_attachment='attachment';
	var $tbl_user='users';
	var $tbl_access_logbook='access_logbook';


    public function __construct(){
        parent::__construct();
    }
    public function logbook(){
        $query = $this->db->get($this->tbl_logbook);
        return $query;
    }
    public function delete($id)
    {
    	$this->db->delete($this->tbl_logbook, "id_logbook=".$id);
    	return TRUE;
    }
    public function delete_attachment($id){
        $this->db->delete($this->tbl_attachment,"id_attach=".$id);
        return TRUE;
    }
        public function edit($id,$data)
    {
       $this->db->where('id_logbook', $id);
       $this->db->update($this->tbl_logbook, $data);

       return $data;
    }
        public function get_edit($id){
    	$data=$this->db->select('*')->from($this->tbl_logbook)->where('id_logbook',$id)->get();
    	return $data;
    }
    public function get_logbook($id){
        $data = $this->db->where('id_logbook',$id)->get($this->tbl_logbook);

        return $data;
    }
    public function get_attachment($id){
        $data = $this->db->where('id_attach',$id)->get($this->tbl_attachment);

        return $data;
    }
    // public function get_attachment($id)
    // { 
    // 	$this->db->select('*');
    // 	$this->db->from($this->tbl_attachment)->where($this->tbl_attachment.".id_attach",$id);
      
    //     $getdata = $this->db->get();
        
    //     return $getdata;
    // }
    function get_share($id){
    	$data=$this->db->select('*')->from($this->tbl_logbook)->where('id_logbook',$id)->get();
    	return $data;
    }
    function share($id){
    	$data=$this->db->select('*')->from($this->tbl_logbook)->where('id_logbook',$id)->get();
    	return $data;
    }
    function flush_akses($id){
        $this->db->where("id_logbook",$id);
        $this->db->delete($this->tbl_access_logbook);
        return true;
    }
    function create_access_logbook($id_logbook,$id_user){
        $data = array(
            'id_logbook' => $id_logbook,
            'id_user_tujuan'   => $id_user,
            'id_user_pengirim' => $this->ion_auth->user()->row()->id
        );
        $this->db->insert($this->tbl_access_logbook,$data);

        return true;
    }
    function get_user(){
    	$data=$this->db->select('*')->from($this->tbl_user)->get();
    	return $data;
    }
    public function create($data){
       $this->db->insert($this->tbl_logbook, $data);

       // id dari logbook yg barusan di insert
       return $this->db->insert_id();
    }
    function create_attachment($data){
        $this->db->insert($this->tbl_attachment,$data);

        return true;
    }
    
	
    function download_attachment($id){
        $data=$this->db->select('*')->from($this->tbl_attachment)->where('id_attach',$id)->get();
        return $data;
    }
    function get_nama_first_user($id){
        $data = $this->db->select('*')
            ->where('id',$id)
            ->from($this->tbl_user)
            ->get()
            ->row();

        return $data->first_name.' '.$data->last_name;
    }
  
	function uploadFiles($data){
		$this->db->insert($this->tbl_attachment,$data);

		return $this->db->insert_id();
	}

	public function edit_attachment($id,$data){
       $this->db->where("id_attach",$id);
       $this->db->update($this->tbl_attachment, $data);
       return $data;
    }

    public function get_list_attachment($id_logbook)
    {
    	$data=$this->db->where('id_logbook',$id_logbook)->get($this->tbl_attachment);

    	return $data;
    }
    public function access_logbook($id_logbook,$id_user){
        $c = $this->db->where(array(
            'id_logbook' => $id_logbook,
            'id_user_tujuan'   => $id_user
        ))->count_all_results($this->tbl_access_logbook);

        if ($c > 0){
            return true;
        }else{
            return false;
        }
    }

    public function bagikan_dengan_saya(){
        $query = $this->db->get($this->tbl_access_logbook);
        return $query;
    }
        public function bagikan_dengan_yang_lain(){
        $query = $this->db->get($this->tbl_access_logbook);
        return $query;
    }
}
