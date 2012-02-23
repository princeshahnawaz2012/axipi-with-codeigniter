<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class zone_errors {
	public function index() {
		if(count($this->err) != 0) {
			$output = '<div class="box1" id="box-errors">';
			$output .= '<h1>'.$this->data->title.'</h1>';
			$output .= '<div class="display">';
			$output .= '<ul>';
			foreach($this->err as $value) {
				$output .= '<li>'.$value.'</li>';
			}
			$output .= '</ul>';
			$output .= '</div>';
			$output .= '</div>';
			return $output;
		}
	}
}
