<?php

/**
 * Class Log_model
 * @property Ion_auth $ion_auth
 */
class Log_model extends CI_Model{
    var $table 		 = 'log';
	public function add( $ip,$activity,$status=null,$new=null ) {
		$data = array(
			'ip'        => $ip,
			'activity'  => $activity,
			'status'    => $status,
			'new'       => $new,
			'id_user'   => $this->ion_auth->logged_in() ? $this->ion_auth->user()->row()->id : 0,
		);
		

		$this->db->insert($this->table,$data);
	}
}