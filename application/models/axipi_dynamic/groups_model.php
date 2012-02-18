<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class groups_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_projects() {
        $query = $this->db->query('SELECT COUNT(pro.pro_id) AS count FROM projects AS pro WHERE 1');
        return $query->result();
    }
    function get_pagination_projects($num, $offset) {
        $query = $this->db->query('SELECT pro.* FROM projects AS pro WHERE 1 GROUP BY pro.pro_id LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_group($grp_id) {
        $query = $this->db->query('SELECT grp.* FROM grp grp WHERE grp.grp_id = ? GROUP BY grp.grp_id', array($grp_id));
        return $query->result();
    }
}
