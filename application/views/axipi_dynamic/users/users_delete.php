<?php
if($usr) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('users'); ?></a></li>
<li><?php echo $this->lang->line('delete'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $usr[0]->usr_email; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=update&amp;usr_id=<?php echo $usr[0]->usr_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo current_url(); ?>?a=read&amp;usr_id=<?php echo $usr[0]->usr_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('delete'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=delete&amp;usr_id='.$usr[0]->usr_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('confirm').' *', 'confirm'); ?><?php echo form_checkbox('confirm', 1, false, 'class="inputcheckbox"'); ?></p>
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>

<?php
} else {
?>

<?php
}
?>