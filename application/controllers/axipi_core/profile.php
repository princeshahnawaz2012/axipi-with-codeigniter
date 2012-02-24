<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profile extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->zones['content'] = $this->load->view('axipi_core/profile_index', null, true);
	}
}
