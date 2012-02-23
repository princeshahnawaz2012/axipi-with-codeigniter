<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class languages extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/languages_model', '', true);

		if($this->input->get('lng_id')) {
			$this->lng_id = $this->input->get('lng_id');
		} else {
			$this->lng_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('axipi', 'form'));

		$filters = array();
		$filters['languages_lng_code'] = array('lng.lng_code', 'like');
		$flt = build_filters($filters);

		$results_count = $this->languages_model->get_all_languages($flt);
		$build_pagination = $this->axipi_library->build_pagination($results_count[0]->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['results'] = $this->languages_model->get_pagination_languages($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_index', $data, true);
	}
	public function rule_lng_code($lng_code) {
		$query = $this->db->query('SELECT lng.lng_code FROM '.$this->db->dbprefix('lng').' AS lng WHERE lng.lng_code = ? GROUP BY lng.lng_id', array($lng_code));
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_lng_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('lng_code', 'lang:lng_code', 'required|exact_length[2]|callback_rule_lng_code');
		$this->form_validation->set_rules('lng_title', 'lang:lng_title', 'required|max_length[255]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_create', $data, true);
		} else {
			$this->db->set('lng_code', $this->input->post('lng_code'));
			$this->db->set('lng_title', $this->input->post('lng_title'));
			$this->db->set('lng_ispublished', 1);
			$this->db->insert('lng'); 
			$this->index();
		}
	}
	public function read() {
		if($this->lng_id != 0) {
			$data = array();
			$data['lng'] = $this->languages_model->get_language($this->lng_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_read', $data, true);
		}
	}
	public function update() {
		if($this->lng_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['lng'] = $this->languages_model->get_language($this->lng_id);

			$this->form_validation->set_rules('lng_code', 'lang:lng_code', 'required|exact_length[2]');
			$this->form_validation->set_rules('lng_title', 'lang:lng_title', 'required|max_length[255]');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_update', $data, true);
			} else {
				$this->db->set('lng_code', $this->input->post('lng_code'));
				$this->db->set('lng_title', $this->input->post('lng_title'));
				$this->db->where('lng_id', $this->lng_id);
				$this->db->update('lng'); 
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->lng_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['lng'] = $this->languages_model->get_language($this->lng_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_delete', $data, true);
			} else {
				$this->db->where('lng_id', $this->lng_id);
				$this->db->where('lng_islocked', 0);
				$this->db->delete('lng'); 
				$this->index();
			}
		}
	}
}
