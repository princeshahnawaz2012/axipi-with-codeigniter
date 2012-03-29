<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sections_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function select_layout() {
		$select_layout = array();
		$select_layout[''] = '-';
		$this->db->cache_on();
        $query = $this->db->query('SELECT lay.lay_id, CONCAT(lay.lay_code, \' (\', lay.lay_type, \')\') AS lay_title FROM '.$this->db->dbprefix('lay').' AS lay WHERE 1 GROUP BY lay.lay_id ORDER BY lay.lay_code ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select_layout[$row->lay_id] = $row->lay_title;
			}
		}
		$this->db->cache_off();
        return $select_layout;
    }
    function get_all_sections($flt) {
        $query = $this->db->query('SELECT COUNT(sct.sct_id) AS count FROM '.$this->db->dbprefix('sct').' AS sct WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_sections($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT sct.sct_id, sct.sct_code, sct.sct_islocked, sct.sct_ispublished, lay.lay_code, COUNT(DISTINCT(items.itm_id)) AS count_items FROM '.$this->db->dbprefix('sct').' AS sct LEFT JOIN '.$this->db->dbprefix('itm').' AS items ON items.sct_id = sct.sct_id LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = sct.lay_id WHERE '.implode(' AND ', $flt).' GROUP BY sct.sct_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_translations($sct_id) {
        $query = $this->db->query('SELECT sct_trl.*, lng.lng_title, lng.lng_code, lng.lng_id FROM '.$this->db->dbprefix('lng').' AS lng LEFT JOIN '.$this->db->dbprefix('sct_trl').' AS sct_trl ON sct_trl.lng_id = lng.lng_id AND sct_trl.sct_id = ?', array($sct_id));
		return $query->result();
    }
    function get_section($sct_id) {
        $query = $this->db->query('SELECT sct.*, lay.lay_code FROM '.$this->db->dbprefix('sct').' AS sct LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = sct.lay_id WHERE sct.sct_id = ? GROUP BY sct.sct_id', array($sct_id));
        return $query->row();
    }
}
