<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->itm->itm_title; ?></a></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->itm->itm_title; ?></h1>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('email').' *', 'email'); ?><?php echo form_input('email', set_value('email'), 'id="email" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('password').' *', 'password'); ?><?php echo form_password('password', set_value('password'), 'id="password" class="inputpassword"'); ?></p>
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
