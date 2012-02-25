<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class watchdog_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_watchdog($flt) {
        $query = $this->db->query('SELECT COUNT(wtd.wtd_id) AS count FROM '.$this->db->dbprefix('wtd').' AS wtd WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_watchdog($flt, $num, $offset) {
        $query = $this->db->query('SELECT wtd.* FROM '.$this->db->dbprefix('wtd').' AS wtd WHERE '.implode(' AND ', $flt).' GROUP BY wtd.wtd_id ORDER BY wtd.wtd_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
}
