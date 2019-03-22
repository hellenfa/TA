<?php

class User_model extends CI_Model{
	
    var $tbl_user = 'users';
    var $tbl_access_folder = 'access_folder';
    var $tbl_folder='folder';


    public function __construct(){
        parent::__construct();
    }

    public function user(){
        $query = $this->db->get($this->tbl_user);
        return $query;
    }

    public function create($data){
       $this->db->insert($this->tbl_user, $data);

       return TRUE;
    }
   
    public function get_edit($id){
    	$data=$this->db->select('*')
            ->from($this->tbl_user)
            ->where('id',$id)
            ->get();

    	return $data;
    }
   public function get_user($id){
        $data = $this->db->where('id',$id)->get($this->tbl_user);

        return $data;
    }
    public function get_folder(){
        $data=$this->db->select('*')->from($this->tbl_folder)->get();
        return $data;
    }

    public function create_access_folder($id_user,$id_folder){
        $data = array(
            'id_user'   => $id_user,
            'id_folder' => $id_folder
            
        );
        $this->db->insert($this->tbl_access_folder,$data);

        return true;
    }
    public function edit($id,$data)
    {
       $this->db->where('id', $id);
       $this->db->update($this->tbl_user, $data);

       return $data;
    }
    public function get_akses($id)
    { 
        $this->db->where("id", $id);
        $this->db->join($this->tbl_access_folder, "id = id_user");
        $this->db->join($this->tbl_folder, $this->tbl_folder.".id_folder = ".$this->tbl_access_folder.".id_folder");
        
        $getdata = $this->db->get($this->tbl_user)->result();
        
        return $getdata;
    }
    public function update_status($id, $data){
        $this->db->where("id", $id);
        $this->db->update($this->tbl_user, $data);
        return true;
    }

}