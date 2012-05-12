<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class axipi_hook {
	public function post_controller_constructor() {
		$this->CI =& get_instance();
		$this->CI->zones = array();

		$query = $this->CI->db->query('SELECT * FROM '.$this->CI->db->dbprefix('cmp').' AS cmp WHERE cmp_id = ?', array($this->CI->itm->cmp_id));
		$this->CI->cmp = $query->row();

		$query = $this->CI->db->query('SELECT * FROM '.$this->CI->db->dbprefix('lng').' AS lng WHERE lng_id = ?', array($this->CI->itm->lng_id));
		$this->CI->lng = $query->row();

		$this->CI->config->set_item('language', $this->CI->lng->lng_code);

		$query = $this->CI->db->query('SELECT * FROM '.$this->CI->db->dbprefix('sct').' AS sct LEFT JOIN '.$this->CI->db->dbprefix('sct_trl').' AS sct_trl ON sct_trl.sct_id = sct.sct_id WHERE sct.sct_id = ? AND sct_trl.lng_id = ?', array($this->CI->itm->sct_id, $this->CI->itm->lng_id));
		$this->CI->sct = $query->row();

		$query = $this->CI->db->query('SELECT * FROM '.$this->CI->db->dbprefix('hst').' AS hst WHERE hst.hst_code = ?', array($_SERVER['HTTP_HOST']));
		if($query->num_rows() > 0) {
			$this->CI->hst = $query->row();
			$this->CI->config->set_item('compress_output', tinyint2boolean($this->CI->hst->hst_gzhandler));
		} else {
			$this->CI->hst = new stdClass();
			$this->CI->hst->hst_debug = 0;
		}

		if($this->CI->itm->lay_id != '') {
			$lay_id = $this->CI->itm->lay_id;
		} elseif($this->CI->cmp->lay_id != '') {
			$lay_id = $this->CI->cmp->lay_id;
		} elseif($this->CI->hst->lay_id != '') {
			$lay_id = $this->CI->hst->lay_id;
		} else {
			$lay_id = $this->CI->sct->lay_id;
		}
		$query = $this->CI->db->query('SELECT * FROM '.$this->CI->db->dbprefix('lay').' AS lay WHERE lay_id = ?', array($lay_id));
		$this->CI->lay = $query->row();

		$this->CI->load->driver('auth', array('adapter'=>$this->CI->sct->sct_code));

		if($this->CI->auth->logged_in()) {
		} else {
			$this->CI->auth->set_user_default();
		}
		$this->CI->usr->count_groups = count($this->CI->usr->groups);

		$this->CI->itm->groups = array();
		if($this->CI->itm->itm_access == 'groups') {
			$query = $this->CI->db->query('SELECT grp_itm.grp_id, grp.grp_code FROM '.$this->CI->db->dbprefix('grp_itm').' AS grp_itm LEFT JOIN '.$this->CI->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_itm.grp_id WHERE grp_itm.itm_id = ? GROUP BY grp.grp_id', array($this->CI->itm->itm_id));
			if($query->num_rows() > 0) {
				foreach($query->result() as $row) {
					$this->CI->itm->groups[$row->grp_id] = $row->grp_code;
				}
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
			$query = $this->CI->db->query('SELECT *, cmp.cmp_code FROM '.$this->CI->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->CI->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id WHERE cmp_code = ?', array($this->CI->config->item($this->CI->http_status.'_cmp_code')));
			if($query->num_rows() > 0) {
				$itm = $query->row();
				redirect($itm->itm_code);
			}
		}
		$this->CI->itm->tree = array();
		$this->CI->itm->tree[] = array('itm_id'=>$this->CI->itm->itm_id, 'itm_code'=>$this->CI->itm->itm_code, 'cmp_id'=>$this->CI->itm->cmp_id, 'cmp_code'=>$this->CI->cmp->cmp_code, 'itm_title'=>$this->CI->itm->itm_title);
		if($this->CI->itm->itm_parent != '') {
			$this->CI->itm->tree = array_merge($this->CI->itm->tree, $this->CI->items_model->get_tree($this->CI->itm->itm_parent));
		}
		$this->CI->tree_itm_id = array();
		foreach($this->CI->itm->tree as $k =>$v) {
			$this->CI->tree_itm_id[] = $v['itm_id'];
		}
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
		$this->CI->output->set_content_type($this->CI->lay->lay_type);
		$page = $this->CI->load->view($this->CI->lay->lay_code, $output, 'true');
	}
}
