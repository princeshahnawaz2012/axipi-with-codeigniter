<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class axipi_hook {
	public function post_controller_constructor() {
		$this->CI =& get_instance();
		if($this->CI->session->userdata('usr_id')) {
			$this->CI->usr = $this->CI->users_model->get_user($this->CI->session->userdata('usr_id'));
			$this->CI->usr->usr_access = 'connected';
			$this->CI->usr->groups = $this->CI->users_model->get_groups($this->CI->session->userdata('usr_id'));
			$this->CI->usr->groups[1002] = 'connected';
		} else {
			$this->CI->usr = array();
			$this->CI->usr[0] = new stdClass();
			$this->CI->usr->usr_id = 0;
			$this->CI->usr->usr_access = 'guest';
			$this->CI->usr->groups[1001] = 'guest';
		}
		$this->CI->usr->count_groups = count($this->CI->usr->groups);

		$this->CI->itm->groups = array();
        $query = $this->CI->db->query('SELECT grp_itm.grp_id, grp.grp_code FROM '.$this->CI->db->dbprefix('grp_itm').' AS grp_itm LEFT JOIN '.$this->CI->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_itm.grp_id WHERE grp_itm.itm_id = ? GROUP BY grp.grp_id', array($this->CI->itm->itm_id));
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$this->CI->itm->groups[$row->grp_id] = $row->grp_code;
			}
		}
		$this->CI->itm->count_groups = count($this->CI->itm->groups);

		$this->CI->http_status = 200;
		$now = date('Y-m-d H:i:s');
		if($this->CI->itm->itm_publishstartdate > $now) {
			$this->CI->http_status = 404;
		} elseif($this->CI->itm->itm_publishenddate != '' && $this->CI->itm->itm_publishenddate < $now) {
			$this->CI->http_status = 404;
		} elseif($this->CI->itm->itm_access == 'guest' && $this->CI->usr->usr_access == 'connected') {
			$this->CI->http_status = 403;
		} elseif($this->CI->itm->itm_access == 'connected' && $this->CI->usr->usr_access == 'guest') {
			$this->CI->http_status = 403;
		} elseif($this->CI->itm->itm_access == 'groups') {
			if($this->CI->usr->count_groups == 0 || $this->CI->itm->count_groups == 0) {
				$this->CI->http_status = 403;
			} else {
				$diff_rights = array_intersect($this->CI->itm->groups, $this->CI->usr->groups);
				$diff_rights_total = count($diff_rights);
				if($diff_rights_total == 0) {
					$this->CI->http_status = 403;
				}
				unset($diff_rights);
			}
		}

		if($this->CI->http_status != 200) {
			$query = $this->CI->db->query('SELECT * FROM '.$this->CI->db->dbprefix('cmp').' AS cmp WHERE cmp_code = ?', array('axipi_core/error'.$this->CI->http_status));
			if($query->num_rows() > 0) {
				$cmp = $query->row();
				$query = $this->CI->db->query('SELECT * FROM '.$this->CI->db->dbprefix('itm').' AS itm WHERE cmp_id = ?', array($cmp->cmp_id));
				if($query->num_rows() > 0) {
					$itm = $query->row();
					redirect($itm->itm_code);
				}
			}
		}
		$this->CI->output->set_content_type($this->CI->lay->lay_type);
	}
	public function post_controller() {
		$this->CI =& get_instance();
		$output = array();
		$output['zones'] = $this->CI->zones;
		$query = $this->CI->db->query('SELECT zon_code, COUNT(DISTINCT(itm_stg.stg_id)) AS count_stg, itm_link AS link, cmp_code, itm.itm_id AS id, itm_content AS content, itm_code AS code, itm_virtualcode AS virtualcode, itm_parent AS parent, itm_title AS title FROM '.$this->CI->db->dbprefix('itm_zon').' itm_zon LEFT JOIN '.$this->CI->db->dbprefix('itm').' itm ON itm.itm_id = itm_zon.itm_id LEFT JOIN '.$this->CI->db->dbprefix('cmp').' cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN '.$this->CI->db->dbprefix('zon').' zon ON zon.zon_id = itm_zon.zon_id LEFT JOIN '.$this->CI->db->dbprefix('grp_itm').' grp_itm ON grp_itm.itm_id = itm.itm_id AND grp_itm_ispublished = \'1\' LEFT JOIN '.$this->CI->db->dbprefix('itm_stg').' itm_stg ON itm_stg.itm_id = itm.itm_id WHERE itm.itm_publishstartdate <= \''.date('Y-m-d H:i:s').'\' AND IF(itm.itm_publishenddate IS NOT NULL, itm.itm_publishenddate >= \''.date('Y-m-d H:i:s').'\', \'1\') AND cmp_iselement = \'1\' AND itm.lng_id = \''.$this->CI->lng->lng_id.'\' AND zon.lay_id = \''.$this->CI->lay->lay_id.'\' AND zon_ispublished = \'1\' AND itm_zon_ispublished = \'1\' AND itm_ispublished = \'1\' AND (itm.itm_access = \'all\' OR (itm.itm_access = \'createdby\' AND itm.itm_createdby = \''.$this->CI->usr->usr_id.'\') OR itm.itm_access = \''.$this->CI->usr->usr_access.'\' OR (itm.itm_access = \'groups\' AND grp_itm.grp_id IN ('.implode(', ', array_keys($this->CI->usr->groups)).'))) GROUP BY itm_zon.zon_id, itm_zon.itm_id ORDER BY itm_zon_ordering ASC, itm_title ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				list($directory, $class) = explode('/', $row->cmp_code);
				if(file_exists(APPPATH.'widgets/'.$row->cmp_code.EXT)) {
					require_once APPPATH.'widgets/'.$row->cmp_code.EXT;
					$widget = new $class();
					$widget->data = $row;
					foreach(get_object_vars($this->CI) as $key => $object) {
						$widget->$key =& $this->CI->$key;
					}
					if(isset($output['zones'][$row->zon_code]) == 0) {
						$output['zones'][$row->zon_code] = '';
					}
					$output['zones'][$row->zon_code] .= $widget->index();
				}
			}
		} 

		$page = $this->CI->load->view($this->CI->lay->lay_code, $output, 'true');
	}
}
