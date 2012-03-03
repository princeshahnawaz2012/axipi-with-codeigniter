<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class groups_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_all_groups($flt) {
        $query = $this->db->query('SELECT COUNT(grp.grp_id) AS count FROM '.$this->db->dbprefix('grp').' AS grp WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_groups($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT grp.grp_id, grp.grp_code, grp.grp_islocked, grp.grp_ispublished, COUNT(DISTINCT(grp_per.per_id)) AS count_permissions, COUNT(DISTINCT(grp_itm.itm_id)) AS count_items, COUNT(DISTINCT(grp_usr.usr_id)) AS count_users FROM '.$this->db->dbprefix('grp').' AS grp LEFT JOIN '.$this->db->dbprefix('grp_per').' AS grp_per ON grp_per.grp_id = grp.grp_id LEFT JOIN '.$this->db->dbprefix('grp_itm').' AS grp_itm ON grp_itm.grp_id = grp.grp_id LEFT JOIN '.$this->db->dbprefix('grp_usr').' AS grp_usr ON grp_usr.grp_id = grp.grp_id WHERE '.implode(' AND ', $flt).' GROUP BY grp.grp_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_groups_is($is) {
        $query = $this->db->query('SELECT grp.grp_id, grp.grp_code, grp.grp_islocked, grp.grp_ispublished FROM '.$this->db->dbprefix('grp').' AS grp WHERE grp.grp_is'.$is.' = \'1\' GROUP BY grp.grp_id ORDER BY grp.grp_code ASC');
        return $query->result();
    }
    function get_groups_saved_item($flt) {
		$groups_saved = array();
        $query = $this->db->query('SELECT grp.grp_id, itm.itm_id FROM '.$this->db->dbprefix('grp_itm').' AS grp_itm LEFT JOIN '.$this->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_itm.grp_id LEFT JOIN '.$this->db->dbprefix('itm').' AS itm ON itm.itm_id = grp_itm.itm_id LEFT JOIN '.$this->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id WHERE '.implode(' AND ', $flt).' AND grp.grp_isitem = \'1\'');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$groups_saved[$row->itm_id][$row->grp_id] = 1;
			}
		}
        return $groups_saved;
    }
    function get_groups_saved_permission($flt) {
		$groups_saved = array();
        $query = $this->db->query('SELECT grp.grp_id, per.per_id FROM '.$this->db->dbprefix('grp_per').' AS grp_per LEFT JOIN '.$this->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_per.grp_id LEFT JOIN '.$this->db->dbprefix('per').' AS per ON per.per_id = grp_per.per_id WHERE '.implode(' AND ', $flt).' AND grp.grp_ispermission = \'1\'');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$groups_saved[$row->per_id][$row->grp_id] = 1;
			}
		}
        return $groups_saved;
    }
    function get_groups_saved_user($flt) {
		$groups_saved = array();
        $query = $this->db->query('SELECT grp.grp_id, usr.usr_id FROM '.$this->db->dbprefix('grp_usr').' AS grp_usr LEFT JOIN '.$this->db->dbprefix('grp').' AS grp ON grp.grp_id = grp_usr.grp_id LEFT JOIN '.$this->db->dbprefix('usr').' AS usr ON usr.usr_id = grp_usr.usr_id WHERE '.implode(' AND ', $flt).' AND grp.grp_isuser = \'1\'');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$groups_saved[$row->usr_id][$row->grp_id] = 1;
			}
		}
        return $groups_saved;
    }
    function get_translations($grp_id) {
        $query = $this->db->query('SELECT grp_trl.*, lng.lng_title, lng.lng_code, lng.lng_id FROM '.$this->db->dbprefix('lng').' AS lng LEFT JOIN '.$this->db->dbprefix('grp_trl').' AS grp_trl ON grp_trl.lng_id = lng.lng_id AND grp_trl.grp_id = ?', array($grp_id));
		return $query->result();
    }
    function get_group($grp_id) {
        $query = $this->db->query('SELECT grp.* FROM '.$this->db->dbprefix('grp').' AS grp WHERE grp.grp_id = ? GROUP BY grp.grp_id', array($grp_id));
        return $query->row();
    }
}
