<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class groups_items extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/groups_model', '', true);
		$this->load->model('axipi_dynamic/items_model', '', true);
	}
	public function index() {
		$this->load->helper(array('form'));

		if(isset($_SESSION['groups_items_itm_ispublished']) == 0) {
			$_SESSION['groups_items_itm_ispublished'] = '';
		}

		$filters = array();
		$filters['groups_items_itm_code'] = array('itm.itm_code', 'like');
		$filters['groups_items_itm_title'] = array('itm.itm_title', 'like');
		$filters['groups_items_sct_id'] = array('itm.sct_id', 'equal');
		$filters['groups_items_cmp_code'] = array('cmp.cmp_code', 'like');
		$filters['groups_items_lng_id'] = array('itm.lng_id', 'equal');
		$filters['groups_items_itm_ispublished'] = array('itm.itm_ispublished', 'equal');
		$flt = build_filters($filters);
		$flt[] = 'itm.itm_access = \'groups\'';

		$columns = array();
		$columns[] = 'itm.itm_id';
		$columns[] = 'itm.itm_code';
		$columns[] = 'itm.itm_title';
		$columns[] = 'cmp.cmp_code';
		$col = build_columns('groups_items', $columns, 'itm.itm_id', 'DESC');

		$results = $this->items_model->get_all_items($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30, 'groups_items');

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->items_model->get_pagination_items($flt, $build_pagination['limit'], $build_pagination['start'], 'groups_items');
		$data['groups_saved'] = $this->groups_model->get_groups_saved_item($flt);
		$data['groups'] = $this->groups_model->get_groups_is('item');
		$data['select_section'] = $this->items_model->select_section();
		$data['select_language'] = $this->items_model->select_language();
		$data['select_ispublished'] = array(''=>'-', '0'=>$this->lang->line('reply_0'), '1'=>$this->lang->line('reply_1'));

		if($this->input->post('submit_groups')) {
			foreach($data['results'] as $result) {
				foreach($data['groups'] as $group) {
					if($result->itm_islocked == 1 && $group->grp_islocked == 1) {
					} else {
						if(isset($data['groups_saved'][$result->itm_id][$group->grp_id]) == 1 && !$this->input->post($result->itm_id.$group->grp_id)) {
							$this->db->where('itm_id', $result->itm_id);
							$this->db->where('grp_id', $group->grp_id);
							$this->db->delete('grp_itm');
							unset($data['groups_saved'][$result->itm_id][$group->grp_id]);
						} else if(isset($data['groups_saved'][$result->itm_id][$group->grp_id]) == 0 && $this->input->post($result->itm_id.$group->grp_id)) {
							$this->db->set('itm_id', $result->itm_id);
							$this->db->set('grp_id', $group->grp_id);
							$this->db->set('grp_itm_createdby', $this->usr->usr_id);
							$this->db->set('grp_itm_datecreated', date('Y-m-d H:i:s'));
							$this->db->set('grp_itm_ispublished', 1);
							$this->db->insert('grp_itm');
							$data['groups_saved'][$result->itm_id][$group->grp_id] = 1;
						}
					}
				}
			}
		}

		$this->zones['content'] = $this->load->view('axipi_dynamic/groups_items/groups_items_index', $data, true);
	}
}
