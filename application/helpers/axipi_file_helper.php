<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function fileperms_test($file) {
	$perms = fileperms($file);
	$fileperms = '0'.substr(sprintf('%o', $perms), -3);
	return $fileperms;
}
function convert_size($b) {
	$size_giga = 1073741824;
	$size_mega = 1048576;
	$size_kilo = 1024;
	$r = '';
	if($b >= $size_giga) {
		$giga = floor($b/$size_giga);
		$b = $b%$size_giga;
		$r .= $giga;
		$r .= 'gb';
		if($b > 0) {
			$r .= ' ';
		}
	}
	if($b >= $size_mega) {
		$mega = floor($b/$size_mega);
		$b = $b%$size_mega;
		$r .= $mega;
		$r .= 'mb';
		if($b > 0) {
			$r .= ' ';
		}
	}
	if($b >= $size_kilo) {
		$kilo = ceil($b/$size_kilo);
		$b = $b%$size_kilo;
		$r .= $kilo;
		$r .= 'kb';
		if($b > 0) {
			$r .= ' ';
		}
	}
	if($b < $size_kilo && $b > 0) {
		$r .= $b.' ';
		$r .= 'b';
	}
	if($b == 0 && $r == '') {
		$r .= '-';
	}
	return $r;
}
function directory_size($location, $recursive = 1) {
	$size = 0;
	if(is_dir($location)) {
		$dir = opendir($location);
		while($file = readdir($dir)) {
			if($file != '.' && $file != '..' && $file != '.htaccess' && $file != 'index.html' && $file != '.DS_Store' && $file != 'Thumbs.db' && $file != 'index.php' && $file != '.svn') {
				if(@is_dir($location.'/'.$file)) {
					$size += $recursive ? directory_size($location.'/'.$file) : 0;
				} else {
					$size += filesize($location.'/'.$file);
				}
			}
		}
		closedir($dir);
		return $size;
	}
}
function directory_files($location, $recursive = 1, $remove = '') {
	if(is_dir($location)) {
		$dir = opendir($location);
		while($file = readdir($dir)) {
			if(!in_array($file, exclude)) {
				if(@is_dir($location.'/'.$file)) {
					directory_files($location.'/'.$file, $recursive, $remove);
				} else {
					$files[] = substr(str_replace($remove, '', $location).'/'.$file, 1);
				}
			}
		}
		closedir($dir);
	}
}
function directory_files_count($location, $recursive = 1, $remove = '') {
	$files_count = 0;
	if(is_dir($location)) {
		$dir = opendir($location);
		while($file = readdir($dir)) {
			if(!in_array($file, exclude)) {
				if(@is_dir($location.'/'.$file)) {
					$files_count += directory_files_count($location.'/'.$file, $recursive, $remove);
				} else {
					$files_count++;
				}
			}
		}
		closedir($dir);
	}
	return $files_count;
}
function directory_chmod($location, $mode = 0755, $recursive = 1) {
	$files_count = 0;
	if(is_dir($location)) {
		chmod($location, $mode);
		$dir = opendir($location);
		while($file = readdir($dir)) {
			if($file != '.' && $file != '..') {
				if(@is_dir($location.'/'.$file)) {
					directory_chmod($location.'/'.$file, $mode, $recursive);
				}
				chmod($location.'/'.$file, $mode);
			}
		}
		closedir($dir);
	}
}
