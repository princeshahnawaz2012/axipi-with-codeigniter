<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class settings extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/settings_model', '', true);

		if($this->input->get('stg_id')) {
			$this->stg_id = $this->input->get('stg_id');
		} else {
			$this->stg_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['settings_stg_code'] = array('stg.stg_code', 'like');
		$flt = build_filters($filters);

		$results = $this->settings_model->get_all_settings($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->settings_model->get_pagination_settings($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/settings/settings_index', $data, true);
	}
	public function rule_stg_code($stg_code, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT stg.stg_code FROM '.$this->db->dbprefix('stg').' AS stg WHERE stg.stg_code = ? AND stg.stg_code != ? GROUP BY stg.stg_id', array($stg_code, $current));
		} else {
			$query = $this->db->query('SELECT stg.stg_code FROM '.$this->db->dbprefix('stg').' AS stg WHERE stg.stg_code = ? GROUP BY stg.stg_id', array($stg_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_stg_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('stg_code', 'lang:stg_code', 'required|max_length[100]|callback_rule_stg_code');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/settings/settings_create', $data, true);
		} else {
			$this->db->set('stg_code', $this->input->post('stg_code'));
			$this->db->set('stg_value', $this->input->post('stg_value'));
			$this->db->set('stg_createdby', $this->usr->usr_id);
			$this->db->set('stg_datecreated', date('Y-m-d H:i:s'));
			$this->db->set('stg_ispublished', 1);
			$this->db->insert('stg');
			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read() {
		if($this->stg_id != 0) {
			$data = array();
			$data['stg'] = $this->settings_model->get_setting($this->stg_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/settings/settings_read', $data, true);
		}
	}
	public function update() {
		if($this->stg_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['stg'] = $this->settings_model->get_setting($this->stg_id);

			$this->form_validation->set_rules('stg_code', 'lang:stg_code', 'required|max_length[100]|callback_rule_stg_code['.$data['stg']->stg_code.']');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/settings/settings_update', $data, true);
			} else {
				$this->db->set('stg_code', $this->input->post('stg_code'));
				$this->db->set('stg_value', $this->input->post('stg_value'));
				$this->db->set('stg_modifiedby', $this->usr->usr_id);
				$this->db->set('stg_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('stg_id', $this->stg_id);
				$this->db->update('stg');
				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->stg_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['stg'] = $this->settings_model->get_setting($this->stg_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/settings/settings_delete', $data, true);
			} else {
				$this->db->where('stg_id', $this->stg_id);
				//$this->db->where('cmp_stg_islocked', 0);
				$this->db->delete('cmp_stg');

				$this->db->where('stg_id', $this->stg_id);
				//$this->db->where('hst_stg_islocked', 0);
				$this->db->delete('hst_stg');

				$this->db->where('stg_id', $this->stg_id);
				//$this->db->where('itm_stg_islocked', 0);
				$this->db->delete('itm_stg');

				$this->db->where('stg_id', $this->stg_id);
				//$this->db->where('lng_stg_islocked', 0);
				$this->db->delete('lng_stg');

				$this->db->where('stg_id', $this->stg_id);
				//$this->db->where('stg_usr_islocked', 0);
				$this->db->delete('stg_usr');

				$this->db->where('stg_id', $this->stg_id);
				$this->db->delete('stg_trl');

				$this->db->where('stg_id', $this->stg_id);
				$this->db->where('stg_islocked', 0);
				$this->db->delete('stg');
				$this->msg[] = $this->lang->line('deleted');
				$this->index();
			}
		}
	}
}
