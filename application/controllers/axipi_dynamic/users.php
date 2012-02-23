<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/users_model', '', true);

		if($this->input->get('usr_id')) {
			$this->usr_id = $this->input->get('usr_id');
		} else {
			$this->usr_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('axipi', 'form'));

		$filters = array();
		$filters['users_usr_email'] = array('usr.usr_email', 'like');
		$flt = build_filters($filters);

		$results_count = $this->users_model->get_all_users($flt);
		$build_pagination = $this->axipi_library->build_pagination($results_count[0]->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['results'] = $this->users_model->get_pagination_users($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/users/users_index', $data, true);
	}
	public function rule_usr_email($usr_email) {
		$query = $this->db->query('SELECT usr.usr_email FROM '.$this->db->dbprefix('usr').' AS usr WHERE usr.usr_email = ? GROUP BY usr.usr_id', array($usr_email));
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_usr_email', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('usr_email', 'lang:usr_email', 'required|max_length[100]|callback_rule_usr_email');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/users/users_create', $data, true);
		} else {
			$this->db->set('usr_email', $this->input->post('usr_email'));
			$this->db->set('usr_ispublished', 1);
			$this->db->insert('usr');
			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read() {
		if($this->usr_id != 0) {
			$data = array();
			$data['usr'] = $this->users_model->get_user($this->usr_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/users/users_read', $data, true);
		}
	}
	public function update() {
		if($this->usr_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['usr'] = $this->users_model->get_user($this->usr_id);

			$this->form_validation->set_rules('usr_email', 'lang:usr_email', 'max_length[100]');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/users/users_update', $data, true);
			} else {
				$this->db->set('usr_email', $this->input->post('usr_email'));
				$this->db->where('usr_id', $this->usr_id);
				$this->db->update('usr');
				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->usr_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['usr'] = $this->users_model->get_user($this->usr_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/users/users_delete', $data, true);
			} else {
				$this->db->where('usr_id', $this->usr_id);
				$this->db->where('usr_islocked', 0);
				$this->db->delete('usr');
				$this->msg[] = $this->lang->line('deleted');
				$this->index();
			}
		}
	}
}
