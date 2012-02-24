<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class zone_helps {
	public function index() {
		if(count($this->hlp) != 0) {
			$output = '<div class="box1" id="box-helps">';
			$output .= '<h1>'.$this->data->title.'</h1>';
			$output .= '<div class="display">';
			$output .= '<ul>';
			foreach($this->hlp as $value) {
				$output .= '<li>'.$value.'</li>';
			}
			$output .= '</ul>';
			$output .= '</div>';
			$output .= '</div>';
			return $output;
		}
	}
}
