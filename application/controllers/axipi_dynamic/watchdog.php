<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class watchdog extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/watchdog_model', '', true);
	}
	public function index() {
		//$this->load->helper(array('form'));

		$filters = array();
		$flt = build_filters($filters);

		$results = $this->watchdog_model->get_all_watchdog($flt);
		$build_pagination = $this->axipi_library->build_pagination($results->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->watchdog_model->get_pagination_watchdog($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/watchdog/watchdog_index', $data, true);
	}
}
