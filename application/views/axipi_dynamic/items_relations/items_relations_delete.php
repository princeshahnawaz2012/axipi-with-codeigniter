<?php
if($rel) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('relations'); ?></a></li>
<li><?php echo $this->lang->line('delete'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $rel->itm_title; ?> (<?php echo $rel->itm_code; ?>) - <?php echo $itm->itm_title; ?> (<?php echo $itm->itm_code; ?>)</h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/?rel_id=<?php echo $rel->itm_id; ?>&amp;itm_id=<?php echo $itm->itm_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/?rel_id=<?php echo $rel->itm_id; ?>&amp;itm=<?php echo $itm->itm_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('delete'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?rel_id='.$rel->itm_id.'&amp;itm_id='.$itm->itm_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('confirm').' *', 'confirm'); ?><?php echo form_checkbox('confirm', 1, false, 'id="confirm" class="inputcheckbox"'); ?></p>
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
