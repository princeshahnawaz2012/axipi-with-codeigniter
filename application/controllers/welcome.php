<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
    function __construct() {
        parent::__construct();
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set('Etc/UCT');
		}
    }
	public function index() {
		if(!$this->uri->uri_string()) {
			$page = 'axipi';
		} else {
			$page = $this->uri->uri_string();
		}
		$query = $this->db->query('SELECT * FROM '.$this->db->dbprefix('itm').' AS itm WHERE itm_code = ?', array($page));
		if($query->num_rows() > 0) {
			$this->itm = $query->result();
	
			$query = $this->db->query('SELECT * FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE cmp_id = ?', array($this->itm[0]->cmp_id));
			$this->cmp = $query->result();

			$query = $this->db->query('SELECT * FROM '.$this->db->dbprefix('lng').' AS lng WHERE lng_id = ?', array($this->itm[0]->lng_id));
			$this->lng = $query->result();
	
			$query = $this->db->query('SELECT * FROM '.$this->db->dbprefix('sct').' AS sct WHERE sct_id = ?', array($this->itm[0]->sct_id));
			$this->sct = $query->result();
	
			$query = $this->db->query('SELECT * FROM '.$this->db->dbprefix('lay').' AS lay WHERE lay_id = ?', array($this->sct[0]->lay_id));
			$this->lay = $query->result();
	
			require_once(APPPATH.'controllers/'.$this->cmp[0]->cmp_code.'.php');
			$this->controller = new Axipi_controller();
			$this->controller->itm = $this->itm;
			$this->controller->cmp = $this->cmp;
			$this->controller->lng = $this->lng;
			$this->controller->sct = $this->sct;
			$this->controller->lay = $this->lay;
			if($this->input->get('a') && method_exists($controller, $this->input->get('a')) && $this->input->get('a') != 'index') {
				$this->controller->{$this->input->get('a')}();
			} else {
				$this->controller->index();
			}
		} else {
			$this->zones['content'] = $this->load->view('welcome_index', null, true);
		}
	}
}
