<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hosts_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function select_hst_trl_defaultitem() {
		$select_hst_trl_defaultitem = array();
		$select_hst_trl_defaultitem[''] = '--';
		//$this->db->cache_on();
        $query = $this->db->query('SELECT itm.itm_id, itm.itm_code AS itm_code, CONCAT(sct.sct_code, \' (\', lng.lng_code, \')\') AS optgroup FROM '.$this->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id WHERE 1 GROUP BY itm.itm_id ORDER BY sct.sct_code ASC, itm.itm_title ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				if(isset($select_hst_trl_defaultitem[$row->optgroup]) == 0) {
					$select_hst_trl_defaultitem[$row->optgroup] = array();
				}
				$select_hst_trl_defaultitem[$row->optgroup][$row->itm_id] = $row->itm_code;
			}
		}
		//$this->db->cache_off();
        return $select_hst_trl_defaultitem;
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
    function get_all_hosts($flt) {
        $query = $this->db->query('SELECT COUNT(hst.hst_id) AS count FROM '.$this->db->dbprefix('hst').' AS hst WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_hosts($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT hst.hst_id, hst.hst_code, hst.hst_url, hst.hst_environment, hst.hst_gzhandler, hst.hst_debug, hst.hst_islocked, hst.hst_ispublished, lay.lay_code FROM '.$this->db->dbprefix('hst').' AS hst LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = hst.lay_id WHERE '.implode(' AND ', $flt).' GROUP BY hst.hst_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_translations($hst_id) {
        $query = $this->db->query('SELECT hst_trl.*, lng.lng_title, lng.lng_code, lng.lng_id FROM '.$this->db->dbprefix('lng').' AS lng LEFT JOIN '.$this->db->dbprefix('hst_trl').' AS hst_trl ON hst_trl.lng_id = lng.lng_id AND hst_trl.hst_id = ?', array($hst_id));
		return $query->result();
    }
    function get_host($hst_id) {
        $query = $this->db->query('SELECT hst.*, lay.lay_code  FROM '.$this->db->dbprefix('hst').' AS hst LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = hst.lay_id WHERE hst.hst_id = ? GROUP BY hst.hst_id', array($hst_id));
        return $query->row();
    }
}
