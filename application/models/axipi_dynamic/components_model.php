<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class components_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function select_layout() {
		$select_layout = array();
		$select_layout[''] = '--';
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
    function get_all_components($flt) {
        $query = $this->db->query('SELECT COUNT(cmp.cmp_id) AS count FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_components($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT cmp.cmp_id, cmp.cmp_code, cmp.cmp_ispage, cmp.cmp_iselement, cmp.cmp_isrelation, lay.lay_code, cmp.cmp_islocked, cmp.cmp_ispublished, COUNT(DISTINCT(items.itm_id)) AS count_items FROM '.$this->db->dbprefix('cmp').' AS cmp LEFT JOIN '.$this->db->dbprefix('itm').' AS items ON items.cmp_id = cmp.cmp_id LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = cmp.lay_id WHERE '.implode(' AND ', $flt).' GROUP BY cmp.cmp_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_component($cmp_id) {
        $query = $this->db->query('SELECT cmp.* FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE cmp.cmp_id = ? GROUP BY cmp.cmp_id', array($cmp_id));
        return $query->row();
    }
}
