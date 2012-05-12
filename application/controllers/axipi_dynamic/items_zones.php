<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class items_zones extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/zones_model', '', true);
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['items_zones_zon_code'] = array('zon.zon_code', 'like');
		$filters['items_zones_lay_id'] = array('zon.lay_id', 'equal');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'zon.zon_id';
		$columns[] = 'zon.zon_code';
		$columns[] = 'lay.lay_code';
		$columns[] = 'zon.zon_ordering';
		$columns[] = 'count_items';
		$col = build_columns('items_zones', $columns, 'zon.zon_ordering', 'ASC');

		$results = $this->zones_model->get_all_zones($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30, 'items_zones');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->zones_model->get_pagination_zones($flt, $build_pagination['limit'], $build_pagination['start'], 'items_zones');
		$data['items_zones'] = $this->zones_model->get_all_items_zones($flt);
		$data['select_layout'] = $this->zones_model->select_layout();
		$this->zones['content'] = $this->load->view('axipi_dynamic/items_zones/items_zones_index', $data, true);
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
	public function create($zon_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['zon'] = $this->zones_model->get_zone($zon_id);
		if($data['zon']) {
			$data['select_item'] = $this->zones_model->select_item($zon_id);
	
			$this->form_validation->set_rules('itm_id', 'lang:itm_code', 'required');
			$this->form_validation->set_rules('itm_zon_ordering', 'lang:itm_zon_ordering', 'required|numeric');
	
			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items_zones/items_zones_create', $data, true);
			} else {
				$this->db->set('zon_id', $zon_id);
				$this->db->set('itm_id', $this->input->post('itm_id'));
				$this->db->set('itm_zon_ordering', $this->input->post('itm_zon_ordering'));
				$this->db->set('itm_zon_createdby', $this->usr->usr_id);
				$this->db->set('itm_zon_datecreated', date('Y-m-d H:i:s'));
				$this->db->set('itm_zon_ispublished', 1);
				$this->db->insert('itm_zon');
	
				$this->msg[] = $this->lang->line('created');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function read($zon_id, $itm_id) {
		$data = array();
		$data['itm_zon'] = $this->zones_model->get_item_zone($zon_id, $itm_id);
		if($data['itm_zon']) {
			$data['zon'] = $this->zones_model->get_zone($zon_id);
			$data['itm'] = $this->items_model->get_item($itm_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/items_zones/items_zones_read', $data, true);
		} else {
			$this->index();
		}
	}
	public function update($zon_id, $itm_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['itm_zon'] = $this->zones_model->get_item_zone($zon_id, $itm_id);
		if($data['itm_zon']) {
			$data['zon'] = $this->zones_model->get_zone($zon_id);
			$data['itm'] = $this->items_model->get_item($itm_id);

			$this->form_validation->set_rules('itm_zon_ordering', 'lang:itm_zon_ordering', 'required|numeric');
			$this->form_validation->set_rules('itm_zon_ispublished', 'lang:itm_zon_ispublished');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items_zones/items_zones_update', $data, true);
			} else {
				$this->db->set('itm_zon_ordering', $this->input->post('itm_zon_ordering'));
				$this->db->set('itm_zon_ispublished', $this->input->post('itm_zon_ispublished'));
				$this->db->set('itm_zon_modifiedby', $this->usr->usr_id);
				$this->db->set('itm_zon_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('zon_id', $zon_id);
				$this->db->where('itm_id', $itm_id);
				$this->db->update('itm_zon');

				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function delete($zon_id, $itm_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['itm_zon'] = $this->zones_model->get_item_zone($zon_id, $itm_id);
		if($data['itm_zon']) {
			$data['zon'] = $this->zones_model->get_zone($zon_id);
			$data['itm'] = $this->items_model->get_item($itm_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items_zones/items_zones_delete', $data, true);
			} else {
				$this->db->where('zon_id', $zon_id);
				$this->db->where('itm_id', $itm_id);
				$this->db->delete('itm_zon');
				$this->index();
				$this->msg[] = $this->lang->line('deleted');
			}
		} else {
			$this->index();
		}
	}
}
