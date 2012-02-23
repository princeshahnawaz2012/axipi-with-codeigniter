<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class languages_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_languages($flt) {
        $query = $this->db->query('SELECT COUNT(lng.lng_id) AS count FROM '.$this->db->dbprefix('lng').' AS lng WHERE '.implode(' AND ', $flt));
        return $query->result();
    }
    function get_pagination_languages($flt, $num, $offset) {
        $query = $this->db->query('SELECT lng.lng_id, lng.lng_code, lng.lng_title, lng.lng_islocked, lng.lng_ispublished, COUNT(DISTINCT(itm.itm_id)) AS count_items, COUNT(DISTINCT(usr.usr_id)) AS count_users FROM '.$this->db->dbprefix('lng').' AS lng LEFT JOIN '.$this->db->dbprefix('itm').' AS itm ON itm.lng_id = lng.lng_id LEFT JOIN '.$this->db->dbprefix('usr').' AS usr ON usr.lng_id = lng.lng_id WHERE '.implode(' AND ', $flt).' GROUP BY lng.lng_id ORDER BY lng.lng_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_language($lng_id) {
        $query = $this->db->query('SELECT lng.* FROM '.$this->db->dbprefix('lng').' AS lng WHERE lng.lng_id = ? GROUP BY lng.lng_id', array($lng_id));
        return $query->result();
    }
}
