<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sections extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/sections_model', '', true);

		if($this->input->get('sct_id')) {
			$this->sct_id = $this->input->get('sct_id');
		} else {
			$this->sct_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['sections_sct_code'] = array('sct.sct_code', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'sct.sct_id';
		$columns[] = 'sct.sct_code';
		$columns[] = 'lay.lay_code';
		$columns[] = 'count_items';
		$col = build_columns('sections', $columns, 'sct.sct_id', 'DESC');

		$results = $this->sections_model->get_all_sections($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30, 'sections');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->sections_model->get_pagination_sections($flt, $build_pagination['limit'], $build_pagination['start'], 'sections');
		$this->zones['content'] = $this->load->view('axipi_dynamic/sections/sections_index', $data, true);
	}
	public function rule_sct_code($sct_code, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT sct.sct_code FROM '.$this->db->dbprefix('sct').' AS sct WHERE sct.sct_code = ? AND sct.sct_code != ? GROUP BY sct.sct_id', array($sct_code, $current));
		} else {
			$query = $this->db->query('SELECT sct.sct_code FROM '.$this->db->dbprefix('sct').' AS sct WHERE sct.sct_code = ? GROUP BY sct.sct_id', array($sct_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_sct_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['select_layout'] = $this->sections_model->select_layout();
		$data['translations'] = $this->sections_model->get_translations($this->sct_id);

		$this->form_validation->set_rules('sct_code', 'lang:sct_code', 'required|max_length[100]|callback_rule_sct_code');
		$this->form_validation->set_rules('lay_id', 'lang:lay_code', 'required');
		foreach($data['translations'] as $trl) {
			$this->form_validation->set_rules('title'.$trl->lng_id, $this->lang->line('sct_trl_title').' ('.$trl->lng_code.')', 'required');
		}

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/sections/sections_create', $data, true);
		} else {
			$this->db->set('lay_id', $this->input->post('lay_id'));
			$this->db->set('sct_code', $this->input->post('sct_code'));
			$this->db->set('sct_createdby', $this->usr->usr_id);
			$this->db->set('sct_datecreated', date('Y-m-d H:i:s'));
			$this->db->set('sct_ispublished', 1);
			$this->db->insert('sct');
			$sct_id = $this->db->insert_id();

			foreach($data['translations'] as $trl) {
				$this->db->set('sct_trl_title', $this->input->post('title'.$trl->lng_id));
				$this->db->set('sct_trl_description', $this->input->post('description'.$trl->lng_id));
				$this->db->set('sct_trl_keywords', $this->input->post('keywords'.$trl->lng_id));
				$this->db->set('sct_id', $sct_id);
				$this->db->set('lng_id', $trl->lng_id);
				$this->db->insert('sct_trl');
			}

			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read() {
		if($this->sct_id != 0) {
			$data = array();
			$data['sct'] = $this->sections_model->get_section($this->sct_id);
			$data['translations'] = $this->sections_model->get_translations($this->sct_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/sections/sections_read', $data, true);
		}
	}
	public function update() {
		if($this->sct_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['sct'] = $this->sections_model->get_section($this->sct_id);
			$data['select_layout'] = $this->sections_model->select_layout();
			$data['translations'] = $this->sections_model->get_translations($this->sct_id);

			$this->form_validation->set_rules('sct_code', 'lang:sct_code', 'required|max_length[100]|callback_rule_sct_code['.$data['sct']->sct_code.']');
			$this->form_validation->set_rules('lay_id', 'lang:lay_code', 'required');
			foreach($data['translations'] as $trl) {
				$this->form_validation->set_rules('title'.$trl->lng_id, $this->lang->line('sct_trl_title').' ('.$trl->lng_code.')', 'required');
			}

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/sections/sections_update', $data, true);
			} else {
				$this->db->set('lay_id', $this->input->post('lay_id'));
				$this->db->set('sct_code', $this->input->post('sct_code'));
				$this->db->set('sct_modifiedby', $this->usr->usr_id);
				$this->db->set('sct_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('sct_id', $this->sct_id);
				$this->db->update('sct');

				foreach($data['translations'] as $trl) {
					$this->db->set('sct_trl_title', $this->input->post('title'.$trl->lng_id));
					$this->db->set('sct_trl_description', $this->input->post('description'.$trl->lng_id));
					$this->db->set('sct_trl_keywords', $this->input->post('keywords'.$trl->lng_id));
					if($trl->sct_id) {
						$this->db->where('sct_id', $this->sct_id);
						$this->db->where('lng_id', $trl->lng_id);
						$this->db->update('sct_trl');
					} else {
						$this->db->set('sct_id', $this->sct_id);
						$this->db->set('lng_id', $trl->lng_id);
						$this->db->insert('sct_trl');
					}
				}

				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->sct_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['sct'] = $this->sections_model->get_section($this->sct_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/sections/sections_delete', $data, true);
			} else {
				$this->db->where('sct_id', $this->sct_id);
				$this->db->delete('sct_trl');

				$this->db->where('sct_id', $this->sct_id);
				$this->db->where('sct_islocked', 0);
				$this->db->delete('sct');
				$this->msg[] = $this->lang->line('deleted');
				$this->index();
			}
		}
	}
}
