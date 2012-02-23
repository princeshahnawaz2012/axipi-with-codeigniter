<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class layouts_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_layouts($flt) {
        $query = $this->db->query('SELECT COUNT(lay.lay_id) AS count FROM '.$this->db->dbprefix('lay').' AS lay WHERE '.implode(' AND ', $flt));
        return $query->result();
    }
    function get_pagination_layouts($flt, $num, $offset) {
        $query = $this->db->query('SELECT lay.lay_id, lay.lay_code, lay.lay_type, lay.lay_islocked, lay.lay_ispublished, COUNT(DISTINCT(sct.sct_id)) AS count_sections FROM '.$this->db->dbprefix('lay').' AS lay LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.lay_id = lay.lay_id WHERE '.implode(' AND ', $flt).' GROUP BY lay.lay_id ORDER BY lay.lay_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_layout($lay_id) {
        $query = $this->db->query('SELECT lay.* FROM '.$this->db->dbprefix('lay').' AS lay WHERE lay.lay_id = ? GROUP BY lay.lay_id', array($lay_id));
        return $query->result();
    }
}
