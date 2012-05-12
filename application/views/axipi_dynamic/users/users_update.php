<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('users'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $usr->usr_email; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/<?php echo $usr->usr_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<div class="column1">
<fieldset>
<p><?php echo form_label($this->lang->line('usr_email').' *', 'usr_email'); ?><?php echo form_input('usr_email', set_value('usr_email', $usr->usr_email), 'id="usr_email" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('usr_emailconfirm').' *', 'usr_emailconfirm'); ?><?php echo form_input('usr_emailconfirm', set_value('usr_emailconfirm', $usr->usr_email), 'id="usr_emailconfirm" class="inputtext"'); ?></p>
</fieldset>
<fieldset>
<legend><?php echo $this->lang->line('password_change'); ?></legend>
<p><?php echo form_label($this->lang->line('usr_password'), 'usr_password'); ?><?php echo form_password('usr_password', set_value('usr_password'), 'id="usr_password" class="inputpassword"'); ?></p>
<p><?php echo form_label($this->lang->line('usr_passwordconfirm'), 'usr_passwordconfirm'); ?><?php echo form_password('usr_passwordconfirm', set_value('usr_passwordconfirm'), 'id="usr_passwordconfirm" class="inputpassword"'); ?></p>
</fieldset>
<p><?php echo form_label($this->lang->line('usr_firstname'), 'usr_firstname'); ?><?php echo form_input('usr_firstname', set_value('usr_firstname', $usr->usr_firstname), 'id="usr_firstname" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('usr_lastname'), 'usr_lastname'); ?><?php echo form_input('usr_lastname', set_value('usr_lastname', $usr->usr_lastname), 'id="usr_lastname" class="inputtext"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
