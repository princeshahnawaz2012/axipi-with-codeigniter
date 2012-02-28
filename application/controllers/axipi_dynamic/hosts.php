<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hosts extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/hosts_model', '', true);

		if($this->input->get('hst_id')) {
			$this->hst_id = $this->input->get('hst_id');
		} else {
			$this->hst_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['hosts_hst_code'] = array('hst.hst_code', 'like');
		$flt = build_filters($filters);

		$results = $this->hosts_model->get_all_hosts($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->hosts_model->get_pagination_hosts($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/hosts/hosts_index', $data, true);
	}
	public function rule_hst_code($hst_code, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT hst.hst_code FROM '.$this->db->dbprefix('hst').' AS hst WHERE hst.hst_code = ? AND hst.hst_code != ? GROUP BY hst.hst_id', array($hst_code, $current));
		} else {
			$query = $this->db->query('SELECT hst.hst_code FROM '.$this->db->dbprefix('hst').' AS hst WHERE hst.hst_code = ? GROUP BY hst.hst_id', array($hst_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_hst_code', $this->lang->line('value_already_used'));
			$this->form_validation->set_rules('hst_url', 'lang:hst_url', 'max_length[255]');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['select_layout'] = $this->hosts_model->select_layout();
		$data['select_hst_trl_defaultitem'] = $this->hosts_model->select_hst_trl_defaultitem();
		$data['translations'] = $this->hosts_model->get_translations($this->hst_id);

		$this->form_validation->set_rules('hst_code', 'lang:hst_code', 'required|max_length[100]|callback_rule_hst_code');
		$this->form_validation->set_rules('hst_url', 'lang:hst_url', 'required|max_length[255]');
		$this->form_validation->set_rules('hst_environment', 'lang:hst_environment', 'max_length[100]');
		foreach($data['translations'] as $trl) {
			$this->form_validation->set_rules('defaultitem'.$trl->lng_id, 'lang:hst_trl_defaultitem', 'required');
		}

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/hosts/hosts_create', $data, true);
		} else {
			$this->db->set('lay_id', $this->input->post('lay_id'));
			$this->db->set('hst_code', $this->input->post('hst_code'));
			$this->db->set('hst_url', $this->input->post('hst_url'));
			$this->db->set('hst_debug', $this->input->post('hst_debug'));
			$this->db->set('hst_gzhandler', $this->input->post('hst_gzhandler'));
			$this->db->set('hst_environment', $this->input->post('hst_environment'));
			$this->db->set('hst_createdby', $this->usr->usr_id);
			$this->db->set('hst_datecreated', date('Y-m-d H:i:s'));
			$this->db->set('hst_ispublished', 1);
			$this->db->insert('hst');
			$hst_id = $this->db->insert_id();

			foreach($data['translations'] as $trl) {
				$this->db->set('hst_trl_defaultitem', $this->input->post('defaultitem'.$trl->lng_id));
				$this->db->set('hst_id', $hst_id);
				$this->db->set('lng_id', $trl->lng_id);
				$this->db->insert('hst_trl');
			}

			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read() {
		if($this->hst_id != 0) {
			$data = array();
			$data['hst'] = $this->hosts_model->get_host($this->hst_id);
			$data['translations'] = $this->hosts_model->get_translations($this->hst_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/hosts/hosts_read', $data, true);
		}
	}
	public function update() {
		if($this->hst_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['hst'] = $this->hosts_model->get_host($this->hst_id);
			$data['select_layout'] = $this->hosts_model->select_layout();
			$data['select_hst_trl_defaultitem'] = $this->hosts_model->select_hst_trl_defaultitem();
			$data['translations'] = $this->hosts_model->get_translations($this->hst_id);

			$this->form_validation->set_rules('hst_code', 'lang:hst_code', 'required|max_length[100]|callback_rule_hst_code['.$data['hst']->hst_code.']');
			$this->form_validation->set_rules('hst_url', 'lang:hst_url', 'required|max_length[255]');
			$this->form_validation->set_rules('hst_environment', 'lang:hst_environment', 'max_length[100]');
			foreach($data['translations'] as $trl) {
				$this->form_validation->set_rules('defaultitem'.$trl->lng_id, 'lang:hst_trl_defaultitem', 'required');
			}

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/hosts/hosts_update', $data, true);
			} else {
				$this->db->set('lay_id', $this->input->post('lay_id'));
				$this->db->set('hst_code', $this->input->post('hst_code'));
				$this->db->set('hst_url', $this->input->post('hst_url'));
				$this->db->set('hst_debug', $this->input->post('hst_debug'));
				$this->db->set('hst_gzhandler', $this->input->post('hst_gzhandler'));
				$this->db->set('hst_environment', $this->input->post('hst_environment'));
				$this->db->set('hst_modifiedby', $this->usr->usr_id);
				$this->db->set('hst_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('hst_id', $this->hst_id);
				$this->db->update('hst');

				foreach($data['translations'] as $trl) {
					if($trl->hst_id) {
						$this->db->set('hst_trl_defaultitem', $this->input->post('defaultitem'.$trl->lng_id));
						$this->db->where('hst_id', $this->hst_id);
						$this->db->where('lng_id', $trl->lng_id);
						$this->db->update('hst_trl');
					} else {
						$this->db->set('hst_trl_defaultitem', $this->input->post('defaultitem'.$trl->lng_id));
						$this->db->set('hst_id', $this->hst_id);
						$this->db->set('lng_id', $trl->lng_id);
						$this->db->insert('hst_trl');
					}
				}

				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->hst_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['hst'] = $this->hosts_model->get_host($this->hst_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/hosts/hosts_delete', $data, true);
			} else {
				$this->db->where('hst_id', $this->hst_id);
				$this->db->delete('hst_trl');

				$this->db->where('hst_id', $this->hst_id);
				$this->db->delete('hst_stg');

				$this->db->where('hst_id', $this->hst_id);
				$this->db->where('hst_islocked', 0);
				$this->db->delete('hst');
				$this->msg[] = $this->lang->line('deleted');
				$this->index();
			}
		}
	}
}
