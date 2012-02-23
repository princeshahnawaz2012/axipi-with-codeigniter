<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class countries_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_countries($flt) {
        $query = $this->db->query('SELECT COUNT(cou.cou_id) AS count FROM '.$this->db->dbprefix('cou').' AS cou WHERE '.implode(' AND ', $flt));
        return $query->result();
    }
    function get_pagination_countries($flt, $num, $offset) {
        $query = $this->db->query('SELECT cou.cou_id, cou.cou_alpha2, cou.cou_alpha3, cou.cou_islocked, cou.cou_ispublished, COUNT(DISTINCT(itm.itm_id)) AS count_items, COUNT(DISTINCT(usr.usr_id)) AS count_users FROM '.$this->db->dbprefix('cou').' AS cou LEFT JOIN '.$this->db->dbprefix('itm').' AS itm ON itm.cou_id = cou.cou_id LEFT JOIN '.$this->db->dbprefix('usr').' AS usr ON usr.cou_id = cou.cou_id WHERE '.implode(' AND ', $flt).' GROUP BY cou.cou_id ORDER BY cou.cou_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_country($cou_id) {
        $query = $this->db->query('SELECT cou.* FROM '.$this->db->dbprefix('cou').' AS cou WHERE cou.cou_id = ? GROUP BY cou.cou_id', array($cou_id));
        return $query->result();
    }
}
