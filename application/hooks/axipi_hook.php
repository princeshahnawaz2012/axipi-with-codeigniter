<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Axipi_hook {
    function __construct() {
		$this->CI =& get_instance();
    }
	public function Output() {
		$output = array();
		$output['zones'] = $this->CI->zones;
		$page = $this->CI->load->view('layouts/'.$this->CI->lay[0]->lay_code, $output, 'true');
	}
}
