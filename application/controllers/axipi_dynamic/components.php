<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Axipi_controller extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->model('axipi_dynamic/components_model', '', true);

		if($this->input->get('cmp_id')) {
			$this->cmp_id = $this->input->get('cmp_id');
		} else {
			$this->cmp_id = 0;
		}

	}
	public function index() {
		$this->load->library('pagination');

		$get_pro_all = $this->components_model->get_all_components();

		$config['base_url'] = '?';
		$config['total_rows'] = $get_pro_all[0]->count;
		$config['per_page'] = 20;
		$config['page_query_string'] = TRUE;
		
		$this->pagination->initialize($config);

		$segment_array = $this->uri->segment_array();
		$segment_count = $this->uri->total_segments();
		if($this->input->get('per_page')) {
			$limit = $this->input->get('per_page');
		} else {
			$limit = 0;
		}

		$data = array();
		$data['pagination'] = $this->pagination->create_links();
		$data['projects'] = $this->components_model->get_pagination_components($config['per_page'], $limit);
		$this->zones['content'] = $this->load->view('axipi_dynamic/components_index', $data, true);
	}
	public function add() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['select_component'] = $this->components_model->select_component();
		$data['select_section'] = $this->components_model->select_section();
		$data['select_language'] = $this->components_model->select_language();

		$this->form_validation->set_rules('cmp_code', $this->lang->line('cmp_code'), 'required|max_length[100]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/components_add', $data, true);
		} else {
			$this->db->set('cmp_code', $this->input->post('cmp_code'));
			$this->db->insert('cmp'); 
			$this->index();
		}
	}
	public function update() {
		if($this->cmp_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['cmp'] = $this->components_model->get_component($this->cmp_id);

			$this->form_validation->set_rules('cmp_code', $this->lang->line('cmp_code'), 'max_length[100]');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/components_update', $data, true);
			} else {
				$this->db->set('cmp_code', $this->input->post('cmp_code'));
				$this->db->where('cmp_id', $this->cmp_id);
				$this->db->update('cmp'); 
				$this->index();
			}
		}
	}
}
