<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('groups'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $grp->grp_code; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/<?php echo $grp->grp_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('grp_code').' *', 'grp_code'); ?><?php echo form_input('grp_code', set_value('grp_code', $grp->grp_code), 'id="grp_code" class="inputtext"'); ?></p>
</div>

<div class="column1 columnlast">
<p><?php echo form_label($this->lang->line('grp_isitem'), 'grp_isitem'); ?><?php echo form_checkbox('grp_isitem', 1, set_value('grp_isitem', $grp->grp_isitem), 'id="grp_isitem" class="inputcheckbox"'); ?></p>
<p><?php echo form_label($this->lang->line('grp_isuser'), 'grp_isuser'); ?><?php echo form_checkbox('grp_isuser', 1, set_value('grp_isuser', $grp->grp_isuser), 'id="grp_isuser" class="inputcheckbox"'); ?></p>
<p><?php echo form_label($this->lang->line('grp_ispermission'), 'grp_ispermission'); ?><?php echo form_checkbox('grp_ispermission', 1, set_value('grp_ispermission', $grp->grp_ispermission), 'id="grp_ispermission" class="inputcheckbox"'); ?></p>
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

<?php if($translations) { ?>
<?php foreach($translations as $trl) { ?>
<h2><?php echo $trl->lng_title; ?> (<?php echo $trl->lng_code; ?>)</h2>
<p><?php echo form_label($this->lang->line('grp_trl_title').' *', 'title'.$trl->lng_id); ?><?php echo form_input('title'.$trl->lng_id, set_value('title'.$trl->lng_id, $trl->grp_trl_title), 'id="title'.$trl->lng_id.'" class="inputtext"'); ?></p>
<?php } ?>
<?php } ?>

</form>

</div>
</div>
