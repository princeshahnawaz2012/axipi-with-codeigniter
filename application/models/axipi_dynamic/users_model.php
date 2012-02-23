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
	function get_all_users($flt) {
        $query = $this->db->query('SELECT COUNT(usr.usr_id) AS count FROM '.$this->db->dbprefix('usr').' AS usr WHERE '.implode(' AND ', $flt));
        return $query->result();
    }
    function get_pagination_users($flt, $num, $offset) {
        $query = $this->db->query('SELECT usr.usr_id, usr.usr_email, usr.usr_islocked, usr.usr_ispublished, GROUP_CONCAT(DISTINCT grp.grp_code ORDER BY grp.grp_code ASC SEPARATOR \', \') AS groups, COUNT(DISTINCT(grp_usr.grp_id)) AS count_groups FROM '.$this->db->dbprefix('usr').' AS usr LEFT JOIN '.$this->db->dbprefix('grp_usr').' AS grp_usr ON grp_usr.usr_id = usr.usr_id LEFT JOIN '.$this->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_usr.grp_id WHERE '.implode(' AND ', $flt).' GROUP BY usr.usr_id ORDER BY usr.usr_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_user($usr_id) {
        $query = $this->db->query('SELECT usr.* FROM '.$this->db->dbprefix('usr').' AS usr WHERE usr.usr_id = ? GROUP BY usr.usr_id', array($usr_id));
        return $query->result();
    }
}
