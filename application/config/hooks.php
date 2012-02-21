<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$hook['post_controller_constructor'][] = array(
'class'    => 'axipi_hook',
'function' => 'post_controller_constructor',
'filename' => 'axipi_hook.php',
'filepath' => 'hooks',
'params'   => array()
);

$hook['post_controller'][] = array(
'class'    => 'axipi_hook',
'function' => 'post_controller',
'filename' => 'axipi_hook.php',
'filepath' => 'hooks',
'params'   => array()
);
