<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
	function login($usr_email, $usr_plainpassword) {
		$this->session->unset_userdata('usr_id');
        $query = $this->db->query('SELECT usr.usr_id, usr.usr_logincount, usr.usr_protectedpassword FROM '.$this->db->dbprefix('usr').' AS usr WHERE usr.usr_email = ? GROUP BY usr.usr_id', array($usr_email));
		if($query->num_rows() > 0) {
			$usr = $query->result();
			if(md5($usr_plainpassword) == $usr[0]->usr_protectedpassword) {
				$this->db->set('usr_loginlast', date('Y-m-d H:i:s'));
				$this->db->set('usr_logincount', $usr[0]->usr_logincount + 1);
				$this->db->where('usr_id', $usr[0]->usr_id);
				$this->db->update('usr');
				$this->session->set_userdata('usr_id', $usr[0]->usr_id);
				return true;
			}
		}
		return false;
	}
	function get_user($usr_id) {
        $query = $this->db->query('SELECT usr.* FROM '.$this->db->dbprefix('usr').' AS usr WHERE usr.usr_id = ? GROUP BY usr.usr_id', array($usr_id));
		$usr = $query->result();
		$usr[0]->usr_access = 'connected';
		return $usr;
	}
}
