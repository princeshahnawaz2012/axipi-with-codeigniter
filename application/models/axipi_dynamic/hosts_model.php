<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hosts_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function select_layout() {
		$select_layout = array();
		$select_layout[''] = '--';
		$this->db->cache_on();
        $query = $this->db->query('SELECT lay.lay_id, lay.lay_code FROM '.$this->db->dbprefix('lay').' AS lay WHERE 1 GROUP BY lay.lay_id ORDER BY lay.lay_code ASC');
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$select_layout[$row->lay_id] = $row->lay_code;
			}
		}
		$this->db->cache_off();
        return $select_layout;
    }
    function get_all_hosts($flt) {
        $query = $this->db->query('SELECT COUNT(hst.hst_id) AS count FROM '.$this->db->dbprefix('hst').' AS hst WHERE '.implode(' AND ', $flt));
        return $query->result();
    }
    function get_pagination_hosts($flt, $num, $offset) {
        $query = $this->db->query('SELECT hst.hst_id, hst.hst_code, hst.hst_url, hst.hst_environment, hst.hst_islocked, hst.hst_ispublished, lay.lay_code FROM '.$this->db->dbprefix('hst').' AS hst LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = hst.lay_id WHERE '.implode(' AND ', $flt).' GROUP BY hst.hst_id ORDER BY hst.hst_id DESC LIMIT '.$offset.', '.$num);
        return $query->result();
    }
    function get_host($hst_id) {
        $query = $this->db->query('SELECT hst.*, lay.lay_code  FROM '.$this->db->dbprefix('hst').' AS hst LEFT JOIN '.$this->db->dbprefix('lay').' AS lay ON lay.lay_id = hst.lay_id WHERE hst.hst_id = ? GROUP BY hst.hst_id', array($hst_id));
        return $query->result();
    }
}
