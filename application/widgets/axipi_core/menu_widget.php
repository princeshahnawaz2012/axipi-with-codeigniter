<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_widget {
	public function index() {
		$query = $this->db->query('SELECT itm_rel_parent, itm.itm_id, itm.itm_code, itm.itm_link, IF(itm_rel_title IS NOT NULL, itm_rel_title, itm.itm_title) AS title FROM '.$this->db->dbprefix('itm_rel').' itm_rel LEFT JOIN '.$this->db->dbprefix('itm').' itm ON itm.itm_id = itm_rel.itm_id LEFT JOIN '.$this->db->dbprefix('grp_itm').' grp_itm ON grp_itm.itm_id = itm.itm_id AND grp_itm_ispublished = \'1\' WHERE itm.itm_publishstartdate <= \''.date('Y-m-d H:i:s').'\' AND IF(itm.itm_publishenddate IS NOT NULL, itm.itm_publishenddate >= \''.date('Y-m-d H:i:s').'\', \'1\') AND itm_rel.rel_id = \''.$this->data->id.'\' AND itm_rel_ispublished = \'1\' AND itm.itm_ispublished = \'1\' AND (itm.itm_access = \'all\' OR (itm.itm_access = \'createdby\' AND itm.itm_createdby = \''.$this->usr[0]->usr_id.'\') OR itm.itm_access = \''.$this->usr[0]->usr_access.'\' OR (itm.itm_access = \'groups\' AND grp_itm.grp_id IN ('.implode(', ', array_keys($this->usr[0]->groups)).'))) GROUP BY itm.itm_id ORDER BY itm_rel_parent ASC, itm_rel_ordering ASC, itm.itm_ordering ASC, itm.itm_title ASC');
		if($query->num_rows() > 0) {
			$relations = array();
			$u = 0;
			foreach($query->result() as $row) {
				if($u == 0) {
					$itm_rel_parent_first = $row->itm_rel_parent;
				}
				$title = $row->title;
				$relations[$row->itm_rel_parent][] = array('itm_id' => $row->itm_id, 'itemlink'=>$row->itm_link, 'item' => $row->itm_code, 'title' => $title);
				$u++;
			}
			$settings = array('expand'=>1);
			$data['listnav'] = $this->children($relations, $itm_rel_parent_first, array(), $settings);
			$data['widget'] = $this->data;
			return $this->load->view('axipi_core/menu_widget', $data, true);
		}
	}
	function children($relations, $relation, $selectedItems, $settings) {
		$output = '';
		if(isset($relations[$relation]) == 1) {
			$output .= '<ul>'."\n";
			$items = count($relations[$relation]);
			$u = 0;
			foreach($relations[$relation] as $value) {
				$classes = array();
				$classes[] = $value['item'];
				if($u == 0 || $items == 1) {
					$classes[] = 'first';
				} elseif($u+1 == $items) {
					$classes[] = 'last';
				}
				if($value['itemlink'] != '' && substr($value['itemlink'], 0, 1) == '#') {
					$link = $value['itemlink'];
				} else {
					$link = base_url().$value['item'];
				}
				if(array_key_exists($value['itm_id'], $selectedItems)) {
					$classes[] = 'active';
					$output .= '<li class="'.implode(' ', $classes).'"><a class="'.$value['item'].'" href="'.$link.'">'.$value['title'].'</a>';
					$selectedLoop = $value['item'];
				} else {
					if(count($classes) != 0) {
						$addClass = ' class="'.implode(' ', $classes).'"';
					} else {
						$addClass = '';
					}
					$output .= '<li'.$addClass.'><a class="'.$value['item'].'" href="'.$link.'">'.$value['title'].'</a>';
				}
				if(isset($relations[$value['itm_id']]) == 1 && (array_key_exists($value['item'], $selectedItems) || isset($settings['expand']) == 1 && $settings['expand'] == 1)) {
					$output .= $this->children($relations, $value['itm_id'], $selectedItems, $settings);
				}
				$output .= '</li>';
				$u++;
			}
			$output .= '</ul>'."\r\n";
		}
		return $output;
	}
}
