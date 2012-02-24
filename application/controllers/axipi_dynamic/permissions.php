<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class permissions extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/permissions_model', '', true);

		if($this->input->get('per_id')) {
			$this->per_id = $this->input->get('per_id');
		} else {
			$this->per_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('axipi', 'form'));

		$filters = array();
		$filters['permissions_per_code'] = array('per.per_code', 'like');
		$flt = build_filters($filters);

		$results_count = $this->permissions_model->get_all_permissions($flt);
		$build_pagination = $this->axipi_library->build_pagination($results_count[0]->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->permissions_model->get_pagination_permissions($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_index', $data, true);
	}
	public function rule_per_code($per_code) {
		$query = $this->db->query('SELECT per.per_code FROM '.$this->db->dbprefix('per').' AS per WHERE per.per_code = ? GROUP BY per.per_id', array($per_code));
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_per_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('per_code', 'lang:per_code', 'required|max_length[100]|callback_rule_per_code');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_create', $data, true);
		} else {
			$this->db->set('per_code', $this->input->post('per_code'));
			$this->db->set('per_createdby', $this->usr[0]->usr_id);
			$this->db->set('per_datecreated', date('Y-m-d H:i:s'));
			$this->db->set('per_ispublished', 1);
			$this->db->insert('per');
			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read() {
		if($this->per_id != 0) {
			$data = array();
			$data['per'] = $this->permissions_model->get_permission($this->per_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_read', $data, true);
		}
	}
	public function update() {
		if($this->per_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['per'] = $this->permissions_model->get_permission($this->per_id);

			$this->form_validation->set_rules('per_code', 'lang:per_code', 'max_length[100]');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_update', $data, true);
			} else {
				$this->db->set('per_code', $this->input->post('per_code'));
				$this->db->set('per_modifiedby', $this->usr[0]->usr_id);
				$this->db->set('per_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('per_id', $this->per_id);
				$this->db->update('per');
				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->per_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['per'] = $this->permissions_model->get_permission($this->per_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_delete', $data, true);
			} else {
				$this->db->where('per_id', $this->per_id);
				$this->db->where('per_islocked', 0);
				$this->db->delete('per');
				$this->msg[] = $this->lang->line('deleted');
				$this->index();
			}
		}
	}
}
