<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Axipi_controller extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->model('axipi_dynamic/items_model', '', true);

		if($this->input->get('itm_id')) {
			$this->itm_id = $this->input->get('itm_id');
		} else {
			$this->itm_id = 0;
		}

	}
	public function index() {
		$this->load->helper(array('axipi', 'form'));
		$this->load->library('pagination');
		$this->axipi_library->jquery_load('jquery');

		$filters = array();
		$filters['items_itm_code'] = array('itm.itm_code', 'like');
		$filters['items_itm_title'] = array('itm.itm_title', 'like');
		$filters['items_sct_id'] = array('itm.sct_id', 'equal');
		$filters['items_cmp_code'] = array('cmp.cmp_code', 'like');
		$filters['items_lng_id'] = array('itm.lng_id', 'equal');
		$flt = build_filters($filters);

		$get_pro_all = $this->items_model->get_all_items($flt);

		$config['base_url'] = '?';
		$config['total_rows'] = $get_pro_all[0]->count;
		$config['per_page'] = 30;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['first_url'] = '?page=1';
		$config['query_string_segment'] = 'page';
		
		$this->pagination->initialize($config);

		if($this->input->get('page') && is_numeric($this->input->get('page'))) {
			$page = $this->input->get('page');
			$this->session->set_userdata('per_page_items', $page);
		} else if($this->session->userdata('per_page_items') && is_numeric($this->session->userdata('per_page_items'))) {
			$_GET['page'] = $this->session->userdata('per_page_items');
		} else {
			$_GET['page'] = 0;
		}
		$start = ($this->input->get('page') * $config['per_page']) - $config['per_page'];
		if($start < 0) {
			$start = 0;
			$_GET['page'] = 1;
		}

		$data = array();
		$data['pagination'] = $this->pagination->create_links();
		$data['items'] = $this->items_model->get_pagination_items($flt, $config['per_page'], $start);
		$data['select_section'] = $this->items_model->select_section();
		$data['select_language'] = $this->items_model->select_language();
		$this->zones['content'] = $this->load->view('axipi_dynamic/items_index', $data, true);
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['select_component'] = $this->items_model->select_component();
		$data['select_section'] = $this->items_model->select_section();
		$data['select_language'] = $this->items_model->select_language();

		$this->form_validation->set_rules('sct_id', $this->lang->line('sct_code'), 'required');
		$this->form_validation->set_rules('itm_code', $this->lang->line('itm_code'), 'required|max_length[100]');
		$this->form_validation->set_rules('itm_virtualcode', $this->lang->line('itm_virtualcode'), 'max_length[100]');
		$this->form_validation->set_rules('itm_title', $this->lang->line('itm_title'), 'required|max_length[255]');
		$this->form_validation->set_rules('cmp_id', $this->lang->line('cmp_code'), 'required');
		$this->form_validation->set_rules('itm_link', $this->lang->line('itm_link'), 'max_length[255]');
		$this->form_validation->set_rules('itm_ordering', $this->lang->line('itm_ordering'), 'required|numeric');
		$this->form_validation->set_rules('lng_id', $this->lang->line('lng_code'), 'required');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/items_create', $data, true);
		} else {
			$this->db->set('sct_id', $this->input->post('sct_id'));
			$this->db->set('itm_code', $this->input->post('itm_code'));
			$this->db->set('itm_virtualcode', $this->input->post('itm_virtualcode'));
			$this->db->set('itm_title', $this->input->post('itm_title'));
			$this->db->set('cmp_id', $this->input->post('cmp_id'));
			$this->db->set('itm_content', $this->input->post('itm_content'));
			$this->db->set('itm_summary', $this->input->post('itm_summary'));
			$this->db->set('itm_link', $this->input->post('itm_link'));
			$this->db->set('lng_id', $this->input->post('lng_id'));
			$this->db->insert('itm'); 
			$this->index();
		}
	}
	public function read() {
		if($this->itm_id != 0) {
			$data = array();
			$data['itm'] = $this->items_model->get_item($this->itm_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/items_read', $data, true);
		}
	}
	public function update() {
		if($this->itm_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['itm'] = $this->items_model->get_item($this->itm_id);
			$data['select_component'] = $this->items_model->select_component();
			$data['select_section'] = $this->items_model->select_section();
			$data['select_language'] = $this->items_model->select_language();

			$this->form_validation->set_rules('sct_id', $this->lang->line('sct_code'), 'required');
			$this->form_validation->set_rules('itm_code', $this->lang->line('itm_code'), 'required|max_length[100]');
			$this->form_validation->set_rules('itm_virtualcode', $this->lang->line('itm_virtualcode'), 'max_length[100]');
			$this->form_validation->set_rules('itm_title', $this->lang->line('itm_title'), 'required|max_length[255]');
			$this->form_validation->set_rules('cmp_id', $this->lang->line('cmp_code'), 'required');
			$this->form_validation->set_rules('itm_link', $this->lang->line('itm_link'), 'max_length[255]');
			$this->form_validation->set_rules('itm_ordering', $this->lang->line('itm_ordering'), 'required|numeric');
			$this->form_validation->set_rules('lng_id', $this->lang->line('lng_code'), 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items_update', $data, true);
			} else {
				$this->db->set('sct_id', $this->input->post('sct_id'));
				$this->db->set('itm_code', $this->input->post('itm_code'));
				$this->db->set('itm_virtualcode', $this->input->post('itm_virtualcode'));
				$this->db->set('itm_title', $this->input->post('itm_title'));
				$this->db->set('cmp_id', $this->input->post('cmp_id'));
				$this->db->set('itm_content', $this->input->post('itm_content'));
				$this->db->set('itm_summary', $this->input->post('itm_summary'));
				$this->db->set('itm_link', $this->input->post('itm_link'));
				$this->db->set('lng_id', $this->input->post('lng_id'));
				$this->db->where('itm_id', $this->itm_id);
				$this->db->update('itm'); 
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->itm_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['itm'] = $this->items_model->get_item($this->itm_id);

			$this->form_validation->set_rules('confirm', $this->lang->line('confirm'), 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items_delete', $data, true);
			} else {
				$this->db->where('itm_id', $this->itm_id);
				$this->db->delete('itm'); 
				$this->index();
			}
		}
	}
}
