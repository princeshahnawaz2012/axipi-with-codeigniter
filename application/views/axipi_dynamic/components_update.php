<?php
if($cmp) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('components'); ?></a></li>
<li><a href="<?php echo current_url(); ?>?a=view&amp;cmp_id=<?php echo $cmp[0]->cmp_id; ?>"><?php echo $cmp[0]->cmp_code; ?></a></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $cmp[0]->cmp_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;cmp_id='.$cmp[0]->cmp_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('cmp_code'), 'cmp_code'); ?><?php echo form_input('cmp_code', set_value('cmp_code', $cmp[0]->cmp_code), 'class="inputtext"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
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
