<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class axipi_hook {
	public function post_controller_constructor() {
		$this->CI =& get_instance();
		if($this->CI->session->userdata('usr_id')) {
			$this->CI->usr = $this->CI->users_model->get_user($this->CI->session->userdata('usr_id'));
		}
		$this->CI->http_status = 200;
		$now = date('Y-m-d H:i:s');
		if($this->CI->itm[0]->itm_publishstartdate > $now) {
			$this->hst->v['http_status'] = 404;
		} elseif($this->CI->itm[0]->itm_publishenddate != '' && $this->CI->itm[0]->itm_publishenddate < $now) {
			$this->hst->v['http_status'] = 404;
		} elseif($this->CI->itm[0]->itm_access == 'guest' && $this->CI->usr[0]->usr_access == 'connected') {
			$this->CI->http_status = 403;
		} elseif($this->CI->itm[0]->itm_access == 'connected' && $this->CI->usr[0]->usr_access == 'guest') {
			$this->CI->http_status = 403;
		}
		if($this->CI->http_status != 200) {
			$query = $this->CI->db->query('SELECT * FROM '.$this->CI->db->dbprefix('cmp').' AS cmp WHERE cmp_code = ?', array('axipi_core/error'.$this->CI->http_status));
			if($query->num_rows() > 0) {
				$cmp = $query->result();
				$query = $this->CI->db->query('SELECT * FROM '.$this->CI->db->dbprefix('itm').' AS itm WHERE cmp_id = ?', array($cmp[0]->cmp_id));
				if($query->num_rows() > 0) {
					$itm = $query->result();
					redirect($itm[0]->itm_code);
				}
			}
		}
		$this->CI->output->set_content_type($this->CI->lay[0]->lay_type);
	}
	public function post_controller() {
		$this->CI =& get_instance();
		$output = array();
		$output['zones'] = $this->CI->zones;
		$page = $this->CI->load->view($this->CI->lay[0]->lay_code, $output, 'true');
	}
}
