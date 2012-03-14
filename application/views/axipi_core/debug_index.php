<div class="box1">
<h1><?php echo $this->lang->line('debug'); ?></h1>
<div class="display">

<div class="column1">
<fieldset><legend><?php echo $this->lang->line('debug_client'); ?></legend>
<?php if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) == 1) { ?><p><span class="label">HTTP_X_CLUSTER_CLIENT_IP</span><?php echo $_SERVER['HTTP_X_CLUSTER_CLIENT_IP']; ?></p><?php } ?>
<?php if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) == 1) { ?><p><span class="label">HTTP_X_FORWARDED_FOR</span><?php echo $_SERVER['HTTP_X_FORWARDED_FOR']; ?></p><?php } ?>
<?php if(isset($_SERVER['HTTP_CLIENT_IP']) == 1) { ?><p><span class="label">HTTP_CLIENT_IP</span><?php echo $_SERVER['HTTP_CLIENT_IP']; ?></p><?php } ?>
<?php if(isset($_SERVER['REMOTE_ADDR']) == 1) { ?><p><span class="label">REMOTE_ADDR</span><?php echo $_SERVER['REMOTE_ADDR']; ?></p><?php } ?>
<?php if(isset($_SERVER['REMOTE_HOST']) == 1) { ?><p><span class="label">REMOTE_HOST</span><?php echo $_SERVER['REMOTE_HOST']; ?></p><?php } ?>
<p><span class="label">HTTP_USER_AGENT</span><?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
<p><span class="label">HTTP_ACCEPT_LANGUAGE</span><?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE']; ?></p>
</fieldset>

<fieldset><legend><?php echo $this->lang->line('debug_server'); ?></legend>
<p><span class="label"><?php echo $this->lang->line('debug_datetimeutc'); ?></span><?php echo gmdate('Y-m-d H:i:s'); ?></p>
<p><span class="label">PHP_OS</span><?php echo PHP_OS; ?></p>
<p><span class="label">SERVER_ADDR</span><?php echo $_SERVER['SERVER_ADDR']; ?></p>
<p><span class="label">HTTP_HOST</span><?php echo $_SERVER['HTTP_HOST']; ?></p>
<p><span class="label">SERVER_NAME</span><?php echo $_SERVER['SERVER_NAME']; ?></p>
<?php if(isset($_SERVER['HTTPS']) == 1) { ?><p><span class="label">HTTPS</span><?php echo $_SERVER['HTTPS']; ?></p><?php } ?>
</fieldset>

<fieldset><legend><?php echo $this->lang->line('debug_webserver'); ?></legend>
<p><span class="label">SERVER_SOFTWARE</span><?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
<p><span class="label">DOCUMENT_ROOT</span><?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
<p><span class="label">PHP_SELF</span><?php echo $_SERVER['PHP_SELF']; ?></p>
<p><span class="label">QUERY_STRING</span><?php echo $_SERVER['QUERY_STRING']; ?></p>
<p><span class="label">REQUEST_URI</span><?php echo $_SERVER['REQUEST_URI']; ?></p>
<?php if(function_exists('apache_get_modules')) { ?><p><span class="label">apache_get_modules</span><?php echo implode(', ', apache_get_modules()); ?></p><?php } ?>
<?php if(function_exists('apache_request_headers')) { ?><p><span class="label">apache_request_headers</span><textarea class="textareabigger"><?php echo print_r(apache_request_headers(), 1); ?></textarea></p><?php } ?>
<?php if(function_exists('apache_response_headers')) { ?><p><span class="label">apache_response_headers</span><textarea class="textareabigger"><?php echo print_r(apache_response_headers(), 1); ?></textarea></p><?php } ?>
</fieldset>

<fieldset><legend><?php echo $this->lang->line('debug_database'); ?></legend>
<p><span class="label">dbdriver</span><?php echo $this->db->dbdriver; ?></p>
<p><span class="label">client_info</span><?php echo $this->db->conn_id->client_info; ?></p>
<p><span class="label">host_info</span><?php echo $this->db->conn_id->host_info; ?></p>
<p><span class="label">server_info</span><?php echo $this->db->conn_id->server_info; ?></p>
<?php if(isset($this->db->conn_id->stat) == 1) { ?><p><span class="label">stat</span><?php echo $this->db->conn_id->stat; ?></p><?php } ?>
</fieldset>

</div>

<div class="column1 columnlast">
<fieldset><legend><?php echo $this->lang->line('debug_language'); ?></legend>
<p><span class="label">phpversion</span><?php echo phpversion(); ?></p>
<p><span class="label">php_sapi_name</span><?php echo php_sapi_name(); ?></p>
<p><span class="label">get_current_user</span><?php echo get_current_user(); ?></p>
<?php if(function_exists('posix_getpwuid') && function_exists('posix_geteuid')) {$processUser = posix_getpwuid(posix_geteuid()); ?><p><span class="label">posix_getpwuid</span><?php echo implode(', ', $processUser); ?></p><?php } ?>
<p><span class="label">session_id</span><?php echo $this->session->userdata('session_id'); ?></p>
<p><span class="label">sess_cookie_name</span><?php echo $this->config->item('sess_cookie_name'); ?></p>
<p><span class="label">sess_expiration</span><?php echo $this->config->item('sess_expiration'); ?></p>

<p><span class="label">file_uploads</span><?php echo ini_get('file_uploads'); ?></p>
<p><span class="label">upload_max_filesize</span><?php echo ini_get('upload_max_filesize'); ?></p>
<p><span class="label">post_max_size</span><?php echo ini_get('post_max_size'); ?></p>
<p><span class="label">memory_limit</span><?php echo ini_get('memory_limit'); ?></p>
<?php $safe_mode = ini_get('safe_mode');if($safe_mode != '') { ?><p><span class="label">safe_mode</span><?php echo $safe_mode; ?></p><?php } ?>
<?php $open_basedir = ini_get('open_basedir');if($open_basedir != '') { ?><p><span class="label">open_basedir</span><?php echo $open_basedir; ?></p><?php } ?>
<?php if(function_exists('sys_get_temp_dir')) { ?><p><span class="label">sys_get_temp_dir</span><?php echo sys_get_temp_dir(); ?></p><?php } ?>
<?php $extensions = get_loaded_extensions();sort($extensions); ?><p><span class="label">get_loaded_extensions</span><?php echo implode(', ', $extensions); ?></p>

<p><span class="label">get_included_files</span><?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', implode('<br />', get_included_files())); ?></p>
<p><span class="label">get_declared_classes</span><?php echo implode(', ', get_declared_classes()); ?></p>

<p><span class="label">$_COOKIE</span><textarea class="textareabigger"><?php echo print_r($_COOKIE, 1); ?></textarea></p>
<p><span class="label">$_SERVER</span><textarea class="textareabigger"><?php echo print_r($_SERVER, 1); ?></textarea></p>

</fieldset>
</div>

</div>
</div>
