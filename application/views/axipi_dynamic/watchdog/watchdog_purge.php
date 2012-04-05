<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->itm->itm_title; ?></a></li>
<li><?php echo $this->lang->line('delete'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->itm->itm_title; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('cancel'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('purge'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('confirm').' *', 'confirm'); ?><?php echo form_checkbox('confirm', 1, false, 'id="confirm" class="inputcheckbox"'); ?></p>
<p><?php echo form_label($this->lang->line('days').' *', 'days'); ?><?php echo form_input('days', set_value('days', 0), 'id="days" class="inputtext numericfield"'); ?></p>
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
