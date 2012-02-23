<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class components extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/components_model', '', true);

		if($this->input->get('cmp_id')) {
			$this->cmp_id = $this->input->get('cmp_id');
		} else {
			$this->cmp_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('axipi', 'form'));

		$filters = array();
		$filters['components_cmp_code'] = array('cmp.cmp_code', 'like');
		$flt = build_filters($filters);

		$results_count = $this->components_model->get_all_components($flt);
		$build_pagination = $this->axipi_library->build_pagination($results_count[0]->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['results'] = $this->components_model->get_pagination_components($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_index', $data, true);
	}
	public function rule_cmp_code($cmp_code) {
		$query = $this->db->query('SELECT cmp.cmp_code FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE cmp.cmp_code = ? GROUP BY cmp.cmp_id', array($cmp_code));
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_cmp_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('cmp_code', 'lang:cmp_code', 'required|max_length[100]|callback_rule_cmp_code');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_create', $data, true);
		} else {
			$this->db->set('cmp_code', $this->input->post('cmp_code'));
			$this->db->set('cmp_ispublished', 1);
			$this->db->insert('cmp'); 
			$this->index();
		}
	}
	public function read() {
		if($this->cmp_id != 0) {
			$data = array();
			$data['cmp'] = $this->components_model->get_component($this->cmp_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_read', $data, true);
		}
	}
	public function update() {
		if($this->cmp_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['cmp'] = $this->components_model->get_component($this->cmp_id);

			$this->form_validation->set_rules('cmp_code', 'lang:cmp_code', 'max_length[100]');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_update', $data, true);
			} else {
				$this->db->set('cmp_code', $this->input->post('cmp_code'));
				$this->db->where('cmp_id', $this->cmp_id);
				$this->db->update('cmp'); 
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->cmp_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['cmp'] = $this->components_model->get_component($this->cmp_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_delete', $data, true);
			} else {
				$this->db->where('cmp_id', $this->cmp_id);
				$this->db->where('cmp_islocked', 0);
				$this->db->delete('cmp'); 
				$this->index();
			}
		}
	}
}
