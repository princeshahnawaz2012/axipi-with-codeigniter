<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class zones_model extends CI_Model {
    function __construct() {
        parent::__construct();
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
    function get_all_zones($flt) {
        $query = $this->db->query('SELECT COUNT(zon.zon_id) AS count FROM '.$this->db->dbprefix('zon').' AS zon WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_zones($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT zon.zon_id, zon.zon_code, zon.zon_ordering, zon.zon_islocked, zon.zon_ispublished, lay.lay_code, COUNT(DISTINCT(itm_zon.itm_id)) AS count_items FROM '.$this->db->dbprefix('zon').' AS zon LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = zon.lay_id LEFT JOIN '.$this->db->dbprefix('itm_zon').' AS itm_zon ON itm_zon.zon_id = zon.zon_id WHERE '.implode(' AND ', $flt).' GROUP BY zon.zon_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_translations($zon_id) {
        $query = $this->db->query('SELECT trl_zon.*, lng.lng_title, lng.lng_code, lng.lng_id FROM '.$this->db->dbprefix('lng').' AS lng LEFT JOIN '.$this->db->dbprefix('trl_zon').' AS trl_zon ON trl_zon.lng_id = lng.lng_id AND trl_zon.zon_id = ?', array($zon_id));
		return $query->result();
    }
    function get_zone($zon_id) {
        $query = $this->db->query('SELECT zon.*, lay.lay_code FROM '.$this->db->dbprefix('zon').' AS zon LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = zon.lay_id WHERE zon.zon_id = ? GROUP BY zon.zon_id', array($zon_id));
        return $query->row();
    }
    function get_all_items_zones($flt) {
        $query = $this->db->query('SELECT itm.itm_id, itm.itm_title, zon.zon_id, itm_zon.itm_zon_ordering, itm_zon.itm_zon_ispublished, cmp.cmp_code, lng.lng_code, sct.sct_code FROM '.$this->db->dbprefix('itm_zon').' AS itm_zon LEFT JOIN '.$this->db->dbprefix('zon').' AS zon ON zon.zon_id = itm_zon.zon_id LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = zon.lay_id LEFT JOIN '.$this->db->dbprefix('itm').' AS itm ON itm.itm_id = itm_zon.itm_id LEFT JOIN '.$this->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id WHERE '.implode(' AND ', $flt).' GROUP BY itm_zon.zon_id, itm_zon.itm_id ORDER BY itm_zon.itm_zon_ordering ASC');
		$items_zones = array();
		if($query->num_rows() > 0) {
			$u = 0;
			foreach($query->result() as $row) {
				$items_zones[$row->zon_id][$u] = new stdClass();
				$items_zones[$row->zon_id][$u]->itm_id = $row->itm_id;
				$items_zones[$row->zon_id][$u]->itm_title = $row->itm_title;
				$items_zones[$row->zon_id][$u]->itm_zon_ordering = $row->itm_zon_ordering;
				$items_zones[$row->zon_id][$u]->itm_zon_ispublished = $row->itm_zon_ispublished;
				$items_zones[$row->zon_id][$u]->cmp_code = $row->cmp_code;
				$items_zones[$row->zon_id][$u]->lng_code = $row->lng_code;
				$items_zones[$row->zon_id][$u]->sct_code = $row->sct_code;
				$u++;
			}
		}
        return $items_zones;
    }
    function select_item() {
		$select_item = array();
		$select_item[''] = '--';
		//$this->db->cache_on();
        $query = $this->db->query('SELECT itm.itm_id, itm.itm_code AS itm_code, CONCAT(sct.sct_code, \' (\', lng.lng_code, \')\') AS optgroup FROM '.$this->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id WHERE cmp.cmp_iselement = \'1\' GROUP BY itm.itm_id ORDER BY sct.sct_code ASC, itm.itm_title ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				if(isset($select_item[$row->optgroup]) == 0) {
					$select_item[$row->optgroup] = array();
				}
				$select_item[$row->optgroup][$row->itm_id] = $row->itm_code;
			}
		}
		//$this->db->cache_off();
        return $select_item;
    }
    function get_item_zone($zon_id, $itm_id) {
        $query = $this->db->query('SELECT itm_zon.* FROM '.$this->db->dbprefix('itm_zon').' AS itm_zon WHERE itm_zon.zon_id = ? AND itm_zon.itm_id = ? GROUP BY itm_zon.zon_id, itm_zon.itm_id', array($zon_id, $itm_id));
		$itm_zon = $query->row();
        return $itm_zon;
    }
}
