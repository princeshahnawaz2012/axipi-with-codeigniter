<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class languages_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function select_lng_defaultitem() {
		$select_lng_defaultitem = array();
		$select_lng_defaultitem[''] = '-';
		//$this->db->cache_on();
        $query = $this->db->query('SELECT itm.itm_id, itm.itm_parent, itm.itm_code AS itm_code, CONCAT(sct.sct_code, \' (\', lng.lng_code, \')\') AS optgroup FROM '.$this->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->db->dbprefix('sct').' AS sct ON sct.sct_id = itm.sct_id LEFT JOIN '.$this->db->dbprefix('lng').' AS lng ON lng.lng_id = itm.lng_id LEFT JOIN '.$this->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id WHERE cmp.cmp_ispage = \'1\' GROUP BY itm.itm_id ORDER BY sct.sct_code ASC, itm.itm_parent ASC, itm.itm_ordering ASC, itm.itm_title ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				if(isset($select_lng_defaultitem[$row->optgroup]) == 0) {
					$select_lng_defaultitem[$row->optgroup] = array();
				}
				$select_lng_defaultitem[$row->optgroup][$row->itm_parent][$row->itm_id] = $row->itm_code;
			}
		}
		foreach($select_lng_defaultitem as $optgroup => $items) {
			if($optgroup != '') {
				$select_lng_defaultitem[$optgroup] = $this->build_tree($items, '', '');
			}
		}
		//$this->db->cache_off();
        return $select_lng_defaultitem;
    }
    function get_all_languages($flt) {
        $query = $this->db->query('SELECT COUNT(lng.lng_id) AS count FROM '.$this->db->dbprefix('lng').' AS lng WHERE '.implode(' AND ', $flt));
        return $query->row();
    }
    function get_pagination_languages($flt, $num, $offset, $column) {
        $query = $this->db->query('SELECT lng.lng_id, lng.lng_code, lng.lng_title, lng.lng_islocked, lng.lng_ispublished, COUNT(DISTINCT(itm.itm_id)) AS count_items, COUNT(DISTINCT(usr.usr_id)) AS count_users FROM '.$this->db->dbprefix('lng').' AS lng LEFT JOIN '.$this->db->dbprefix('itm').' AS itm ON itm.lng_id = lng.lng_id LEFT JOIN '.$this->db->dbprefix('usr').' AS usr ON usr.lng_id = lng.lng_id WHERE '.implode(' AND ', $flt).' GROUP BY lng.lng_id ORDER BY '.$this->session->userdata($column.'_col').' LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_language($lng_id) {
        $query = $this->db->query('SELECT lng.* FROM '.$this->db->dbprefix('lng').' AS lng WHERE lng.lng_id = ? GROUP BY lng.lng_id', array($lng_id));
        return $query->row();
    }
	function build_tree($relations, $indent = '', $relation) {
		if($indent == '') {
			$indent = '&nbsp;';
		} else {
			$indent = $indent.'&nbsp;&nbsp;&nbsp;';
		}
		if(isset($relations[$relation]) == 1) {
			foreach($relations[$relation] as $id => $object) {
				if(is_object($object)) {
					$object->itm_title = $indent.'|-'.$object->itm_title;
					$tree_items[$id] = $object;
				} else {
					$object = $indent.'|-'.$object;
					$tree_items[$id] = $object;
				}
				if(isset($relations[$id]) == 1 && $id != '') {
					$merge = $this->build_tree($relations, $indent, $id);
					foreach($merge as $k => $v) {
						$tree_items[$k] = $v;
					}
				}
			}
		}
		return $tree_items;
	}
}
