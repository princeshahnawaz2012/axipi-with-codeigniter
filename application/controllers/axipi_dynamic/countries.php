<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class countries extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/countries_model', '', true);

		if($this->input->get('cou_id')) {
			$this->cou_id = $this->input->get('cou_id');
		} else {
			$this->cou_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('axipi', 'form'));

		$filters = array();
		$filters['countries_cou_alpha2'] = array('cou.cou_alpha2', 'like');
		$flt = build_filters($filters);

		$results_count = $this->countries_model->get_all_countries($flt);
		$build_pagination = $this->axipi_library->build_pagination($results_count[0]->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['results'] = $this->countries_model->get_pagination_countries($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/countries/countries_index', $data, true);
	}
	public function rule_cou_alpha2($cou_alpha2) {
		$query = $this->db->query('SELECT cou.cou_alpha2 FROM '.$this->db->dbprefix('cou').' AS cou WHERE cou.cou_alpha2 = ? country BY cou.cou_id', array($cou_alpha2));
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_cou_alpha2', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('cou_alpha2', 'lang:cou_alpha2', 'required|max_length[100]|callback_rule_cou_alpha2');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/countries/countries_create', $data, true);
		} else {
			$this->db->set('cou_alpha2', $this->input->post('cou_alpha2'));
			$this->db->set('cou_alpha3', $this->input->post('cou_alpha3'));
			$this->db->set('cou_ispublished', 1);
			$this->db->insert('cou');
			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read() {
		if($this->cou_id != 0) {
			$data = array();
			$data['cou'] = $this->countries_model->get_country($this->cou_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/countries/countries_read', $data, true);
		}
	}
	public function update() {
		if($this->cou_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['cou'] = $this->countries_model->get_country($this->cou_id);

			$this->form_validation->set_rules('cou_alpha2', 'lang:cou_alpha2', 'max_length[100]');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/countries/countries_update', $data, true);
			} else {
				$this->db->set('cou_alpha2', $this->input->post('cou_alpha2'));
				$this->db->set('cou_alpha3', $this->input->post('cou_alpha3'));
				$this->db->where('cou_id', $this->cou_id);
				$this->db->update('cou');
				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->cou_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['cou'] = $this->countries_model->get_country($this->cou_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/countries/countries_delete', $data, true);
			} else {
				$this->db->where('cou_id', $this->cou_id);
				$this->db->where('cou_islocked', 0);
				$this->db->delete('cou');
				$this->msg[] = $this->lang->line('deleted');
				$this->index();
			}
		}
	}
}
