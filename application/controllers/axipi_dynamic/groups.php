<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class groups extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/groups_model', '', true);

		if($this->input->get('grp_id')) {
			$this->grp_id = $this->input->get('grp_id');
		} else {
			$this->grp_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['groups_grp_code'] = array('grp.grp_code', 'like');
		$flt = build_filters($filters);

		$results = $this->groups_model->get_all_groups($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->groups_model->get_pagination_groups($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_index', $data, true);
	}
	public function rule_grp_code($grp_code, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT grp.grp_code FROM '.$this->db->dbprefix('grp').' AS grp WHERE grp.grp_code = ? AND grp.grp_code != ? GROUP BY grp.grp_id', array($grp_code, $current));
		} else {
			$query = $this->db->query('SELECT grp.grp_code FROM '.$this->db->dbprefix('grp').' AS grp WHERE grp.grp_code = ? GROUP BY grp.grp_id', array($grp_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_grp_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('grp_code', 'lang:grp_code', 'required|max_length[100]|callback_rule_grp_code');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_create', $data, true);
		} else {
			$this->db->set('grp_code', $this->input->post('grp_code'));
			$this->db->set('grp_createdby', $this->usr->usr_id);
			$this->db->set('grp_datecreated', date('Y-m-d H:i:s'));
			$this->db->set('grp_ispublished', 1);
			$this->db->insert('grp');
			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read() {
		if($this->grp_id != 0) {
			$data = array();
			$data['grp'] = $this->groups_model->get_group($this->grp_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_read', $data, true);
		}
	}
	public function update() {
		if($this->grp_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['grp'] = $this->groups_model->get_group($this->grp_id);

			$this->form_validation->set_rules('grp_code', 'lang:grp_code', 'required|max_length[100]|callback_rule_grp_code['.$data['grp']->grp_code.']');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_update', $data, true);
			} else {
				$this->db->set('grp_code', $this->input->post('grp_code'));
				$this->db->set('grp_modifiedby', $this->usr->usr_id);
				$this->db->set('grp_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('grp_id', $this->grp_id);
				$this->db->update('grp');
				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->grp_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['grp'] = $this->groups_model->get_group($this->grp_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_delete', $data, true);
			} else {
				$this->db->where('grp_id', $this->grp_id);
				$this->db->delete('grp_itm');

				$this->db->where('grp_id', $this->grp_id);
				$this->db->delete('grp_trl');

				$this->db->where('grp_id', $this->grp_id);
				$this->db->where('grp_per_islocked', 0);
				$this->db->delete('grp_per');

				$this->db->where('grp_id', $this->grp_id);
				$this->db->where('grp_usr_islocked', 0);
				$this->db->delete('grp_usr');

				$this->db->where('grp_id', $this->grp_id);
				$this->db->where('grp_islocked', 0);
				$this->db->delete('grp');
				$this->msg[] = $this->lang->line('deleted');
				$this->index();
			}
		}
	}
}
