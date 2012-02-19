<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class axipi_library {
	public function __construct($params = array()) {
		set_error_handler(array($this, 'error_handler'));
		$this->CI =& get_instance();
		$this->CI->head = array();
		$this->CI->foot = array();
		$this->debug = array();
		$this->jquery = array();
		$this->base_url = base_url();
	}
	function error_handler($e_type, $e_message, $e_file, $e_line) {
		$e_type_values = array(1=>'E_ERROR', 2=>'E_WARNING', 4=>'E_PARSE', 8=>'E_NOTICE', 16=>'E_CORE_ERROR', 32=>'E_CORE_WARNING', 64=>'E_COMPILE_ERROR', 128=>'E_COMPILE_WARNING', 256=>'E_USER_ERROR', 512=>'E_USER_WARNING', 1024=>'E_USER_NOTICE', 2048=>'E_STRICT', 4096=>'E_RECOVERABLE_ERROR', 8192=>'E_DEPRECATED', 16384=>'E_USER_DEPRECATED', 30719=>'E_ALL');
		if(isset($e_type_values[$e_type]) == 1) {
			$e_type = $e_type_values[$e_type];
		}
		$key = md5($e_type.' | '.$e_message.' | '.$e_file.' | '.$e_line);
		$this->debug[$key] = $e_type.' | '.$e_message.' | '.$e_file.' | '.$e_line;
	}
	function get_head() {
		$head = array();
		if($this->CI->lay[0]->lay_type == 'text/html') {
			$titles = array();
			/*$titles[] = $this->CI->sct[0]->sct_title;
			foreach($this->CI->itm[0]->itm_tree as $value) {
				$titles[] = $value['title'];
			}
			if($this->CI->itm[0]->itm_titlehead != '' && $this->CI->itm[0]->itm_titleheadfull == 1) {
				$titles = array();
				$titles[] = $this->CI->itm[0]->itm_titlehead;
			} else {
				$titles = array_reverse($titles);
				if($this->CI->itm[0]->itm_titlehead != '' && $this->CI->itm[0]->itm_titleheadfull == 0) {
					$titles[0] = $this->CI->itm[0]->itm_titlehead;
				}
			}*/
			$titles[] = $this->CI->itm[0]->itm_title;
			$head[] = '<title>'.implode(' | ', $titles).'</title>';

			$head[] = '<meta charset="UTF-8">';
			/*if($this->CI->itm[0]->itm_description != '') {
				$head[] = '<meta content="'.$this->CI->data->display_in_field($this->CI->itm[0]->itm_description).'" name="description">';
			} elseif($this->CI->sct[0]->sct_description != '') {
				$head[] = '<meta content="'.$this->CI->data->display_in_field($this->CI->sct[0]->sct_description).'" name="description">';
			}
			if($this->CI->itm[0]->itm_keywords != '') {
				$head[] = '<meta content="'.$this->CI->data->display_in_field($this->CI->itm[0]->itm_keywords).'" name="keywords">';
			} elseif($this->CI->sct[0]->sct_keywords != '') {
				$head[] = '<meta content="'.$this->CI->data->display_in_field($this->CI->sct[0]->sct_keywords).'" name="keywords">';
			}*/
			/*if(isset($this->CI->itm[0]->itm_stg']['meta-robots']) == 1 && $this->CI->itm[0]->itm_stg']['meta-robots'] != '') {
				$head[] = '<meta content="'.$this->CI->itm[0]->itm_stg']['meta-robots'].'" name="robots">';
			} else {
				$robots = '<meta content="index,follow" name="robots">';
			}*/

			/*if($this->CI->stg[0]->cdn-url'] != '') {
				$this->base_url = $this->CI->stg[0]->cdn-url'].'/';
			} else {
				$this->base_url = '';
			}*/
			if(file_exists('styles/sct_code/'.$this->CI->sct[0]->sct_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/sct_code/'.$this->CI->sct[0]->sct_code.'.css" rel="stylesheet" type="text/css">';
			} elseif(file_exists('styles/sct_code/'.$this->CI->sct[0]->sct_code.'.dist.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/sct_code/'.$this->CI->sct[0]->sct_code.'.dist.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/sct_virtualcode/'.$this->CI->sct[0]->sct_virtualcode.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/sct_virtualcode/'.$this->CI->sct[0]->sct_virtualcode.'.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/lay_code/'.$this->CI->lay[0]->lay_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/lay_code/'.$this->CI->lay[0]->lay_code.'.css" rel="stylesheet" type="text/css">';
			}
			/*if(file_exists('styles/hst_environment/'.$this->CI->hst[0]->hst_environment.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/hst_environment/'.$this->CI->hst[0]->hst_environment.'.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/hst_code/'.$_SERVER['HTTP_HOST'].'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/hst_code/'.$_SERVER['HTTP_HOST'].'.css" rel="stylesheet" type="text/css">';
			}*/
			if(file_exists('styles/cmp_code/'.$this->CI->cmp[0]->cmp_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/cmp_code/'.$this->CI->cmp[0]->cmp_code.'.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/itm_virtualcode/'.$this->CI->itm[0]->itm_virtualcode.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/itm_virtualcode/'.$this->CI->itm[0]->itm_virtualcode.'.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/itm_code/'.$this->CI->itm[0]->itm_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/itm_code/'.$this->CI->itm[0]->itm_code.'.css" rel="stylesheet" type="text/css">';
			}
			/*if(file_exists('styles/lng_code/'.$this->CI->lng[0]->lng_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/lng_code/'.$this->CI->lng[0]->lng_code.'.css" rel="stylesheet" type="text/css">';
			}*/
		}
		$head = array_merge($head, $this->CI->head);
		return implode("\r\n", $head)."\r\n";
	}
	function get_foot() {
		$foot = array();
		if($this->CI->lay[0]->lay_type == 'text/html') {
			$this->jquery = array_unique($this->jquery);
			if(count($this->jquery) != 0) {
				foreach($this->jquery as $v) {
					if(file_exists('thirdparty/jquery/scripts/'.$v.'.min.js')) {
						$foot[] = '<script type="text/javascript" src="'.$this->base_url.'thirdparty/jquery/scripts/'.$v.'.min.js" charset="UTF-8"></script>';
					} elseif(file_exists('thirdparty/jquery/scripts/'.$v.'.js')) {
						$foot[] = '<script type="text/javascript" src="'.$this->base_url.'thirdparty/jquery/scripts/'.$v.'.js" charset="UTF-8"></script>';
					}
				}
				if(file_exists('scripts/sct_code/'.$this->CI->sct[0]->sct_code.'.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/sct_code/'.$this->CI->sct[0]->sct_code.'.js" type="text/javascript"></script>';
				} elseif(file_exists('scripts/sct_code/'.$this->CI->sct[0]->sct_code.'.dist.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/sct_code/'.$this->CI->sct[0]->sct_code.'.dist.js" type="text/javascript"></script>';
				}
				if(file_exists('scripts/sct_virtualcode/'.$this->CI->sct[0]->sct_virtualcode.'.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/sct_virtualcode/'.$this->CI->sct[0]->sct_virtualcode.'.js" type="text/javascript"></script>';
				} elseif(isset($this->CI->sct[0]->sct_virtualcode) == 1 && file_exists('scripts/sct_virtualcode/'.$this->CI->sct[0]->sct_virtualcode.'.dist.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/sct_virtualcode/'.$this->CI->sct[0]->sct_virtualcode.'.dist.js" type="text/javascript"></script>';
				}
				if(file_exists('scripts/itm_virtualcode/'.$this->CI->itm[0]->itm_virtualcode.'.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/itm_virtualcode/'.$this->CI->itm[0]->itm_virtualcode.'.js" type="text/javascript"></script>';
				}
				if(file_exists('scripts/itm_code/'.$this->CI->itm[0]->itm_code.'.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/itm_code/'.$this->CI->itm[0]->itm_code.'.js" type="text/javascript"></script>';
				}
			}
		}
		$foot = array_merge($foot, $this->CI->foot);
		return implode("\r\n", $foot)."\r\n";
	}
	function jquery_load($k) {
		$this->jquery[] = $k;
	}
	function get_debug() {
		$debug = '';
		if($this->CI->lay[0]->lay_type == 'text/html') {
			function loop_v($data) {
				$data = get_object_vars($data);
				ksort($data);
				$output = '<ul>';
				foreach($data as $k => $v) {
					if(is_array($v)) {
						if(count($v) != 0) {
							$output .= '<li>'.$k.':';
							$output .= loop_v($v);
							$output .= '</li>';
						}
					} else if(strval($v) != '') {
						$output .= '<li>'.$k.':';
						$output .= ' '.$v;
						$output .= '</li>';
					}
				}
				$output .= '</ul>';
				return $output;
			}
		
			$debug = '<div id="box-debug">';
			$debug .= '<h1>Debug</h1>';
			$debug .= '<div class="display">';
		
			$debug .= '<p>elapsed time: '.$this->CI->benchmark->elapsed_time().'</p>';
			if(function_exists('memory_get_peak_usage')) {
				$debug .= '<p>memory peak usage: '.number_format(memory_get_peak_usage(), 0, '.', ' ').'</p>';
			}
			if(function_exists('memory_get_usage')) {
				$debug .= '<p>memory usage: '.number_format(memory_get_usage(), 0, '.', ' ').'</p>';
			}

			if(count($this->debug) != 0) {
				$debug .= '<ul>';
				foreach($this->debug as $item) {
					$debug .= '<li>'.$item.'</li>';
				}
				$debug .= '</ul>';
			}

			/*$this->CI->output->enable_profiler(TRUE);
			$sections = array('benchmarks', 'config', 'controller_info', 'get', 'http_headers', 'memory_usage', 'post', 'queries', 'uri_string', 'query_toggle_count');
			$debug .= $this->CI->output->set_profiler_sections($sections);*/

			$debug .= '<div class="column1">';
		
			$debug .= '<h2>itm</h2>';
			$debug .= loop_v($this->CI->itm[0]);
		
			$debug .= '</div>';
		
			$debug .= '<div class="column1">';
		
			$debug .= '<h2>sct</h2>';
			$debug .= loop_v($this->CI->sct[0]);
		
			$debug .= '<h2>hst</h2>';
			//$debug .= loop_v($this->CI->hst[0]);
		
			$debug .= '<h2>cmp</h2>';
			$debug .= loop_v($this->CI->cmp[0]);
		
			$debug .= '</div>';
		
			$debug .= '<div class="column1">';
		
			$debug .= '<h2>usr</h2>';
			//$debug .= loop_v($this->CI->usr[0]);
		
			$debug .= '</div>';
		
			$debug .= '<div class="column1 columnlast">';
		
			$debug .= '<h2>lng</h2>';
			$debug .= loop_v($this->CI->lng[0]);
		
			$debug .= '<h2>lay</h2>';
			$debug .= loop_v($this->CI->lay[0]);
		
			$debug .= '<h2>stg</h2>';
			//$debug .= loop_v($this->CI->stg[0]);
		
			$debug .= '</div>';
		
			$debug .= '</div>';
			$debug .= '</div>';
		}
		return $debug."\r\n";
	}
}
