<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class User_m extends CI_Model{

	function get_user($q = NULL) {
		return $this->db->get_where('users',$q);
	}

	function get_token($q = NULL){
		$this->db->select('token');
		return $this->db->get_where('users',$q);
	}

	function update_token($id, $data) {
		$data = array(
        'token' => $data
			);
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		$row = $this->db->affected_rows();
		if ($row > 0){
			return true;
		}else {
			return false;
		}
	}

}
