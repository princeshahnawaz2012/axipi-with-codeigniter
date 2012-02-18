<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
	public function index() {
		if(!$this->uri->uri_string()) {
			$page = 'axipi';
		} else {
			$page = $this->uri->uri_string();
		}
		$query = $this->db->query('SELECT * FROM itm WHERE itm_code = ?', array($page));
		if($query->num_rows() > 0) {
			$this->itm = $query->result();
	
			$query = $this->db->query('SELECT * FROM cmp WHERE cmp_id = ?', array($this->itm[0]->cmp_id));
			$this->cmp = $query->result();
	
			$query = $this->db->query('SELECT * FROM sct WHERE sct_id = ?', array($this->itm[0]->sct_id));
			$this->sct = $query->result();
	
			$query = $this->db->query('SELECT * FROM lay WHERE lay_id = ?', array($this->sct[0]->lay_id));
			$this->lay = $query->result();
	
			require_once(APPPATH.'controllers/'.$this->cmp[0]->cmp_code.'.php');
			$controller = new Axipi_controller();
			if($this->input->get('a') && method_exists($controller, $this->input->get('a')) && $this->input->get('a') != 'index') {
				$controller->{$this->input->get('a')}();
			} else {
				$controller->index();
			}
		} else {
			$this->zones['content'] = $this->load->view('welcome_index', null, true);
		}
	}
}
