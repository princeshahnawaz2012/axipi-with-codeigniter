<?php
if($stg) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('settings'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $stg->stg_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=read&amp;stg_id=<?php echo $stg->stg_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;stg_id='.$stg->stg_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('stg_code').' *', 'stg_code'); ?><?php echo form_input('stg_code', set_value('stg_code', $stg->stg_code), 'id="stg_code" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('stg_value'), 'stg_value'); ?><?php echo form_input('stg_value', set_value('stg_value', $stg->stg_value), 'id="stg_value" class="inputtext"'); ?></p>
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
