<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users_model extends CI_Model {
    function __construct() {
        parent::__construct();

		$this->session_key = '5n2z8fg6y8j4a';

		$this->key_id = 'axipi-id';
		$this->key_password = 'axipi-password';
		$this->key_remember = 'axipi-remember';
		$this->key_token = 'axipi-token';
		$this->key_time = 'axipi-time';

		$this->cookie_id = $this->input->cookie($this->key_id);
		$this->cookie_password = $this->input->cookie($this->key_password);
		$this->cookie_remember = $this->input->cookie($this->key_remember);
		$this->cookie_token = $this->input->cookie($this->key_token);
		$this->cookie_time = $this->input->cookie($this->key_time);
    }
	function token() {
		$token_time = time();
		$token = $this->hash_token($token_time);

		$this->cookie_token = $this->input->set_cookie(array('name'=>$this->key_token, 'value'=>$token, 'expire'=>0, 'path'=>'/', 'secure'=>TRUE));
		$this->cookie_time = $this->input->set_cookie(array('name'=>$this->key_time, 'value'=>$token_time, 'expire'=>0, 'path'=>'/', 'secure'=>TRUE));
	}
	function hash_token($time) {
		return hash('sha256', $this->token_auth().$time);
	}
	function token_auth() {
		return $this->session_key.$_SERVER['HTTP_HOST'].$_SERVER['HTTP_USER_AGENT'];
	}
	function hash_password($password) {
		return hash('sha256', $this->session_key.$password);
	}
	function login($email, $password) {
		$this->session->unset_userdata('usr_id');
        $query = $this->db->query('SELECT usr.usr_id, usr.usr_logincount, usr.usr_protectedpassword FROM '.$this->db->dbprefix('usr').' AS usr WHERE usr.usr_email = ? GROUP BY usr.usr_id', array($email));
		if($query->num_rows() > 0) {
			$usr = $query->row();
			if(md5($password) == $usr->usr_protectedpassword) {
				$this->db->set('usr_loginlast', date('Y-m-d H:i:s'));
				$this->db->set('usr_logincount', $usr->usr_logincount + 1);
				$this->db->where('usr_id', $usr->usr_id);
				$this->db->update('usr');

				$this->token();
				$time = 0;
				$this->cookie_id = $this->input->set_cookie(array('name'=>$this->key_id, 'value'=>$usr->usr_id, 'expire'=>$time, 'path'=>'/', 'secure'=>TRUE));
				$this->cookie_password = $this->input->set_cookie(array('name'=>$this->key_password, 'value'=>$this->hash_password($usr->usr_protectedpassword), 'expire'=>$time, 'path'=>'/', 'secure'=>TRUE));

				$this->session->set_userdata('usr_id', $usr->usr_id);
				return true;
			}
		}
		return false;
	}
	function get_all_users($flt) {
        $query = $this->db->query('SELECT COUNT(usr.usr_id) AS count FROM '.$this->db->dbprefix('usr').' AS usr WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_users($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT usr.usr_id, usr.usr_email, usr.usr_islocked, usr.usr_ispublished, GROUP_CONCAT(DISTINCT grp.grp_code ORDER BY grp.grp_code ASC SEPARATOR \', \') AS groups, COUNT(DISTINCT(grp_usr.grp_id)) AS count_groups FROM '.$this->db->dbprefix('usr').' AS usr LEFT JOIN '.$this->db->dbprefix('grp_usr').' AS grp_usr ON grp_usr.usr_id = usr.usr_id LEFT JOIN '.$this->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_usr.grp_id WHERE '.implode(' AND ', $flt).' GROUP BY usr.usr_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_user($usr_id) {
        $query = $this->db->query('SELECT usr.* FROM '.$this->db->dbprefix('usr').' AS usr WHERE usr.usr_id = ? GROUP BY usr.usr_id', array($usr_id));
        return $query->row();
    }
    function get_groups($usr_id) {
		$groups = array();
        $query = $this->db->query('SELECT grp_usr.grp_id, grp.grp_code FROM '.$this->db->dbprefix('grp_usr').' AS grp_usr LEFT JOIN '.$this->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_usr.grp_id WHERE grp_usr.usr_id = ? GROUP BY grp.grp_id', array($usr_id));
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$groups[$row->grp_id] = $row->grp_code;
			}
		}
        return $groups;
    }
}
