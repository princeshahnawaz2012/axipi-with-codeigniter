<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class components extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/components_model', '', true);
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['components_cmp_code'] = array('cmp.cmp_code', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'cmp.cmp_id';
		$columns[] = 'cmp.cmp_code';
		$columns[] = 'lay.lay_code';
		$columns[] = 'cmp.cmp_ispage';
		$columns[] = 'cmp.cmp_iselement';
		$columns[] = 'cmp.cmp_isrelation';
		$columns[] = 'count_items';
		$col = build_columns('components', $columns, 'cmp.cmp_id', 'DESC');

		$results = $this->components_model->get_all_components($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 50, 'components');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->components_model->get_pagination_components($flt, $build_pagination['limit'], $build_pagination['start'], 'components');
		$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_index', $data, true);
	}
	public function rule_cmp_code($cmp_code, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT cmp.cmp_code FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE cmp.cmp_code = ? AND cmp.cmp_code != ? GROUP BY cmp.cmp_id', array($cmp_code, $current));
		} else {
			$query = $this->db->query('SELECT cmp.cmp_code FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE cmp.cmp_code = ? GROUP BY cmp.cmp_id', array($cmp_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_cmp_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['select_layout'] = $this->items_model->select_layout();

		$this->form_validation->set_rules('cmp_code', 'lang:cmp_code', 'required|max_length[100]|callback_rule_cmp_code');
		$this->form_validation->set_rules('cmp_ispage', 'lang:cmp_ispage');
		$this->form_validation->set_rules('cmp_iselement', 'lang:cmp_iselement');
		$this->form_validation->set_rules('cmp_isrelation', 'lang:cmp_isrelation');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_create', $data, true);
		} else {
			$this->db->set('cmp_code', $this->input->post('cmp_code'));
			$this->db->set('lay_id', $this->input->post('lay_id'));
			$this->db->set('cmp_ispage', checkbox2database($this->input->post('cmp_ispage')));
			$this->db->set('cmp_iselement', checkbox2database($this->input->post('cmp_iselement')));
			$this->db->set('cmp_isrelation', checkbox2database($this->input->post('cmp_isrelation')));
			$this->db->set('cmp_ispublished', 1);
			$this->db->set('cmp_createdby', $this->usr->usr_id);
			$this->db->set('cmp_datecreated', date('Y-m-d H:i:s'));
			$this->db->insert('cmp');
			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read($cmp_id) {
		$data = array();
		$data['cmp'] = $this->components_model->get_component($cmp_id);
		if($data['cmp']) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_read', $data, true);
		} else {
			$this->index();
		}
	}
	public function update($cmp_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['cmp'] = $this->components_model->get_component($cmp_id);
		if($data['cmp']) {
			$data['select_layout'] = $this->items_model->select_layout();

			$this->form_validation->set_rules('cmp_code', 'lang:cmp_code', 'required|max_length[100]|callback_rule_cmp_code['.$data['cmp']->cmp_code.']');
			$this->form_validation->set_rules('cmp_ispage', 'lang:cmp_ispage');
			$this->form_validation->set_rules('cmp_iselement', 'lang:cmp_iselement');
			$this->form_validation->set_rules('cmp_isrelation', 'lang:cmp_isrelation');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_update', $data, true);
			} else {
				$this->db->set('cmp_code', $this->input->post('cmp_code'));
				$this->db->set('lay_id', $this->input->post('lay_id'));
				$this->db->set('cmp_ispage', checkbox2database($this->input->post('cmp_ispage')));
				$this->db->set('cmp_iselement', checkbox2database($this->input->post('cmp_iselement')));
				$this->db->set('cmp_isrelation', checkbox2database($this->input->post('cmp_isrelation')));
				$this->db->set('cmp_modifiedby', $this->usr->usr_id);
				$this->db->set('cmp_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('cmp_id', $cmp_id);
				$this->db->update('cmp');
				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function delete($cmp_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['cmp'] = $this->components_model->get_component($cmp_id);
		if($data['cmp']) {
			if($data['cmp']->cmp_islocked == 0) {
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

				if($this->form_validation->run() == FALSE) {
					$this->zones['content'] = $this->load->view('axipi_dynamic/components/components_delete', $data, true);
				} else {
					$this->db->where('cmp_id', $cmp_id);
					$this->db->delete('cmp_stg');

					$this->db->where('cmp_id', $cmp_id);
					$this->db->where('cmp_islocked', 0);
					$this->db->delete('cmp');
					$this->msg[] = $this->lang->line('deleted');
					$this->index();
				}
			} else {
				$this->index();
			}
		}
	}
}
