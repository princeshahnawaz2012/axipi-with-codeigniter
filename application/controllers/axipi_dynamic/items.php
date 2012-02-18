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
		$this->load->library('pagination');

		$get_pro_all = $this->items_model->get_all_items();

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
		$data['projects'] = $this->items_model->get_pagination_items($config['per_page'], $limit);
		$this->zones['content'] = $this->load->view('axipi_dynamic/items_index', $data, true);
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
			$this->form_validation->set_rules('itm_code', $this->lang->line('itm_code'), 'required|max_length[255]');
			$this->form_validation->set_rules('cmp_id', $this->lang->line('cmp_code'), 'required');
			$this->form_validation->set_rules('lng_id', $this->lang->line('lng_code'), 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/item_update', $data, true);
			} else {
				$this->db->set('sct_id', $this->input->post('sct_id'));
				$this->db->set('itm_code', $this->input->post('itm_code'));
				$this->db->set('itm_content', $this->input->post('itm_content'));
				$this->db->set('cmp_id', $this->input->post('cmp_id'));
				$this->db->set('lng_id', $this->input->post('lng_id'));
				$this->db->where('itm_id', $this->itm_id);
				$this->db->update('itm'); 
				redirect($this->uri->uri_string());
			}
		}
	}
}
