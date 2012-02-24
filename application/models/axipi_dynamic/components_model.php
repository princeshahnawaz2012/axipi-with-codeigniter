<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class components_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_components($flt) {
        $query = $this->db->query('SELECT COUNT(cmp.cmp_id) AS count FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_components($flt, $num, $offset) {
        $query = $this->db->query('SELECT cmp.cmp_id, cmp.cmp_code, cmp.cmp_islocked, cmp.cmp_ispublished, COUNT(DISTINCT(items.itm_id)) AS count_items FROM '.$this->db->dbprefix('cmp').' AS cmp LEFT JOIN '.$this->db->dbprefix('itm').' AS items ON items.cmp_id = cmp.cmp_id WHERE '.implode(' AND ', $flt).' GROUP BY cmp.cmp_id ORDER BY cmp.cmp_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_component($cmp_id) {
        $query = $this->db->query('SELECT cmp.* FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE cmp.cmp_id = ? GROUP BY cmp.cmp_id', array($cmp_id));
        return $query->row();
    }
}
