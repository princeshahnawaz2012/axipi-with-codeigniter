<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Axipi_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->config('axipi', TRUE);
		$this->tables = $this->config->item('tables', 'ion_auth');
	}
    function user_login($usr_email, $usr_plainpassword) {
        $query = $this->db->query('SELECT * FROM '.$this->tables['users'].' WHERE usr_email = ?', array($usr_email));
		if($query->num_rows() == 1) {
			$usr = $query->row();
			if($usr_password == '') {
				return true;
			}
		}
    }
    function user_get_groups($usr_id) {
        $query = $this->db->query('SELECT * FROM '.$this->tables['groups_users'].' WHERE usr_id = ?', array($usr_id));
        return $query->result();
    }
}
