<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class zones extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/zones_model', '', true);

		if($this->input->get('zon_id')) {
			$this->zon_id = $this->input->get('zon_id');
		} else {
			$this->zon_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['zones_zon_code'] = array('zon.zon_code', 'like');
		$filters['zones_lay_id'] = array('zon.lay_id', 'equal');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'zon.zon_id';
		$columns[] = 'zon.zon_code';
		$columns[] = 'lay.lay_code';
		$columns[] = 'zon.zon_ordering';
		$columns[] = 'count_items';
		$col = build_columns('zones', $columns, 'zon.zon_id', 'DESC');

		$results = $this->zones_model->get_all_zones($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30, 'zones');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->zones_model->get_pagination_zones($flt, $build_pagination['limit'], $build_pagination['start'], 'zones');
		$data['select_layout'] = $this->zones_model->select_layout();
		$this->zones['content'] = $this->load->view('axipi_dynamic/zones/zones_index', $data, true);
	}
	public function rule_zon_code($zon_code, $current = '') {
		if(strstr($current, ',')) {
			list($new_lay_id, $old_lay_id, $old_zon_code) = explode(',', $current);
			if($old_lay_id != $new_lay_id) {
				$query = $this->db->query('SELECT zon.zon_code FROM '.$this->db->dbprefix('zon').' AS zon WHERE zon.lay_id = ? AND zon.zon_code = ? GROUP BY zon.zon_id', array($new_lay_id, $zon_code));
			} else {
				$query = $this->db->query('SELECT zon.zon_code FROM '.$this->db->dbprefix('zon').' AS zon WHERE zon.lay_id = ? AND zon.zon_code != ? AND zon.zon_code = ? GROUP BY zon.zon_id', array($old_lay_id, $old_zon_code, $zon_code));
			}
		} else {
			$query = $this->db->query('SELECT zon.zon_code FROM '.$this->db->dbprefix('zon').' AS zon WHERE zon.lay_id = ? AND zon.zon_code = ? GROUP BY zon.zon_id', array($current, $zon_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_zon_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['select_layout'] = $this->zones_model->select_layout();
		$data['translations'] = $this->zones_model->get_translations($this->zon_id);

		$this->form_validation->set_rules('lay_id', 'lang:lay_code', 'required');
		if($this->input->post('lay_id')) {
			$this->form_validation->set_rules('zon_code', 'lang:zon_code', 'required|max_length[100]|callback_rule_zon_code['.$this->input->post('lay_id').']');
		}
		$this->form_validation->set_rules('zon_ordering', 'lang:zon_ordering', 'required|numeric');
		foreach($data['translations'] as $trl) {
			$this->form_validation->set_rules('title'.$trl->lng_id, 'lang:trl_zon_title', 'required');
		}

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/zones/zones_create', $data, true);
		} else {
			$this->db->set('lay_id', $this->input->post('lay_id'));
			$this->db->set('zon_code', $this->input->post('zon_code'));
			$this->db->set('zon_ordering', $this->input->post('zon_ordering'));
			$this->db->set('zon_createdby', $this->usr->usr_id);
			$this->db->set('zon_datecreated', date('Y-m-d H:i:s'));
			$this->db->set('zon_ispublished', 1);
			$this->db->insert('zon');
			$zon_id = $this->db->insert_id();

			foreach($data['translations'] as $trl) {
				$this->db->set('trl_zon_title', $this->input->post('title'.$trl->lng_id));
				$this->db->set('zon_id', $zon_id);
				$this->db->set('lng_id', $trl->lng_id);
				$this->db->insert('trl_zon');
			}

			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read() {
		if($this->zon_id != 0) {
			$data = array();
			$data['zon'] = $this->zones_model->get_zone($this->zon_id);
			$data['translations'] = $this->zones_model->get_translations($this->zon_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/zones/zones_read', $data, true);
		}
	}
	public function update() {
		if($this->zon_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['zon'] = $this->zones_model->get_zone($this->zon_id);
			$data['select_layout'] = $this->zones_model->select_layout();
			$data['translations'] = $this->zones_model->get_translations($this->zon_id);

			$this->form_validation->set_rules('lay_id', 'lang:lay_code', 'required');
			$this->form_validation->set_rules('zon_code', 'lang:zon_code', 'required|max_length[100]|callback_rule_zon_code['.$this->input->post('lay_id').','.$data['zon']->lay_id.','.$data['zon']->zon_code.']');
			$this->form_validation->set_rules('zon_ordering', 'lang:zon_ordering', 'required|numeric');
			foreach($data['translations'] as $trl) {
				$this->form_validation->set_rules('title'.$trl->lng_id, 'lang:trl_zon_title', 'required');
			}

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/zones/zones_update', $data, true);
			} else {
				$this->db->set('lay_id', $this->input->post('lay_id'));
				$this->db->set('zon_code', $this->input->post('zon_code'));
				$this->db->set('zon_ordering', $this->input->post('zon_ordering'));
				$this->db->set('zon_modifiedby', $this->usr->usr_id);
				$this->db->set('zon_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('zon_id', $this->zon_id);
				$this->db->update('zon');

				foreach($data['translations'] as $trl) {
					$this->db->set('trl_zon_title', $this->input->post('title'.$trl->lng_id));
					if($trl->zon_id) {
						$this->db->where('zon_id', $this->zon_id);
						$this->db->where('lng_id', $trl->lng_id);
						$this->db->update('trl_zon');
					} else {
						$this->db->set('zon_id', $this->zon_id);
						$this->db->set('lng_id', $trl->lng_id);
						$this->db->insert('trl_zon');
					}
				}

				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->zon_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['zon'] = $this->zones_model->get_zone($this->zon_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/zones/zones_delete', $data, true);
			} else {
				$this->db->where('zon_id', $this->zon_id);
				$this->db->delete('trl_zon');

				$this->db->where('zon_id', $this->zon_id);
				$this->db->where('zon_islocked', 0);
				$this->db->delete('zon');
				$this->index();
				$this->msg[] = $this->lang->line('deleted');
			}
		}
	}
}
