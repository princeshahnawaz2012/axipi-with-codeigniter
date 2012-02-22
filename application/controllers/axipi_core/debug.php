<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class debug extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->zones['content'] = $this->load->view('axipi_core/debug_index', null, true);
	}
}
