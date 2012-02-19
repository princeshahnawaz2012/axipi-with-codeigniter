<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class components_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_components() {
        $query = $this->db->query('SELECT COUNT(cmp.cmp_id) AS count FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE 1');
        return $query->result();
    }
    function get_pagination_components($num, $offset) {
        $query = $this->db->query('SELECT cmp.* FROM cmp AS '.$this->db->dbprefix('cmp').' AS cmp WHERE 1 GROUP BY cmp.cmp_id LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_component($cmp_id) {
        $query = $this->db->query('SELECT cmp.* FROM '.$this->db->dbprefix('cmp').' AS cmp WHERE cmp.cmp_id = ? GROUP BY cmp.cmp_id', array($cmp_id));
        return $query->result();
    }
}
