<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_widget {
	public function index() {
		return $this->load->view('axipi_core/menu_widget', null, true);
	}
}
