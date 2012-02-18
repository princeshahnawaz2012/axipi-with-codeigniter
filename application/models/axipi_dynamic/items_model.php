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
    function get_all_items() {
        $query = $this->db->query('SELECT COUNT(pro.itm_id) AS count FROM itm AS pro WHERE 1');
        return $query->result();
    }
    function get_pagination_items($num, $offset) {
        $query = $this->db->query('SELECT pro.* FROM itm AS pro WHERE 1 GROUP BY pro.itm_id LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_item($pro_id) {
        $query = $this->db->query('SELECT pro.* FROM itm pro WHERE pro.itm_id = ? GROUP BY pro.itm_id', array($pro_id));
        return $query->result();
    }
}
