<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Axipi_controller extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('axipi_dynamic/groups_model', '', true);

		if($this->input->get('grp_id')) {
			$this->grp_id = $this->input->get('grp_id');
		} else {
			$this->grp_id = 0;
		}

	}
	public function index() {
		$this->zones['content'] = $this->load->view('welcome_index', '', true);
	}
	public function update() {
		if($this->grp_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['grp'] = $this->groups_model->get_group($this->grp_id);

			$this->form_validation->set_rules('grp_code', $this->lang->line('grp_code'), 'required|max_length[255]');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/group_update', $data, true);
			} else {
				$this->db->set('grp_code', $this->input->post('grp_code'));
				$this->db->where('grp_id', $this->grp_id);
				$this->db->update('grp'); 
				redirect($this->uri->uri_string());
			}
		}
	}
}
