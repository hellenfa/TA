<?php

class Konfig_model extends CI_Model {
	public function get_konfig( $nama ) {
		$q    = $this->db->select( 'value' )
		                 ->from( 'tbl_konfig' )
		                 ->where( 'nama', $nama )
		                 ->get();
		$data = $q->row();

		return $data->value;
	}
}