<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class medias extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->helper(array('axipi_file_helper'));

		$this->ext_size = array('gif', 'jpeg', 'jpg', 'png', 'swf', 'psd', 'tiff', 'bmp');
		$this->ext_edit = array('jpeg', 'jpg', 'png', 'gif');
		$this->ext_view = array('jpeg', 'jpg', 'png', 'swf', 'gif');
		$this->ext_icon = array('png', 'gif', 'jpeg', 'jpg', 'ico');
		$this->ext_excluded = array('.', '..');

		if(function_exists('posix_getpwuid') && function_exists('posix_getgrgid')) {
			$this->posix = 1;
		} else {
			$this->posix = 0;
		}

		$this->directory = $this->input->get('directory');
		$this->file = $this->input->get('file');

		if(isset($this->directory) == 0 || !is_dir($this->directory) || strstr($this->directory, '..') || strstr($this->directory, '../') || strstr($this->directory, './') || $this->directory == '.' || $this->directory == '/' || substr($this->directory, 0, 6) != 'medias') {
			$this->directory = 'medias';
		}
		if(substr($this->directory, -1) == '/') {
			$this->directory = substr($this->directory, 0, -1);
		}

		$this->breadcrumbs = '';
		$parts = explode('/', $this->directory);
		$totalParts = count($parts);
		$this->directory_parent = '';
		if($totalParts > 1) {
			$partsLoop = array_reverse($parts);
			//$parts = array_reverse($parts);
			$u = 0;
			foreach($partsLoop as $value) {
				$links[] = $value;
				$bread[] = '<li><a href="'.base_url().'axipi/core/medias/?directory='.implode('/', $parts).'">'.$value.'</a></li>';
				array_pop($parts);
				$u++;
			}
			$this->directory_parent = $links[1];
			$links = array_reverse($links);
			array_shift($links);
			$bread = array_reverse($bread);
			array_shift($bread);
			$this->breadcrumbs .= '<div class="box-breadcrumbs box1">
			<div class="display">
			<ul>';
			$this->breadcrumbs .= '<a href="'.base_url().'axipi/core/medias">medias</a>';
			$this->breadcrumbs .= implode('', $bread);
			$this->breadcrumbs .= '</ul>
			</div>
			</div>';
		}
	}
	public function index() {
		$this->thumbs();
	}
	public function read() {
		$content = '';
		$content .= $this->breadcrumbs;
		if(file_exists($this->directory.'/'.$this->file)) {
			$filesize = convert_size(filesize($this->directory.'/'.$this->file));
			$filedate = date('Y-m-d H:i:s', filemtime($this->directory.'/'.$this->file));
			if(strstr($this->directory.'/'.$this->file, '.tar.gz')) {
				$fileextension = 'tar.gz';
			} else {
				$fileextension = strtolower(substr(strrchr($this->directory.'/'.$this->file, '.'), 1));
			}
			if(in_array($fileextension, $this->ext_size)) {
				list($width, $height, $type, $attr) = getimagesize($this->directory.'/'.$this->file);
				$dimensions = $width.'x'.$height;
				$fileperms = fileperms($this->directory.'/'.$this->file);
				$content .= '<div class="box1">';
				$content .= '<h1>'.$this->directory.'/'.$this->file.'</h1>';
				$unorderedlist = array();
				/*if($this->get['tinymce'] == 1 && in_array($fileextension, $this->ext_view)) {
					$unorderedlist[] = '<a href="#" onclick="mediaSelected(\''.$this->directory.'/'.$this->file.'\', \''.$width.'\', \''.$height.'\');" title="'.$this->lang->line('select').'">'.$this->lang->line('select-short').'</a>';
				}
				$unorderedlist[] = '<a class="delete" href="index.php?p='.$this->get['p'].'&amp;mode='.$this->get['mode'].'&amp;tinymce='.$this->get['tinymce'].'&amp;a=delete&amp;dir='.$this->directory.'&amp;file='.urlencode($this->file).'" title="'.$this->lang->line('delete').'">'.$this->lang->line('delete-short').'</a>';
				if(in_array($fileextension, $this->ext_edit) && $edit_enabled == 1) {
					$unorderedlist[] = '<a href="index.php?p='.$this->get['p'].'&amp;mode='.$this->get['mode'].'&amp;tinymce='.$this->get['tinymce'].'&amp;a=resize&amp;dir='.$this->directory.'&amp;file='.$this->file.'" title="'.$this->lang->line('resize-file').'">'.$this->lang->line('resize-file').'</a>';
					$unorderedlist[] = '<a href="index.php?p='.$this->get['p'].'&amp;mode='.$this->get['mode'].'&amp;tinymce='.$this->get['tinymce'].'&amp;a=crop&amp;dir='.$this->directory.'&amp;file='.$this->file.'" title="'.$this->lang->line('crop-file').'">'.$this->lang->line('crop-file').'</a>';
				}
				$unorderedlist[] = '<a href="index.php?p='.$this->get['p'].'&amp;mode='.$this->get['mode'].'&amp;tinymce='.$this->get['tinymce'].'&amp;a=rename&amp;dir='.$this->directory.'&amp;file='.urlencode($this->file).'" title="'.$this->lang->line('rename').'">'.$this->lang->line('rename-short').'</a>';
				$unorderedlist[] = '<a href="index.php?p='.$this->get['p'].'&amp;mode='.$this->get['mode'].'&amp;tinymce='.$this->get['tinymce'].'&amp;dir='.$this->directory.'">'.$this->lang->line('cancel').'</a>';
				$content .= $this->build_unorderedlist($unorderedlist);*/
				$content .= '<div class="display">';
	
				$content .= '<div class="column1">';
				$content .= '<p><span class="label">'.$this->lang->line('media').'</span>'.$this->file.'</p>';
				$content .= '<p><span class="label">'.$this->lang->line('filesize').'</span>'.$filesize.'</p>';
				$content .= '<p><span class="label">'.$this->lang->line('date').'</span>'.$filedate.'</p>';
				$content .= '<p><span class="label">'.$this->lang->line('dimensions').'</span>'.$dimensions.'</p>';
				$content .= '<p><span class="label">'.$this->lang->line('filepermissions').'</span>'.$fileperms.'</p>';
				if(in_array('axipi', $this->usr->groups) && $this->posix == 1) {
					$fileowner = posix_getpwuid(fileowner($this->directory.'/'.$this->file));
					$filegroup = posix_getgrgid(filegroup($this->directory.'/'.$this->file));
					$content .= '<p><span class="label">'.$this->lang->line('fileowner').' / '.$this->lang->line('filegroup').'</span>'.$fileowner['name'].'.'.$filegroup['name'].'</p>';
				}
				$content .= '</div>';
	
				$content .= '<div class="column1 columnlast">';
				$content .= '<p><span class="label">'.$this->lang->line('media').'</span>';
				if(strstr($this->directory.'/'.$this->file, '.swf')) {
					$content .= '<object type="application/x-shockwave-flash" data="'.base_url().$this->directory.'/'.$this->file.'" width="'.$width.'" height="'.$height.'" id="flash-'.$this->file.'"><param name="movie" value="'.base_url().$this->directory.'/'.$this->file.'" /></object>';
				} else {
					$content .= '<img src="'.base_url().$this->directory.'/'.$this->file.'" alt="'.$this->file.'" style="max-width:100%;" title="'.$this->file.'" />';
				}
				$content .= '</p>';
				$content .= '</div>';
	
				/*if(!is_dir($this->directory.'/'.$this->file)) {
					$sqlSelect = 'SELECT cmp.cmp_code, itm.itm_ispublished, itm.itm_title, itm.itm_code FROM '.$this->dtb->tables['itm'].' itm LEFT JOIN '.$this->dtb->tables['cmp'].' cmp ON cmp.cmp_id =itm.cmp_id WHERE itm.itm_summary LIKE \'%'.$this->directory.'/'.$this->file.'%\' OR itm.itm_content LIKE \'%'.$this->directory.'/'.$this->file.'%\' ORDER BY itm.itm_title ASC';
					$list = $this->dtb->query_select($sqlSelect);
					if($list['count'] != 0) {
						$content .= '<h2>'.$this->lang->line('media-used-by'].'</h2>
						<table>
						<thead>
						<th class="first">'.$this->lang->line('itm_code'].'</th>
						<th>'.$this->lang->line('itm_title'].'</th>
						<th>'.$this->lang->line('cmp_code'].'</th>
						<th>'.$this->lang->line('itm_ispublished'].'</th>
						</thead>
						<tbody>';
						for($i=0;$i<$list['count'];$i++) {
							$content .= '<tr>
							<td>'.$list['r']['itm_code'][$i].'</td>
							<td>'.$list['r']['itm_title'][$i].'</td>
							<td>'.$list['r']['cmp_code'][$i].'</td>
							<td>'.$this->lang->line('reply'][$list['r']['itm_ispublished'][$i]].'</td>
							</tr>';
						}
						$content .= '</tbody>
						</table>';
					}
				}*/
				$content .= '</div>
				</div>';
			} else {
				$this->err[] = $this->lang->line('noview');
			}
		} else {
			$this->err[] = $this->lang->line('nomedias');
		}
		$this->zones['content'] = $content;
	}
	public function thumbs() {
		$content = '';
		$content .= $this->breadcrumbs;
		$content .= '<div class="box1">
		<h1>'.$this->directory.'</h1>';
		/*$unorderedlist = array();
		$unorderedlist[] = '<a href="index.php?p='.$this->get['p'].'&amp;mode='.$this->get['mode'].'&amp;tinymce='.$this->get['tinymce'].'&amp;a=add&amp;dir='.$this->directory.'" title="'.$this->lang->line('add-file'].'">'.$this->lang->line('add-file'].'</a>';
		$unorderedlist[] = '<a href="index.php?p='.$this->get['p'].'&amp;mode='.$this->get['mode'].'&amp;tinymce='.$this->get['tinymce'].'&amp;a=add-directory&amp;dir='.$this->directory.'" title="'.$this->lang->line('add-directory'].'">'.$this->lang->line('add-directory'].'</a>';
		$unorderedlist[] = '<a href="index.php?p='.$this->get['p'].'&amp;mode='.$this->get['mode'].'&amp;tinymce='.$this->get['tinymce'].'&amp;a=list&amp;dir='.$this->directory.'&amp;mode=browse" title="'.$this->lang->line('browse-files'].'">'.$this->lang->line('browse-files'].'</a>';
		if($this->get['tinymce'] == 1) {
			$unorderedlist[] = '<a href="javascript:window.close();" title="'.$this->lang->line('close'].'">'.$this->lang->line('close'].'</a>';
		}
		$content .= $this->build_unorderedlist($unorderedlist);*/
		$content .= '<div class="display">';
		if(is_dir($this->directory)) {
			if($dh = opendir($this->directory)) {
				$folders = array();
				$files = array();
				while(($file = readdir($dh)) !== false) {
					if($file != '.' && $file != '..' && $file != 'index.php' && $file != 'index.html' && $file != '.svn' && $file != '.DS_Store') {
						if(is_dir($this->directory.'/'.$file)) {
							$folders[] = $file;
						} else {
							$files[] = $file;
						}
					}
				}
				sort($folders);
				sort($files);
				$medias = array_merge($folders, $files);
				$totalMedias = count($medias);
				if($this->directory_parent != '') {
					$content .= '<div class="thumb1"><div class="display">';
					if(file_exists('medias/icons/folder.png')) {
						$content .= '<a href="'.base_url().'axipi/core/medias/?directory='.$this->directory_parent.'"><img src="'.base_url().'medias/icons/folder.png" alt="" /></a><br />';
					}
					$content .= '<em><a href="'.base_url().'axipi/core/medias/?directory='.$this->directory_parent.'">'.$this->directory_parent.'</a><br />('.$this->lang->line('directory-up').')</em></div></div>';
				}
				if($totalMedias != 0) {
					foreach($medias as $file) {
						if(!in_array($file, $this->ext_excluded)) {
							if(is_dir($this->directory.'/'.$file)) {
								$isdir = 1;
							} else {
								$isdir = 0;
							}
							$children = 0;
							if($isdir == 1) {
								if($dh = opendir($this->directory.'/'.$file)) {
									while(($child = readdir($dh)) !== false) {
										if($child != '.' && $child != '..' && $child != 'index.php' && $child != 'index.html' && $child != '.svn' && $child != '.DS_Store') {
											$children++;
										}
									}
								}
								if($children == 0) {
									$filesize = $this->lang->line('empty-directory');
								} elseif($children == 1) {
									$filesize = sprintf($this->lang->line('count-item'), $children);
								} else {
									$filesize = sprintf($this->lang->line('count-items'), $children);
								}
							} else {
								$filesize = convert_size(filesize($this->directory.'/'.$file));
							}
							$filedate = date('Y-m-d H:i:s', filemtime($this->directory.'/'.$file));
							if(strstr($this->directory.'/'.$file, '.tar.gz')) {
								$fileextension = 'tar.gz';
							} else {
								$fileextension = strtolower(substr(strrchr($this->directory.'/'.$file, '.'), 1));
							}
							if(in_array($fileextension, $this->ext_size)) {
								list($width, $height, $type, $attr) = getimagesize($this->directory.'/'.$file);
							}
							$filedisplay = '';
							if($isdir == 1) {
								if(file_exists('medias/icons/folder.png')) {
									$filedisplay .= '<a href="'.base_url().$this->itm->itm_code.'/?directory='.urlencode($this->directory.'/'.$file).'"><img src="'.base_url().'medias/icons/folder.png" alt="" /></a><br />';
								}
								$filedisplay .= '<a href="'.base_url().$this->itm->itm_code.'/?directory='.urlencode($this->directory.'/'.$file).'">'.$file.'</a><br />'.$filesize;
							} else {
								if(in_array($fileextension, $this->ext_view)) {
									$filedisplay .= '<a href="'.base_url().$this->itm->itm_code.'/_read/?directory='.urlencode($this->directory).'&amp;file='.urlencode($file).'">';
								}
								$filedisplay .= $file;
								if(in_array($fileextension, $this->ext_view)) {
									$filedisplay .= '</a>';
								}
							}
							if($isdir == 1) {
								$content .= '<div class="thumb1">';
							} else {
								$content .= '<div class="thumb2">';
							}
							$content .= '<ul>';
							/*if($this->get['tinymce'] == 1 && in_array($fileextension, $this->ext_view)) {
								$unorderedlist[] = '<a href="#" onclick="mediaSelected(\''.$this->directory.'/'.$file.'\', \''.$width.'\', \''.$height.'\');" title="'.$this->lang->line('select').'">'.$this->lang->line('select-short').'</a>';
							}*/
							if(in_array($fileextension, $this->ext_view)) {
								$content .= '<li><a href="'.base_url().$this->itm->itm_code.'/_read/?directory='.urlencode($this->directory).'&amp;file='.urlencode($file).'">'.$this->lang->line('read').'</a></li>';
							}
							/*if($children == 0) {
								$unorderedlist[] = '<a class="delete" href="index.php?p='.$this->get['p'].'&amp;mode='.$this->get['mode'].'&amp;tinymce='.$this->get['tinymce'].'&amp;a=delete&amp;dir='.$this->directory.'&amp;file='.urlencode($file).'" title="'.$this->lang->line('delete').'">'.$this->lang->line('delete-short').'</a>';
							}*/
							$content .= '</ul>';
							$content .= '<div class="display">';
							if(in_array($fileextension, $this->ext_view)) {
								if($fileextension == 'swf') {
									$content .= '<object type="application/x-shockwave-flash" data="'.base_url().$this->directory.'/'.$file.'" style="max-height:140px;max-width:165px;" id="flash-'.$file.'">';
									$content .= '<param name="movie" value="'.base_url().$this->directory.'/'.$file.'" />';
									$content .= '</object><br />';
								} else {
									if(in_array($fileextension, $this->ext_view)) {
										$content .= '<a href="'.base_url().$this->itm->itm_code.'/_read/?directory='.urlencode($this->directory).'&amp;file='.urlencode($file).'">';
									}
									$content .= '<img src="'.base_url().$this->directory.'/'.$file.'" alt="'.$file.'" title="'.$file.'" style="max-height:140px;max-width:165px;" /><br />';
									if(in_array($fileextension, $this->ext_view)) {
										$content .= '</a>';
									}
								}
							}
							$content .= $filedisplay;
							if(in_array($fileextension, $this->ext_view)) {
								$content .= '<br /><em>'.$width.'x'.$height.'</em>';
							}
							$content .= '</div>';
							$content .= '</div>';
						}
					}
				}
			}
		}
		$content .= '</div>
		</div>';

		$this->zones['content'] = $content;
	}
}
