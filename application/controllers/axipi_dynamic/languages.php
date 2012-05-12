<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class languages extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/languages_model', '', true);
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['languages_lng_code'] = array('lng.lng_code', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'lng.lng_id';
		$columns[] = 'lng.lng_code';
		$columns[] = 'lng.lng_title';
		$columns[] = 'count_items';
		$columns[] = 'count_users';
		$col = build_columns('languages', $columns, 'lng.lng_id', 'DESC');

		$results = $this->languages_model->get_all_languages($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30, 'languages');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->languages_model->get_pagination_languages($flt, $build_pagination['limit'], $build_pagination['start'], 'languages');
		$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_index', $data, true);
	}
	public function rule_lng_code($lng_code, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT lng.lng_code FROM '.$this->db->dbprefix('lng').' AS lng WHERE lng.lng_code = ? AND lng.lng_code != ? GROUP BY lng.lng_id', array($lng_code, $current));
		} else {
			$query = $this->db->query('SELECT lng.lng_code FROM '.$this->db->dbprefix('lng').' AS lng WHERE lng.lng_code = ? GROUP BY lng.lng_id', array($lng_code));
		}
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
		$data['select_lng_defaultitem'] = $this->languages_model->select_lng_defaultitem();

		$this->form_validation->set_rules('lng_code', 'lang:lng_code', 'required|exact_length[2]|callback_rule_lng_code');
		$this->form_validation->set_rules('lng_title', 'lang:lng_title', 'required|max_length[255]');
		$this->form_validation->set_rules('lng_defaultitem', 'lang:lng_defaultitem', 'required');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_create', $data, true);
		} else {
			$this->db->set('lng_code', $this->input->post('lng_code'));
			$this->db->set('lng_title', $this->input->post('lng_title'));
			$this->db->set('lng_defaultitem', $this->input->post('lng_defaultitem'));
			$this->db->set('lng_ispublished', 1);
			$this->db->set('lng_createdby', $this->usr->usr_id);
			$this->db->set('lng_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('lng');
			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read($lng_id) {
		$data = array();
		$data['lng'] = $this->languages_model->get_language($lng_id);
		if($data['lng']) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_read', $data, true);
		} else {
			$this->index();
		}
	}
	public function update($lng_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['lng'] = $this->languages_model->get_language($lng_id);
		if($data['lng']) {
			$data['select_lng_defaultitem'] = $this->languages_model->select_lng_defaultitem();

			$this->form_validation->set_rules('lng_code', 'lang:lng_code', 'required|exact_length[2]|callback_rule_lng_code['.$data['lng']->lng_code.']');
			$this->form_validation->set_rules('lng_title', 'lang:lng_title', 'required|max_length[255]');
				$this->form_validation->set_rules('lng_defaultitem', 'lang:lng_defaultitem', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_update', $data, true);
			} else {
				$this->db->set('lng_code', $this->input->post('lng_code'));
				$this->db->set('lng_title', $this->input->post('lng_title'));
				$this->db->set('lng_defaultitem', $this->input->post('lng_defaultitem'));
				$this->db->set('lng_modifiedby', $this->usr->usr_id);
				$this->db->set('lng_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('lng_id', $lng_id);
				$this->db->update('lng');
				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function delete($lng_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['lng'] = $this->languages_model->get_language($lng_id);
		if($data['lng']) {
			if($data['lng']->lng_islocked == 0) {
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
	
				if($this->form_validation->run() == FALSE) {
					$this->zones['content'] = $this->load->view('axipi_dynamic/languages/languages_delete', $data, true);
				} else {
					$this->db->where('lng_id', $lng_id);
					$this->db->delete('grp_trl');
	
					$this->db->where('lng_id', $lng_id);
					$this->db->delete('hst_trl');
	
					$this->db->where('lng_id', $lng_id);
					$this->db->delete('per_trl');
	
					$this->db->where('lng_id', $lng_id);
					$this->db->delete('sct_trl');
	
					$this->db->where('lng_id', $lng_id);
					$this->db->delete('trl_zon');
	
					$this->db->where('lng_id', $lng_id);
					$this->db->where('lng_islocked', 0);
					$this->db->delete('lng');
					$this->msg[] = $this->lang->line('deleted');
					$this->index();
				}
			} else {
				$this->index();
			}
		}
	}
}
