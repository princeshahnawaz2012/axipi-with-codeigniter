<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class error403 extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->output->set_status_header(404);
		$this->zones['content'] = '<p>403</p>';
	}
}
