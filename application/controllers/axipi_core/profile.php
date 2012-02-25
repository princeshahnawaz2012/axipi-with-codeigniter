<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profile extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->axipi_library->jquery_load('jquery');
	}
	public function index() {
		$this->zones['content'] = $this->load->view('axipi_core/profile_index', null, true);
	}
	public function rule_usr_email($usr_email, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT usr.usr_email FROM '.$this->db->dbprefix('usr').' AS usr WHERE usr.usr_email = ? AND usr.usr_email != ? GROUP BY usr.usr_id', array($usr_email, $current));
		} else {
			$query = $this->db->query('SELECT usr.usr_email FROM '.$this->db->dbprefix('usr').' AS usr WHERE usr.usr_email = ? GROUP BY usr.usr_id', array($usr_email));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_usr_email', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function update() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['usr'] = $this->users_model->get_user($this->usr->usr_id);

		$this->form_validation->set_rules('usr_email', 'lang:usr_email', 'required|max_length[100]|valid_email|callback_rule_usr_email['.$data['usr']->usr_email.']');
		$this->form_validation->set_rules('usr_emailconfirm', 'lang:usr_emailconfirm', 'required|max_length[100]|valid_email|matches[usr_email]');
		$this->form_validation->set_rules('usr_passwordconfirm', 'lang:usr_passwordconfirm', 'matches[usr_password]');
		$this->form_validation->set_rules('usr_firstname', 'lang:usr_firstname', 'max_length[100]');
		$this->form_validation->set_rules('usr_lastname', 'lang:usr_lastname', 'max_length[100]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_core/profile_update', $data, true);
		} else {
			$this->db->set('usr_email', $this->input->post('usr_email'));
			if($this->input->post('usr_password') != '' && $this->input->post('usr_passwordconfirm') != '') {
				$this->db->set('usr_protectedpassword', md5($this->input->post('usr_password')));
			}
			$this->db->set('usr_firstname', $this->input->post('usr_firstname'));
			$this->db->set('usr_lastname', $this->input->post('usr_lastname'));
			$this->db->set('usr_modifiedby', $this->usr->usr_id);
			$this->db->set('usr_datemodified', date('Y-m-d H:i:s'));
			$this->db->where('usr_id', $this->usr->usr_id);
			$this->db->update('usr');
			$this->msg[] = $this->lang->line('updated');
			$this->index();
		}
	}
}
