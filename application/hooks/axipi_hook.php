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
		$output['zones']['pagesidebar'] = '';
		$query = $this->CI->db->query('SELECT itm.itm_id, itm.itm_code, itm.itm_title, itm.itm_ispublished, itm.itm_islocked, itm.itm_access, cmp.cmp_code, sct.sct_code, lng.lng_code FROM '.$this->CI->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->CI->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN '.$this->CI->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->CI->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id LEFT JOIN '.$this->CI->db->dbprefix('grp_itm').' AS grp_itm ON grp_itm.itm_id = itm.itm_id LEFT JOIN '.$this->CI->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_itm.grp_id LEFT JOIN '.$this->CI->db->dbprefix('itm').' AS items ON items.itm_parent = itm.itm_id WHERE cmp.cmp_iselement = \'1\' GROUP BY itm.itm_id');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				echo $row->cmp_code.' / '.$row->itm_code.'<br />';
				list($directory, $class) = explode('/', $row->cmp_code);
				if(file_exists(APPPATH.'widgets/'.$row->cmp_code.EXT)) {
					require_once APPPATH.'widgets/'.$row->cmp_code.EXT;
					$widget = new $class();
					foreach(get_object_vars($this->CI) as $key => $object) {
						$widget->$key =& $this->CI->$key;
					}
					$output['zones']['pagesidebar'] .= $widget->index();
				}
			}
		} 

		$page = $this->CI->load->view($this->CI->lay[0]->lay_code, $output, 'true');
	}
}
