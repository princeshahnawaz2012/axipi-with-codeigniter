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
		$build_pagination = $this->axipi_library->build_pagination(base_url().$this->itm->itm_code, 'watchdog', $results->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->watchdog_model->get_pagination_watchdog($flt, $build_pagination['limit'], $build_pagination['start']);
		$this->zones['content'] = $this->load->view('axipi_dynamic/watchdog/watchdog_index', $data, true);
	}
	public function purge() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
		$this->form_validation->set_rules('days', 'lang:days', 'required|numeric');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/watchdog/watchdog_purge', $data, true);
		} else {
			$time = date('U')-(60*60*24*$this->input->post('days'));
			$days = date('Y-m-d H:i:s', $time);
			$this->db->where('wtd_datecreated <=', $days);
			$this->db->delete('wtd');
			$this->index();
			$this->msg[] = $this->lang->line('purged');
		}
	}
}
