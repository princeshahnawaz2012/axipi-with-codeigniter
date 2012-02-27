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
		$filters['permissions_per_code'] = array('per.per_code', 'like');
		$flt = build_filters($filters);

		$results = $this->permissions_model->get_all_permissions($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->permissions_model->get_pagination_permissions($flt, $build_pagination['limit'], $build_pagination['start']);
		$data['groups'] = $this->groups_model->get_groups_is('permission');
		$this->zones['content'] = $this->load->view('axipi_dynamic/groups_permissions/groups_permissions_index', $data, true);
	}
}
