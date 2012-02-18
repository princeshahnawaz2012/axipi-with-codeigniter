<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class items_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function select_component() {
		$select_component = array();
		$select_component[''] = '--';
        $query = $this->db->query('SELECT cmp.* FROM cmp AS cmp WHERE 1 GROUP BY cmp.cmp_id ORDER BY cmp.cmp_code');
		foreach ($query->result() as $row) {
			$select_component[$row->cmp_id] = $row->cmp_code;
		}
        return $select_component;
    }
    function select_section() {
		$select_section = array();
		$select_section[''] = '--';
        $query = $this->db->query('SELECT sct.* FROM sct AS sct WHERE 1 GROUP BY sct.sct_id ORDER BY sct.sct_code');
		foreach ($query->result() as $row) {
			$select_section[$row->sct_id] = $row->sct_code;
		}
        return $select_section;
    }
    function select_language() {
		$select_language = array();
		$select_language[''] = '--';
        $query = $this->db->query('SELECT lng.* FROM lng AS lng WHERE 1 GROUP BY lng.lng_id ORDER BY lng.lng_code');
		foreach ($query->result() as $row) {
			$select_language[$row->lng_id] = $row->lng_code;
		}
        return $select_language;
    }
    function get_all_items($flt) {
        $query = $this->db->query('SELECT COUNT(itm.itm_id) AS count FROM itm AS itm LEFT JOIN cmp AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN sct AS sct ON sct.sct_id = itm.sct_id LEFT JOIN lng AS lng ON lng.lng_id = itm.lng_id WHERE '.implode(' AND ', $flt));
        return $query->result();
    }
    function get_pagination_items($flt, $num, $offset) {
        $query = $this->db->query('SELECT itm.itm_id, itm.itm_code, itm.itm_title, cmp.cmp_code, sct.sct_code, lng.lng_code, COUNT(DISTINCT(items.itm_id)) AS count_children FROM itm AS itm LEFT JOIN cmp AS cmp ON cmp.cmp_id = itm.cmp_id LEFT JOIN sct AS sct ON sct.sct_id = itm.sct_id LEFT JOIN lng AS lng ON lng.lng_id = itm.lng_id LEFT JOIN itm AS items ON items.itm_parent = itm.itm_id WHERE '.implode(' AND ', $flt).' GROUP BY itm.itm_id ORDER BY itm.itm_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_item($itm_id) {
        $query = $this->db->query('SELECT itm.* FROM itm itm WHERE itm.itm_id = ? GROUP BY itm.itm_id', array($itm_id));
        return $query->result();
    }
}
