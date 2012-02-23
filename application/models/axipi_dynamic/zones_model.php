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
        return $query->result();
    }
    function get_pagination_zones($flt, $num, $offset) {
        $query = $this->db->query('SELECT zon.zon_id, zon.zon_code, zon.zon_ordering, zon.zon_islocked, zon.zon_ispublished, lay.lay_code, COUNT(DISTINCT(itm_zon.itm_id)) AS count_items FROM '.$this->db->dbprefix('zon').' AS zon LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = zon.lay_id LEFT JOIN '.$this->db->dbprefix('itm_zon').' AS itm_zon ON itm_zon.zon_id = zon.zon_id WHERE '.implode(' AND ', $flt).' GROUP BY zon.zon_id ORDER BY zon.zon_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_zone($zon_id) {
        $query = $this->db->query('SELECT zon.*, lay.lay_code FROM '.$this->db->dbprefix('zon').' AS zon LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = zon.lay_id WHERE zon.zon_id = ? GROUP BY zon.zon_id', array($zon_id));
        return $query->result();
    }
}
