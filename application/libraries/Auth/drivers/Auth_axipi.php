<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_Axipi extends CI_Driver {
	private $CI;
	public function __construct() {
		$this->CI =& get_instance();

		$this->CI->session_key = '5n2z8fg6y8j4a';

		$this->CI->key_id = 'axipi_id';
		$this->CI->key_password = 'axipi_password';
		$this->CI->key_remember = 'axipi_remember';
		$this->CI->key_token = 'axipi_token';
		$this->CI->key_time = 'axipi_time';
	}
	function set_cookie($data) {
		$this->CI->input->set_cookie($data);
		$this->CI->cookies[$data['name']] = $data['value'];
	}
	function get_cookie($name) {
		if(isset($this->CI->cookies[$name]) == 0) {
			$this->CI->cookies[$name] = $this->CI->input->cookie($name);
		}
	}
	function token() {
		$token_time = time();
		$token = $this->hash_token($token_time);
		$this->set_cookie(array('name'=>$this->CI->key_token, 'value'=>$token, 'expire'=>0, 'path'=>'/'));
		$this->set_cookie(array('name'=>$this->CI->key_time, 'value'=>$token_time, 'expire'=>0, 'path'=>'/'));
	}
	function hash_token($time) {
		return hash('sha256', $this->token_auth().$time);
	}
	function token_auth() {
		return $this->CI->session_key.$_SERVER['HTTP_HOST'].$_SERVER['HTTP_USER_AGENT'];
	}
	function hash_password($password) {
		return hash('sha256', $this->CI->session_key.$password);
	}
	public function login($email, $password) {
		$this->CI->session->unset_userdata('usr_id');
        $query = $this->CI->db->query('SELECT usr.usr_id, usr.usr_logincount, usr.usr_protectedpassword FROM '.$this->CI->db->dbprefix('usr').' AS usr WHERE usr.usr_email = ? GROUP BY usr.usr_id', array($email));
		if($query->num_rows() > 0) {
			$usr = $query->row();
			if(md5($password) == $usr->usr_protectedpassword) {
				$this->CI->db->set('usr_loginlast', date('Y-m-d H:i:s'));
				$this->CI->db->set('usr_logincount', $usr->usr_logincount + 1);
				$this->CI->db->where('usr_id', $usr->usr_id);
				$this->CI->db->update('usr');

				$this->token();
				$time = 0;
				$this->set_cookie(array('name'=>$this->CI->key_id, 'value'=>$usr->usr_id, 'expire'=>$time, 'path'=>'/'));
				$this->set_cookie(array('name'=>$this->CI->key_password, 'value'=>$this->hash_password($usr->usr_protectedpassword), 'expire'=>$time, 'path'=>'/'));

				$this->CI->session->set_userdata('usr_id', $usr->usr_id);
				return true;
			}
		}
		return false;
	}
	public function logout() {
		$this->CI->session->sess_destroy();
		$this->CI->input->set_cookie(array('name'=>$this->CI->key_id, 'value'=>'', 'expire'=>'', 'path'=>'/'));
		$this->CI->input->set_cookie(array('name'=>$this->CI->key_password, 'value'=>'', 'expire'=>'', 'path'=>'/'));
		$this->CI->input->set_cookie(array('name'=>$this->CI->key_remember, 'value'=>'', 'expire'=>'', 'path'=>'/'));
		$this->CI->input->set_cookie(array('name'=>$this->CI->key_token, 'value'=>'', 'expire'=>'', 'path'=>'/'));
		$this->CI->input->set_cookie(array('name'=>$this->CI->key_time, 'value'=>'', 'expire'=>'', 'path'=>'/'));
	}
	public function logged_in() {
		$this->get_cookie($this->CI->key_id);
		$this->get_cookie($this->CI->key_password);
		$this->get_cookie($this->CI->key_remember);
		$this->get_cookie($this->CI->key_token);
		$this->get_cookie($this->CI->key_time);

		if($this->CI->cookies[$this->CI->key_id] != '') {
			$enabled = 1;
			$token = $this->hash_token($this->CI->cookies[$this->CI->key_time]);
			if(strcmp($this->CI->cookies[$this->CI->key_token], $token) != 0) {
				$enabled = 0;
				$this->logout();
			}
			if($this->CI->session->userdata('usr_id') && $enabled == 1) {
				$this->token();
				$this->CI->usr = $this->get_user($this->CI->session->userdata('usr_id'));
				$this->CI->usr->usr_access = 'connected';
				$this->CI->usr->groups = $this->get_groups();
				$this->CI->usr->groups[1002] = 'connected';
				return true;
			}
		}
		return false;
	}
	public function set_user_default() {
		$this->CI->usr = new stdClass();
		$this->CI->usr->usr_id = 0;
		$this->CI->usr->usr_access = 'guest';
		$this->CI->usr->groups = array();
		$this->CI->usr->groups[1001] = 'guest';
	}
	public function get_user() {
        $query = $this->CI->db->query('SELECT usr.* FROM '.$this->CI->db->dbprefix('usr').' AS usr WHERE usr.usr_id = ? GROUP BY usr.usr_id', array($this->CI->session->userdata('usr_id')));
        return $query->row();
	}
	public function get_groups() {
		$groups = array();
        $query = $this->CI->db->query('SELECT grp_usr.grp_id, grp.grp_code FROM '.$this->CI->db->dbprefix('grp_usr').' AS grp_usr LEFT JOIN '.$this->CI->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_usr.grp_id WHERE grp_usr.usr_id = ? GROUP BY grp.grp_id', array($this->CI->session->userdata('usr_id')));
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$groups[$row->grp_id] = $row->grp_code;
			}
		}
        return $groups;
	}
}
