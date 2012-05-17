<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class database extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('axipi_file_helper');
	}
	public function index() {
		$query = $this->db->query('SHOW TABLE STATUS');
		$output = '<div class="box1">';
		$output .= '<h1>Tables ('.$query->num_rows().')</h1>';
		$output .= '<ul>';
		$output .= '<li><a href="'.base_url().$this->itm->itm_code.'/_translation">Translation</a></li>';
		$output .= '<li><a href="'.base_url().$this->itm->itm_code.'/_optimize">Optimize</a></li>';
		$output .= '</ul>';
		$output .= '<div class="display">';
		$output .= '<table>';
		$output .= '<thead><tr><th class="first"><span class="thSortAsc">Name</span></th><th>Comment</th><th>Engine</th><th>Collation</th><th>Rows</th><th>Auto_increment</th><th>Data_length</th><th>Index_length</th><th>Create_time</th><th>Update_time</th>';
		//$output .= '<th>&nbsp;</th>';
		$output .= '</tr>';
		$output .= '</thead>';
		$total_rows = 0;
		$total_data = 0;
		$total_index = 0;
		foreach($query->result() as $row) {
			$total_rows += $row->Rows;
			$total_data += $row->Data_length;
			$total_index += $row->Index_length;
		}
		$output .= '<tfoot><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>'.$total_rows.'</th><th>&nbsp;</th><th>'.convert_size($total_data).'</th><th>'.convert_size($total_index).'</th><th>&nbsp;</th><th>&nbsp;</th>';
		//$output .= '<th>&nbsp;</th>';
		$output .= '</tr></tfoot>';
		$output .= '<tbody>';
		foreach($query->result() as $row) {
			if(isset($row->Engine) == 1) {
				$engine = $row->Engine;
			} else {
				$engine = $row->Type;
			}
			/*if($engine == 'InnoDB') {
				$sql_select = 'SELECT COUNT(*) AS id FROM '.$row->Name;
				$total = $this->dtb->query_select($sql_select);
				$rows = $total['r']['id'][0];
			} else {*/
				$rows = $row->Rows;
			//}
			$output .= '<tr>';
			$output .= '<td><a href="'.base_url().'axipi/core/database/_show/'.$row->Name.'">'.$row->Name.'</a></td>';
			$output .= '<td>'.$row->Comment.'</td>';
			$output .= '<td>'.$engine.'</td>';
			$output .= '<td>'.$row->Collation.'</td>';
			$output .= '<td>'.$rows.'</td>';
			$output .= '<td>'.$row->Auto_increment.'</td>';
			$output .= '<td>'.convert_size($row->Data_length).'</td>';
			$output .= '<td>'.convert_size($row->Index_length).'</td>';
			$output .= '<td>'.$row->Create_time.'</td>';
			$output .= '<td>'.$row->Update_time.'</td>';
			$output .= '<th>';
			//$output .= '<a href="index.php?p='.$this->get['p'].'&amp;a=convert-utf8-table&amp;table='.$row->Name.'">Convert to UTF-8</a>';
			$output .= '<a href="'.base_url().'axipi/core/database/_show/'.$row->Name.'">Show</a>';
			$output .= '</th>';
			$output .= '</tr>';
		}
		$output .= '</tbody>';
		$output .= '</table>';

		$output .= '</div>';
		$output .= '</div>';

		$this->zones['content'] = $output;
	}
	public function show($table) {
		$output = '';
		$query = $this->db->query('SHOW FULL COLUMNS FROM '.$table);
		if($query->num_rows() > 0) {
			$query_status = $this->db->query('SHOW TABLE STATUS WHERE name = ?', array($table));
			$output .= '<div class="box1">
			<h1>'.$table.' / '.$query_status->row()->Comment.'</h1>
			<ul>';
			$output .= '<li><a href="'.base_url().$this->itm->itm_code.'">Index</a></li>';
			$output .= '</ul>';
			$output .= '<div class="display">';
			$output .= '<table>
			<thead>
			<tr>
			<th class="first">Field</th>
			<th>Type</th>
			<th>Collation</th>
			<th>Null</th>
			<th>Key</th>
			<th>Default</th>
			<th>Extra</th>
			</tr>
			</thead>';
			$output .= '<tbody>';
			foreach($query->result() as $row) {
				$output .= '<tr>
				<td>'.$row->Field.'</td>
				<td>'.$row->Type.'</td>
				<td>'.$row->Collation.'</td>
				<td>'.$row->Null.'</td>
				<td>'.$row->Key.'</td>
				<td>'.$row->Default.'</td>
				<td>'.$row->Extra.'</td></tr>';
			}
			$output .= '</tbody>';
			$output .= '</table>';
			$output .= '</div>
			</div>';
		}
		$this->zones['content'] = $output;
		//$this->get['a'] = 'list';
	}
	public function translation() {
		$this->load->language('axipi_dynamic');

		$output = '<div class="box1">';
		$output .= '<h1>Translation</h1>';
		$output .= '<ul>';
		$output .= '<li><a href="'.base_url().$this->itm->itm_code.'">Index</a></li>';
		$output .= '</ul>';
		$output .= '<div class="display">';
		$query = $this->db->query('SHOW TABLE STATUS');
		if($query->num_rows() > 0) {
			$fields = array();
			foreach($query->result() as $row) {
				$query2 = $this->db->query('SHOW COLUMNS FROM '.$row->Name);
				if($query2->num_rows() > 0) {
					foreach($query2->result() as $row2) {
						if(substr($row2->Field, 0, 1) != '_') {
							$fields[] = $row2->Field;
						}
					}
				}
			}
			$fields = array_unique($fields);
			sort($fields);

			$output .= '<textarea class="textareabigger">&lt;?php'."\r\n";
			$u = 1;
			foreach($fields as $k) {
				$output .= '$lang[\''.$k.'\'] = \''.addslashes($this->lang->line($k)).'\';'."\r\n";
			}
			$output .= '</textarea>';

			$output .= '</div>';
			$output .= '</div>';

			$this->zones['content'] = $output;
		}
	}
	public function optimize() {
		$query = $this->db->query('SHOW TABLE STATUS');
		foreach($query->result() as $row) {
			$this->db->query('OPTIMIZE TABLE '.$row->Name);
		}
		$this->msg[] = 'Optimized';
		$this->index();
	}
}
