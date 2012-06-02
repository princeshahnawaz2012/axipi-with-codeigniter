<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class groups extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/groups_model', '', true);
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['groups_grp_code'] = array('grp.grp_code', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'grp.grp_id';
		$columns[] = 'grp.grp_code';
		$columns[] = 'count_permissions';
		$columns[] = 'count_items';
		$columns[] = 'count_users';
		$col = build_columns('groups', $columns, 'grp.grp_id', 'DESC');

		$results = $this->groups_model->get_all_groups($flt);
		$build_pagination = $this->axipi_library->build_pagination(base_url().$this->itm->itm_code, 'groups', $results->count, 30);

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->groups_model->get_pagination_groups($flt, $build_pagination['limit'], $build_pagination['start'], 'groups');
		$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_index', $data, true);
	}
	public function rule_grp_code($grp_code, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT grp.grp_code FROM '.$this->db->dbprefix('grp').' AS grp WHERE grp.grp_code = ? AND grp.grp_code != ? GROUP BY grp.grp_id', array($grp_code, $current));
		} else {
			$query = $this->db->query('SELECT grp.grp_code FROM '.$this->db->dbprefix('grp').' AS grp WHERE grp.grp_code = ? GROUP BY grp.grp_id', array($grp_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_grp_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['translations'] = $this->groups_model->get_translations(0);

		$this->form_validation->set_rules('grp_code', 'lang:grp_code', 'required|max_length[100]|callback_rule_grp_code');
		$this->form_validation->set_rules('grp_isitem', 'lang:grp_isitem');
		$this->form_validation->set_rules('grp_isuser', 'lang:grp_isuser');
		$this->form_validation->set_rules('grp_ispermission', 'lang:grp_ispermission');
		foreach($data['translations'] as $trl) {
			$this->form_validation->set_rules('title'.$trl->lng_id, $this->lang->line('grp_trl_title').' ('.$trl->lng_code.')', 'required');
		}

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_create', $data, true);
		} else {
			$this->db->set('grp_code', $this->input->post('grp_code'));
			$this->db->set('grp_isitem', checkbox2database($this->input->post('grp_isitem')));
			$this->db->set('grp_isuser', checkbox2database($this->input->post('grp_isuser')));
			$this->db->set('grp_ispermission', checkbox2database($this->input->post('grp_ispermission')));
			$this->db->set('grp_createdby', $this->usr->usr_id);
			$this->db->set('grp_datecreated', date('Y-m-d H:i:s'));
			$this->db->set('grp_ispublished', 1);
			$this->db->insert('grp');
			$grp_id = $this->db->insert_id();

			foreach($data['translations'] as $trl) {
				$this->db->set('grp_trl_title', $this->input->post('title'.$trl->lng_id));
				$this->db->set('grp_id', $grp_id);
				$this->db->set('lng_id', $trl->lng_id);
				$this->db->insert('grp_trl');
			}

			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read($grp_id) {
		$data = array();
		$data['grp'] = $this->groups_model->get_group($grp_id);
		if($data['grp']) {
			$data['translations'] = $this->groups_model->get_translations($grp_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_read', $data, true);
		} else {
			$this->index();
		}
	}
	public function update($grp_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['grp'] = $this->groups_model->get_group($grp_id);
		if($data['grp']) {
			$data['translations'] = $this->groups_model->get_translations($grp_id);

			$this->form_validation->set_rules('grp_code', 'lang:grp_code', 'required|max_length[100]|callback_rule_grp_code['.$data['grp']->grp_code.']');
			$this->form_validation->set_rules('grp_isitem', 'lang:grp_isitem');
			$this->form_validation->set_rules('grp_isuser', 'lang:grp_isuser');
			$this->form_validation->set_rules('grp_ispermission', 'lang:grp_ispermission');
			foreach($data['translations'] as $trl) {
				$this->form_validation->set_rules('title'.$trl->lng_id, $this->lang->line('grp_trl_title').' ('.$trl->lng_code.')', 'required');
			}

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_update', $data, true);
			} else {
				$this->db->set('grp_code', $this->input->post('grp_code'));
				$this->db->set('grp_isitem', checkbox2database($this->input->post('grp_isitem')));
				$this->db->set('grp_isuser', checkbox2database($this->input->post('grp_isuser')));
				$this->db->set('grp_ispermission', checkbox2database($this->input->post('grp_ispermission')));
				$this->db->set('grp_modifiedby', $this->usr->usr_id);
				$this->db->set('grp_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('grp_id', $grp_id);
				$this->db->update('grp');

				foreach($data['translations'] as $trl) {
					$this->db->set('grp_trl_title', $this->input->post('title'.$trl->lng_id));
					if($trl->grp_id) {
						$this->db->where('grp_id', $grp_id);
						$this->db->where('lng_id', $trl->lng_id);
						$this->db->update('grp_trl');
					} else {
						$this->db->set('grp_id', $grp_id);
						$this->db->set('lng_id', $trl->lng_id);
						$this->db->insert('grp_trl');
					}
				}

				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function delete($grp_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['grp'] = $this->groups_model->get_group($grp_id);
		if($data['grp']) {
			if($data['grp']->grp_islocked == 0) {
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
	
				if($this->form_validation->run() == FALSE) {
					$this->zones['content'] = $this->load->view('axipi_dynamic/groups/groups_delete', $data, true);
				} else {
					$this->db->where('grp_id', $grp_id);
					$this->db->delete('grp_itm');
	
					$this->db->where('grp_id', $grp_id);
					$this->db->delete('grp_trl');
	
					$this->db->where('grp_id', $grp_id);
					$this->db->where('grp_per_islocked', 0);
					$this->db->delete('grp_per');
	
					$this->db->where('grp_id', $grp_id);
					$this->db->where('grp_usr_islocked', 0);
					$this->db->delete('grp_usr');
	
					$this->db->where('grp_id', $grp_id);
					$this->db->where('grp_islocked', 0);
					$this->db->delete('grp');
					$this->msg[] = $this->lang->line('deleted');
					$this->index();
				}
			} else {
				$this->index();
			}
		}
	}
}
