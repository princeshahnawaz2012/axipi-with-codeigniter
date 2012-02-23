<?php
if($usr) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('users'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $usr[0]->usr_email; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=update&amp;usr_id=<?php echo $usr[0]->usr_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('usr_email'); ?></span><?php echo $usr[0]->usr_email; ?></p>
</div>

<div class="column1 columnlast">
</div>

</div>
</div>

<?php
} else {
?>

<?php
}
?>
