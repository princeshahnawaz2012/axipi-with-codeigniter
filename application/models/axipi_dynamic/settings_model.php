<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class settings_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_settings($flt) {
        $query = $this->db->query('SELECT COUNT(stg.stg_id) AS count FROM '.$this->db->dbprefix('stg').' AS stg WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_settings($flt, $num, $offset) {
        $query = $this->db->query('SELECT stg.stg_id, stg.stg_code, stg.stg_value, stg.stg_islocked, stg.stg_ispublished FROM '.$this->db->dbprefix('stg').' AS stg WHERE '.implode(' AND ', $flt).' GROUP BY stg.stg_id ORDER BY stg.stg_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_setting($stg_id) {
        $query = $this->db->query('SELECT stg.* FROM '.$this->db->dbprefix('stg').' AS stg WHERE stg.stg_id = ? GROUP BY stg.stg_id', array($stg_id));
        return $query->row();
    }
}
