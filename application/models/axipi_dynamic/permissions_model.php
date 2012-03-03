<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class permissions_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_permissions($flt) {
        $query = $this->db->query('SELECT COUNT(per.per_id) AS count FROM '.$this->db->dbprefix('per').' AS per WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_permissions($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT per.per_id, per.per_code, per.per_islocked, per.per_ispublished, GROUP_CONCAT(DISTINCT grp.grp_code ORDER BY grp.grp_code ASC SEPARATOR \', \') AS groups, COUNT(DISTINCT(grp_per.grp_id)) AS count_groups FROM '.$this->db->dbprefix('per').' AS per LEFT JOIN '.$this->db->dbprefix('grp_per').' AS grp_per ON grp_per.per_id = per.per_id LEFT JOIN '.$this->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_per.grp_id WHERE '.implode(' AND ', $flt).' GROUP BY per.per_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_translations($per_id) {
        $query = $this->db->query('SELECT per_trl.*, lng.lng_title, lng.lng_code, lng.lng_id FROM '.$this->db->dbprefix('lng').' AS lng LEFT JOIN '.$this->db->dbprefix('per_trl').' AS per_trl ON per_trl.lng_id = lng.lng_id AND per_trl.per_id = ?', array($per_id));
		return $query->result();
    }
    function get_permission($per_id) {
        $query = $this->db->query('SELECT per.* FROM '.$this->db->dbprefix('per').' AS per WHERE per.per_id = ? GROUP BY per.per_id', array($per_id));
        return $query->row();
    }
}
