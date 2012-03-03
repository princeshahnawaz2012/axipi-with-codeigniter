<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class groups_users extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/groups_model', '', true);
		$this->load->model('axipi_dynamic/users_model', '', true);
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['groups_users_usr_email'] = array('usr.usr_email', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'usr.usr_id';
		$columns[] = 'usr.usr_email';
		$col = build_columns('groups_users', $columns, 'usr.usr_id', 'DESC');

		$results = $this->users_model->get_all_users($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30);

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->users_model->get_pagination_users($flt, $build_pagination['limit'], $build_pagination['start'], 'groups_users');
		$data['groups_saved'] = $this->groups_model->get_groups_saved_user($flt);
		$data['groups'] = $this->groups_model->get_groups_is('user');

		if($this->input->post('submit_groups')) {
			foreach($data['results'] as $result) {
				foreach($data['groups'] as $group) {
					if($result->usr_islocked == 1 && $group->grp_islocked == 1) {
					} else {
						if(isset($data['groups_saved'][$result->usr_id][$group->grp_id]) == 1 && !$this->input->post($result->usr_id.$group->grp_id)) {
							$this->db->where('usr_id', $result->usr_id);
							$this->db->where('grp_id', $group->grp_id);
							$this->db->delete('grp_usr');
							unset($data['groups_saved'][$result->usr_id][$group->grp_id]);
						} else if(isset($data['groups_saved'][$result->usr_id][$group->grp_id]) == 0 && $this->input->post($result->usr_id.$group->grp_id)) {
							$this->db->set('usr_id', $result->usr_id);
							$this->db->set('grp_id', $group->grp_id);
							$this->db->set('grp_usr_createdby', $this->usr->usr_id);
							$this->db->set('grp_usr_datecreated', date('Y-m-d H:i:s'));
							$this->db->set('grp_usr_ispublished', 1);
							$this->db->insert('grp_usr');
							$data['groups_saved'][$result->usr_id][$group->grp_id] = 1;
						}
					}
				}
			}
		}

		$this->zones['content'] = $this->load->view('axipi_dynamic/groups_users/groups_users_index', $data, true);
	}
}
