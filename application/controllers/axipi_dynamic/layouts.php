<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class layouts extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/layouts_model', '', true);

		if($this->input->get('lay_id')) {
			$this->lay_id = $this->input->get('lay_id');
		} else {
			$this->lay_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('axipi', 'form'));

		$filters = array();
		$filters['layouts_lay_code'] = array('lay.lay_code', 'like');
		$flt = build_filters($filters);

		$results_count = $this->layouts_model->get_all_layouts($flt);
		$build_pagination = $this->axipi_library->build_pagination($results_count[0]->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->layouts_model->get_pagination_layouts($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_index', $data, true);
	}
	public function rule_lay_code($lay_code) {
		$query = $this->db->query('SELECT lay.lay_code FROM '.$this->db->dbprefix('lay').' AS lay WHERE lay.lay_code = ? GROUP BY lay.lay_id', array($lay_code));
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_lay_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('lay_code', 'lang:lay_code', 'required|max_length[100]|callback_rule_lay_code');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_create', $data, true);
		} else {
			$this->db->set('lay_code', $this->input->post('lay_code'));
			$this->db->set('lay_ispublished', 1);
			$this->db->insert('lay');
			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read() {
		if($this->lay_id != 0) {
			$data = array();
			$data['lay'] = $this->layouts_model->get_layout($this->lay_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_read', $data, true);
		}
	}
	public function update() {
		if($this->lay_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['lay'] = $this->layouts_model->get_layout($this->lay_id);

			$this->form_validation->set_rules('lay_code', 'lang:lay_code', 'max_length[100]');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_update', $data, true);
			} else {
				$this->db->set('lay_code', $this->input->post('lay_code'));
				$this->db->where('lay_id', $this->lay_id);
				$this->db->update('lay');
				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->lay_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['lay'] = $this->layouts_model->get_layout($this->lay_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_delete', $data, true);
			} else {
				$this->db->where('lay_id', $this->lay_id);
				$this->db->where('lay_islocked', 0);
				$this->db->delete('lay');
				$this->msg[] = $this->lang->line('deleted');
				$this->index();
			}
		}
	}
}
