<?php
if($sct) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('sections'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $sct->sct_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=read&amp;sct_id=<?php echo $sct->sct_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;sct_id='.$sct->sct_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('sct_code').' *', 'sct_code'); ?><?php echo form_input('sct_code', set_value('sct_code', $sct->sct_code), 'id="sct_code" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('lay_code').' *', 'lay_id'); ?><?php echo form_dropdown('lay_id', $select_layout, set_value('lay_id', $sct->lay_id), 'id="lay_id" class="select"'); ?></p>
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
