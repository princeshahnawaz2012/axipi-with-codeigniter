<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class items_relations extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/zones_model', '', true);

		if($this->input->get('rel_id')) {
			$this->rel_id = $this->input->get('rel_id');
		} else {
			$this->rel_id = 0;
		}
		if($this->input->get('itm_id')) {
			$this->itm_id = $this->input->get('itm_id');
		} else {
			$this->itm_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['items_relations_itm_code'] = array('itm.itm_code', 'like');
		$filters['items_relations_itm_title'] = array('itm.itm_title', 'like');
		$filters['items_relations_sct_id'] = array('itm.sct_id', 'equal');
		$filters['items_relations_cmp_code'] = array('cmp.cmp_code', 'like');
		$filters['items_relations_lng_id'] = array('itm.lng_id', 'equal');
		$flt = build_filters($filters);
		$flt[] = 'cmp.cmp_isrelation = \'1\'';

		$columns = array();
		$columns[] = 'itm.itm_id';
		$columns[] = 'itm.itm_code';
		$columns[] = 'itm.itm_title';
		$columns[] = 'sct.sct_code';
		$columns[] = 'cmp.cmp_code';
		$columns[] = 'lng.lng_code';
		$columns[] = 'itm.itm_ispublished';
		$columns[] = 'itm.itm_access';
		$col = build_columns('items_relations', $columns, 'itm.itm_code', 'ASC');

		$results = $this->items_model->get_all_items($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30, 'items_relations');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->items_model->get_pagination_items($flt, $build_pagination['limit'], $build_pagination['start'], 'items_relations');
		$data['select_section'] = $this->items_model->select_section();
		$data['select_language'] = $this->items_model->select_language();
		$data['items_relations'] = $this->items_model->get_all_items_relations($flt);
		$this->zones['content'] = $this->load->view('axipi_dynamic/items_relations/items_relations_index', $data, true);
	}
	public function rule_zon_code($zon_code, $current = '') {
		if(strstr($current, ',')) {
			list($new_lay_id, $old_lay_id, $old_zon_code) = explode(',', $current);
			if($old_lay_id != $new_lay_id) {
				$query = $this->db->query('SELECT zon.zon_code FROM '.$this->db->dbprefix('zon').' AS zon WHERE zon.lay_id = ? AND zon.zon_code = ? GROUP BY zon.rel_id', array($new_lay_id, $zon_code));
			} else {
				$query = $this->db->query('SELECT zon.zon_code FROM '.$this->db->dbprefix('zon').' AS zon WHERE zon.lay_id = ? AND zon.zon_code != ? AND zon.zon_code = ? GROUP BY zon.rel_id', array($old_lay_id, $old_zon_code, $zon_code));
			}
		} else {
			$query = $this->db->query('SELECT zon.zon_code FROM '.$this->db->dbprefix('zon').' AS zon WHERE zon.lay_id = ? AND zon.zon_code = ? GROUP BY zon.rel_id', array($current, $zon_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_zon_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		if($this->rel_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['rel'] = $this->items_model->get_item($this->rel_id);
			$data['select_item'] = $this->items_model->select_item_parent();
			$data['select_item_parent'] = $this->items_model->select_item_parent();
	
			$this->form_validation->set_rules('itm_id', 'lang:itm_code', 'required');
			$this->form_validation->set_rules('itm_rel_ordering', 'lang:itm_rel_ordering', 'required|numeric');
	
			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items_relations/items_relations_create', $data, true);
			} else {
				$this->db->set('rel_id', $this->rel_id);
				$this->db->set('itm_id', $this->input->post('itm_id'));
				$this->db->set('itm_rel_parent', $this->input->post('itm_rel_parent'));
				$this->db->set('itm_rel_title', $this->input->post('itm_rel_title'));
				$this->db->set('itm_rel_ordering', $this->input->post('itm_rel_ordering'));
				$this->db->set('itm_rel_createdby', $this->usr->usr_id);
				$this->db->set('itm_rel_datecreated', date('Y-m-d H:i:s'));
				$this->db->set('itm_rel_ispublished', 1);
				$this->db->insert('itm_rel');
	
				$this->msg[] = $this->lang->line('created');
				$this->index();
			}
		}
	}
	public function read() {
		if($this->rel_id != 0 && $this->itm_id != 0) {
			$data = array();
			$data['rel'] = $this->items_model->get_item($this->rel_id);
			$data['itm'] = $this->items_model->get_item($this->itm_id);
			$data['itm_rel'] = $this->items_model->get_item_relation($this->rel_id, $this->itm_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/items_relations/items_relations_read', $data, true);
		}
	}
	public function update() {
		if($this->rel_id != 0 && $this->itm_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['rel'] = $this->items_model->get_item($this->rel_id);
			$data['itm'] = $this->items_model->get_item($this->itm_id);
			$data['itm_rel'] = $this->items_model->get_item_relation($this->rel_id, $this->itm_id);
			$data['select_item_parent'] = $this->items_model->select_item_parent();

			$this->form_validation->set_rules('itm_rel_ordering', 'lang:itm_rel_ordering', 'required|numeric');
			$this->form_validation->set_rules('itm_rel_ispublished', 'lang:itm_rel_ispublished');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items_relations/items_relations_update', $data, true);
			} else {
				$this->db->set('itm_rel_parent', $this->input->post('itm_rel_parent'));
				$this->db->set('itm_rel_title', $this->input->post('itm_rel_title'));
				$this->db->set('itm_rel_ordering', $this->input->post('itm_rel_ordering'));
				$this->db->set('itm_rel_ispublished', $this->input->post('itm_rel_ispublished'));
				$this->db->set('itm_rel_modifiedby', $this->usr->usr_id);
				$this->db->set('itm_rel_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('rel_id', $this->rel_id);
				$this->db->where('itm_id', $this->itm_id);
				$this->db->update('itm_rel');

				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->rel_id != 0 && $this->itm_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['rel'] = $this->items_model->get_item($this->rel_id);
			$data['itm'] = $this->items_model->get_item($this->itm_id);
			$data['itm_rel'] = $this->items_model->get_item_relation($this->rel_id, $this->itm_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items_relations/items_relations_delete', $data, true);
			} else {
				$this->db->where('rel_id', $this->rel_id);
				$this->db->where('itm_id', $this->itm_id);
				$this->db->delete('itm_rel');
				$this->index();
				$this->msg[] = $this->lang->line('deleted');
			}
		}
	}
}
