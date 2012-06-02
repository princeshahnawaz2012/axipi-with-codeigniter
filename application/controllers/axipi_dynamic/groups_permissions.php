<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class groups_permissions extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/groups_model', '', true);
		$this->load->model('axipi_dynamic/permissions_model', '', true);
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['groups_permissions_per_code'] = array('per.per_code', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'per.per_id';
		$columns[] = 'per.per_code';
		$col = build_columns('groups_permissions', $columns, 'per.per_id', 'DESC');

		$results = $this->permissions_model->get_all_permissions($flt);
		$build_pagination = $this->axipi_library->build_pagination(base_url().$this->itm->itm_code, 'groups_permissions', $results->count, 30);

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->permissions_model->get_pagination_permissions($flt, $build_pagination['limit'], $build_pagination['start'], 'groups_permissions');
		$data['groups_saved'] = $this->groups_model->get_groups_saved_permission($flt);
		$data['groups'] = $this->groups_model->get_groups_is('permission');

		if($this->input->post('submit_groups')) {
			foreach($data['results'] as $result) {
				foreach($data['groups'] as $group) {
					if($result->per_islocked == 1 && $group->grp_islocked == 1) {
					} else {
						if(isset($data['groups_saved'][$result->per_id][$group->grp_id]) == 1 && !$this->input->post($result->per_id.$group->grp_id)) {
							$this->db->where('per_id', $result->per_id);
							$this->db->where('grp_id', $group->grp_id);
							$this->db->delete('grp_per');
							unset($data['groups_saved'][$result->per_id][$group->grp_id]);
						} else if(isset($data['groups_saved'][$result->per_id][$group->grp_id]) == 0 && $this->input->post($result->per_id.$group->grp_id)) {
							$this->db->set('per_id', $result->per_id);
							$this->db->set('grp_id', $group->grp_id);
							$this->db->set('grp_per_createdby', $this->usr->usr_id);
							$this->db->set('grp_per_datecreated', date('Y-m-d H:i:s'));
							$this->db->set('grp_per_ispublished', 1);
							$this->db->insert('grp_per');
							$data['groups_saved'][$result->per_id][$group->grp_id] = 1;
						}
					}
				}
			}
		}

		$this->zones['content'] = $this->load->view('axipi_dynamic/groups_permissions/groups_permissions_index', $data, true);
	}
}
