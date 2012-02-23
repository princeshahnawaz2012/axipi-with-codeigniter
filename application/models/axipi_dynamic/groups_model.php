<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class groups_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_groups($flt) {
        $query = $this->db->query('SELECT COUNT(grp.grp_id) AS count FROM '.$this->db->dbprefix('grp').' AS grp WHERE '.implode(' AND ', $flt));
        return $query->result();
    }
    function get_pagination_groups($flt, $num, $offset) {
        $query = $this->db->query('SELECT grp.grp_id, grp.grp_code, grp.grp_islocked, grp.grp_ispublished, COUNT(DISTINCT(grp_itm.itm_id)) AS count_items, COUNT(DISTINCT(grp_usr.usr_id)) AS count_users FROM '.$this->db->dbprefix('grp').' AS grp LEFT JOIN '.$this->db->dbprefix('grp_itm').' AS grp_itm ON grp_itm.grp_id = grp.grp_id LEFT JOIN '.$this->db->dbprefix('grp_usr').' AS grp_usr ON grp_usr.grp_id = grp.grp_id WHERE '.implode(' AND ', $flt).' GROUP BY grp.grp_id ORDER BY grp.grp_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_group($grp_id) {
        $query = $this->db->query('SELECT grp.* FROM '.$this->db->dbprefix('grp').' AS grp WHERE grp.grp_id = ? GROUP BY grp.grp_id', array($grp_id));
        return $query->result();
    }
}
