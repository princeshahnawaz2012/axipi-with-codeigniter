<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class folders extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('axipi_file_helper');

		$this->folders = array();

		$dir = 'application';
		if(is_dir($dir)) {
			if($dh = opendir($dir)) {
				while(($file = readdir($dh)) !== false) {
					if(is_dir($dir.'/'.$file) && $file != '.' && $file != '..' && $file != '.svn') {
						$this->folders[] = $dir.'/'.$file;
					}
				}
				closedir($dh);
			}
		}

		$dir = 'system';
		if(is_dir($dir)) {
			if($dh = opendir($dir)) {
				while(($file = readdir($dh)) !== false) {
					if(is_dir($dir.'/'.$file) && $file != '.' && $file != '..' && $file != '.svn') {
						$this->folders[] = $dir.'/'.$file;
					}
				}
				closedir($dh);
			}
		}

		$dir = 'medias';
		if(is_dir($dir)) {
			if($dh = opendir($dir)) {
				while(($file = readdir($dh)) !== false) {
					if(is_dir($dir.'/'.$file) && $file != '.' && $file != '..' && $file != '.svn') {
						$this->folders[] = $dir.'/'.$file;
					}
				}
				closedir($dh);
			}
		}
		
		$dir = 'storage';
		if(is_dir($dir)) {
			if($dh = opendir($dir)) {
				while(($file = readdir($dh)) !== false) {
					if(is_dir($dir.'/'.$file) && $file != '.' && $file != '..' && $file != '.svn') {
						$this->folders[] = $dir.'/'.$file;
					}
				}
				closedir($dh);
			}
		}
		$this->folders[] = 'scripts';
		$this->folders[] = 'styles';
		
		$dir = 'thirdparty';
		if(is_dir($dir)) {
			if($dh = opendir($dir)) {
				while(($file = readdir($dh)) !== false) {
					if(is_dir($dir.'/'.$file) && $file != '.' && $file != '..' && $file != '.svn') {
						$this->folders[] = $dir.'/'.$file;
					}
				}
				closedir($dh);
			}
		}
		$this->folders = array_unique($this->folders);
		sort($this->folders);
	}
	public function index() {
		if(function_exists('posix_getpwuid') && function_exists('posix_getgrgid')) {
			$posix = 1;
		} else {
			$posix = 0;
		}

		$output = '<div class="box1">';
		$output .= '<h1>'.$this->itm->itm_title.'</h1>';
		$output .= '<div class="display">';
		
		$output .= '<table>';
		$output .= '<thead>';
		$output .= '<tr><th class="first">'.$this->lang->line('directory').'</th><th>'.$this->lang->line('filesize').'</th><th>'.$this->lang->line('files').'</th><th>'.$this->lang->line('filepermissions').'</th><th>'.$this->lang->line('fileowner').' / '.$this->lang->line('filegroup').'</th><th>&nbsp;</th></tr>';
		$output .= '</thead>';
		$output .= '<tbody>';
		$total_foldersize = 0;
		$total_filescount = 0;
		foreach($this->folders as $folder) {
			if(is_dir($folder)) {
				$fileperms = fileperms_test($folder);
				$this->foldersize = directory_size($folder);
				$total_foldersize += $this->foldersize;
				$files_count = directory_files_count($folder);
				$total_filescount += $files_count;
				$output .= '<tr><td>'.$folder.'</td><td>'.convert_size($this->foldersize).'</td><td>'.$files_count.'</td><td>'.$fileperms.'</td>';
				if($posix == 1) {
					$fileowner = posix_getpwuid(fileowner($folder));
					$filegroup = posix_getgrgid(filegroup($folder));
					$output .= '<td>'.$fileowner['name'].'.'.$filegroup['name'].'</td>';
				} else {
					$output .= '<td>&nbsp;</td>';
				}
				$output .= '<th>';
				$output .= '<a href="'.current_url().'?a=chmod_755&amp;folder='.$folder.'">chmod 0755</a>';
				$output .= '<a href="'.current_url().'?a=chmod_775&amp;folder='.$folder.'">chmod 0775</a>';
				$output .= '<a href="'.current_url().'?a=chmod_777&amp;folder='.$folder.'">chmod 0777</a>';
				$output .= '</th>';
				$output .= '</tr>';
			}
		}
		$output .= '<tr>';
		$output .= '<td>&nbsp;</td><td><strong>'.convert_size($total_foldersize).'</strong></td><td><strong>'.$total_filescount.'</strong></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
		$output .= '</tr>';
		$output .= '</tbody>';
		$output .= '</table>';
		
		$output .= '</div>';
		$output .= '</div>';

		$this->zones['content'] = $output;
	}
	public function chmod_755() {
		if(in_array($this->input->get('folder'), $this->folders) && is_dir($this->input->get('folder'))) {
			directory_chmod($this->input->get('folder'), 0755);
		}
		$this->index();
	}
	public function chmod_775() {
		if(in_array($this->input->get('folder'), $this->folders) && is_dir($this->input->get('folder'))) {
			directory_chmod($this->input->get('folder'), 0775);
		}
		$this->index();
	}
	public function chmod_777() {
		if(in_array($this->input->get('folder'), $this->folders) && is_dir($this->input->get('folder'))) {
			directory_chmod($this->input->get('folder'), 0777);
		}
		$this->index();
	}

}
