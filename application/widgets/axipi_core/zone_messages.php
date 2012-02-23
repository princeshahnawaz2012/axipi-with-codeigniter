<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class zone_messages {
	public function index() {
		if(count($this->msg) != 0) {
			$output = '<div class="box1" id="box-messages">';
			$output .= '<h1>'.$this->data->title.'</h1>';
			$output .= '<div class="display">';
			$output .= '<ul>';
			foreach($this->msg as $value) {
				$output .= '<li>'.$value.'</li>';
			}
			$output .= '</ul>';
			$output .= '</div>';
			$output .= '</div>';
			return $output;
		}
	}
}
