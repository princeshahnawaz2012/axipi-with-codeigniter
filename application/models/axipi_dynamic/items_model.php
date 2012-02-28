<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class items_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
	function get_tree($itm_id) {
		$tree = array();
		$query = $this->db->query('SELECT itm.*, cmp.cmp_code, sct.sct_code, lng.lng_code, COUNT(DISTINCT(items.itm_id)) AS count_items FROM '.$this->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id LEFT JOIN itm AS items ON items.itm_parent = itm.itm_id WHERE itm.itm_id = ? GROUP BY itm.itm_id', array($itm_id));
		$itm = $query->row();
		
		$tree[] = array('itm_id'=>$itm->itm_id, 'itm_code'=>$itm->itm_code, 'cmp_id'=>$itm->cmp_id, 'itm_title'=>$itm->itm_title);
		if($itm->itm_parent != '') {
			$tree = array_merge($tree, $this->get_tree($itm->itm_parent));
		}
		return $tree;
	}
    function select_item_parent() {
		$select_item_parent = array();
		$select_item_parent[''] = '--';
		//$this->db->cache_on();
        $query = $this->db->query('SELECT itm.itm_id, itm.itm_code AS itm_code, CONCAT(sct.sct_code, \' (\', lng.lng_code, \')\') AS optgroup FROM '.$this->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id WHERE 1 GROUP BY itm.itm_id ORDER BY sct.sct_code ASC, itm.itm_title ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				if(isset($select_item_parent[$row->optgroup]) == 0) {
					$select_item_parent[$row->optgroup] = array();
				}
				$select_item_parent[$row->optgroup][$row->itm_id] = $row->itm_code;
			}
		}
		//$this->db->cache_off();
        return $select_item_parent;
    }
    function select_component() {
		$select_component = array();
		$select_component[''] = '--';
		$this->db->cache_on();
        $query = $this->db->query('SELECT cmp.cmp_id, SUBSTRING(cmp.cmp_code, LOCATE(\'/\', cmp.cmp_code) + 1) AS cmp_code, SUBSTRING(cmp.cmp_code, 1, LOCATE(\'/\', cmp.cmp_code) - 1) AS optgroup FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE 1 GROUP BY cmp.cmp_id ORDER BY cmp.cmp_code ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				if(isset($select_component[$row->optgroup]) == 0) {
					$select_component[$row->optgroup] = array();
				}
				$select_component[$row->optgroup][$row->cmp_id] = $row->cmp_code;
			}
		}
		$this->db->cache_off();
        return $select_component;
    }
    function select_section() {
		$select_section = array();
		$select_section[''] = '--';
		$this->db->cache_on();
        $query = $this->db->query('SELECT sct.sct_id, CONCAT(sct_trl.sct_trl_title, \' (\', sct.sct_code, \')\') AS sct_title FROM '.$this->db->dbprefix('sct').' AS sct LEFT JOIN '.$this->db->dbprefix('sct_trl').' AS sct_trl ON sct_trl.sct_id = sct.sct_id WHERE sct_trl.lng_id = \''.$this->lng->lng_id.'\' GROUP BY sct.sct_id ORDER BY sct.sct_code ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select_section[$row->sct_id] = $row->sct_title;
			}
		}
		$this->db->cache_off();
        return $select_section;
    }
    function select_language() {
		$select_language = array();
		$select_language[''] = '--';
		$this->db->cache_on();
        $query = $this->db->query('SELECT lng.lng_id, CONCAT(lng.lng_title, \' (\', lng.lng_code, \')\') AS lng_title FROM '.$this->db->dbprefix('lng').' AS lng WHERE 1 GROUP BY lng.lng_id ORDER BY lng.lng_code ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select_language[$row->lng_id] = $row->lng_title;
			}
		}
		$this->db->cache_off();
        return $select_language;
    }
    function select_layout() {
		$select_layout = array();
		$select_layout[''] = '--';
		$this->db->cache_on();
        $query = $this->db->query('SELECT lay.lay_id, lay.lay_code FROM '.$this->db->dbprefix('lay').' AS lay WHERE 1 GROUP BY lay.lay_id ORDER BY lay.lay_code ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select_layout[$row->lay_id] = $row->lay_code;
			}
		}
		$this->db->cache_off();
        return $select_layout;
    }
    function get_all_items($flt) {
        $query = $this->db->query('SELECT COUNT(itm.itm_id) AS count FROM '.$this->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_items($flt, $num, $offset) {
        $query = $this->db->query('SELECT itm.itm_id, itm.itm_code, itm.itm_title, itm.itm_ispublished, itm.itm_islocked, itm.itm_access, cmp.cmp_code, sct.sct_code, lng.lng_code, GROUP_CONCAT(DISTINCT grp.grp_code ORDER BY grp.grp_code ASC SEPARATOR \', \') AS groups, COUNT(DISTINCT(grp_itm.grp_id)) AS count_groups, COUNT(DISTINCT(items.itm_id)) AS count_items FROM '.$this->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id LEFT JOIN '.$this->db->dbprefix('grp_itm').' AS grp_itm ON grp_itm.itm_id = itm.itm_id LEFT JOIN '.$this->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_itm.grp_id LEFT JOIN '.$this->db->dbprefix('itm').' AS items ON items.itm_parent = itm.itm_id WHERE '.implode(' AND ', $flt).' GROUP BY itm.itm_id ORDER BY itm.itm_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_item($itm_id) {
        $query = $this->db->query('SELECT itm.*, cmp.cmp_code, sct.sct_code, lng.lng_code, COUNT(DISTINCT(items.itm_id)) AS count_items FROM '.$this->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id LEFT JOIN itm AS items ON items.itm_parent = itm.itm_id WHERE itm.itm_id = ? GROUP BY itm.itm_id', array($itm_id));
		$itm = $query->row();
		list($itm->itm_publishstartdate, $itm->itm_publishstarttime) = explode(' ', $itm->itm_publishstartdate);
        return $itm;
    }
}
