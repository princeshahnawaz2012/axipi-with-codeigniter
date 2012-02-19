<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'lang:usr_email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'lang:usr_plainpassword', 'required');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_core/login_index', null, true);
		} else {
		}
	}
}
