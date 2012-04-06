<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_Axipi extends CI_Driver {
	private $CI;
	public function __construct() {
		$this->CI =& get_instance();

		$this->session_key = '5n2z8fg6y8j4a';

		$this->key_id = 'axipi-id';
		$this->key_password = 'axipi-password';
		$this->key_remember = 'axipi-remember';
		$this->key_token = 'axipi-token';
		$this->key_time = 'axipi-time';

		$this->cookie_id = $this->CI->input->cookie($this->key_id);
		$this->cookie_password = $this->CI->input->cookie($this->key_password);
		$this->cookie_remember = $this->CI->input->cookie($this->key_remember);
		$this->cookie_token = $this->CI->input->cookie($this->key_token);
		$this->cookie_time = $this->CI->input->cookie($this->key_time);
	}
	function token() {
		$token_time = time();
		$token = $this->hash_token($token_time);

		$this->cookie_token = $this->CI->input->set_cookie(array('name'=>$this->key_token, 'value'=>$token, 'expire'=>0, 'path'=>'/', 'secure'=>TRUE));
		$this->cookie_time = $this->CI->input->set_cookie(array('name'=>$this->key_time, 'value'=>$token_time, 'expire'=>0, 'path'=>'/', 'secure'=>TRUE));
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
				$this->cookie_id = $this->CI->input->set_cookie(array('name'=>$this->key_id, 'value'=>$usr->usr_id, 'expire'=>$time, 'path'=>'/', 'secure'=>TRUE));
				$this->cookie_password = $this->CI->input->set_cookie(array('name'=>$this->key_password, 'value'=>$this->hash_password($usr->usr_protectedpassword), 'expire'=>$time, 'path'=>'/', 'secure'=>TRUE));

				$this->CI->session->set_userdata('usr_id', $usr->usr_id);
				return true;
			}
		}
		return false;
	}
	public function logout() {
		$this->CI->session->sess_destroy();
	}
	public function logged_in() {
		if($this->CI->session->userdata('usr_id')) {
			$this->CI->usr = $this->get_user($this->CI->session->userdata('usr_id'));
			$this->CI->usr->usr_access = 'connected';
			$this->CI->usr->groups = $this->get_groups();
			$this->CI->usr->groups[1002] = 'connected';
			return true;
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
