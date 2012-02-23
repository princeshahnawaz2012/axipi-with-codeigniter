<?php
if($per) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('permissions'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $per[0]->per_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=read&amp;per_id=<?php echo $per[0]->per_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;per_id='.$per[0]->per_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('per_code').' *', 'per_code'); ?><?php echo form_input('per_code', set_value('per_code', $per[0]->per_code), 'class="inputtext"'); ?></p>
</div>

<div class="column1 columnlast">
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
