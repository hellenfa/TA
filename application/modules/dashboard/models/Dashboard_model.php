<?php

class Dashboard_model extends CI_Model{
	public function grup() {
        return $this->db->select('*')->from('groups')->get();
	}
}