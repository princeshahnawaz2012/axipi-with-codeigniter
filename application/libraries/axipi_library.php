<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Axipi {
	public function __construct($params = array()) {
		$this->CI =& get_instance();
	}
	function filters_add() {
	function set_filter($name, $field, $value, $type) {
		if($value != '') {
			if($type == 'like') {
				if(is_array($field)) {
					$list = array();
					foreach($field as $key) {
						$list[] = $key.' LIKE \'%'.$value.'%\'';
					}
					$this->flt[] = '('.implode(' OR ', $list).')';
				} else {
					$this->flt[] = $field.' LIKE \'%'.$value.'%\'';
				}
			}
			if($type == 'equal') {
				if(is_array($field)) {
					$list = array();
					foreach($field as $key) {
						$list[] = $key.' = \''.$value.'\'';
					}
					$this->flt[] = '('.implode(' OR ', $list).')';
				} else {
					$this->flt[] = $field.' = \''.$value.'\'';
				}
			}
			if($type == 'inferior') {
				$this->flt[] = $field.' <= \''.$value.'\'';
			}
			if($type == 'superior') {
				$this->flt[] = $field.' >= \''.$value.'\'';
			}
			if($type == 'inferior_date') {
				if(is_array($field)) {
					$list = array();
					foreach($field as $key) {
						$list[] = $key.' <= \''.$value.' 23:59:59\'';
					}
					$this->flt[] = '('.implode(' OR ', $list).')';
				} else {
					$this->flt[] = $field.' <= \''.$value.' 23:59:59\'';
				}
			}
			if($type == 'superior_date') {
				if(is_array($field)) {
					$list = array();
					foreach($field as $key) {
						$list[] = $key.' >= \''.$value.' 00:00:00\'';
					}
					$this->flt[] = '('.implode(' OR ', $list).')';
				} else {
					$this->flt[] = $field.' >= \''.$value.' 00:00:00\'';
				}
			}
			if($type == 'empty') {
				if($value == 0) {
					$this->flt[] = '('.$field.' IS NOT NULL AND '.$field.' != \'\')';
				}
				if($value == 1) {
					$this->flt[] = '('.$field.' IS NULL OR '.$field.' = \'\')';
				}
			}
			if($type == 'notempty') {
				if($value == 0) {
					$this->flt[] = '('.$field.' IS NULL OR '.$field.' = \'\')';
				}
				if($value == 1) {
					$this->flt[] = '('.$field.' IS NOT NULL AND '.$field.' != \'\')';
				}
			}
		}
		$_SESSION[$this->stg->v['session-key']]['filters'][$name] = $value;
	}
	}
	function filters_build() {
		$flt = array();
		$flt[] = '1';
		foreach($this->filters as $k =>$v) {
			if($thid->CI->input->post($k)) {
				$flt[] = $v[0].' = '.$thid->CI->db->escape($thid->CI->input->post($k));
				$thid->CI->session->set_userdata($k, $thid->CI->input->post($k));
			} else if($thid->CI->session->userdata($k)) {
				$flt[] = $v[0].' = '.$thid->CI->db->escape($thid->CI->session->userdata($k));
			}
		}
		return $flt;
	}
}
