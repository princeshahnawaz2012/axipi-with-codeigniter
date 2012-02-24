<?php
if($zon) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $zon->zon_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=read&amp;zon_id=<?php echo $zon->zon_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;zon_id='.$zon->zon_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('lay_code').' *', 'lay_id'); ?><?php echo form_dropdown('lay_id', $select_layout, set_value('lay_id', $zon->lay_id), 'id="lay_id" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('zon_code').' *', 'zon_code'); ?><?php echo form_input('zon_code', set_value('zon_code', $zon->zon_code), 'id="zon_code" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('zon_ordering').' *', 'zon_ordering'); ?><?php echo form_input('zon_ordering', set_value('zon_ordering', $zon->zon_ordering), 'id="zon_ordering" class="inputtext numericfield"'); ?></p>
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
