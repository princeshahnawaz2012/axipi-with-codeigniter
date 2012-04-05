<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('languages'); ?></a></li>
<li><?php echo $this->lang->line('create'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('language'); ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('create'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('lng_code').' *', 'lng_code'); ?><?php echo form_input('lng_code', set_value('lng_code'), 'id="lng_code" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('lng_title').' *', 'lng_title'); ?><?php echo form_input('lng_title', set_value('lng_title'), 'id="lng_title" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('lng_defaultitem').' *', 'lng_defaultitem'); ?><?php echo form_dropdown('lng_defaultitem', $select_lng_defaultitem, set_value('lng_defaultitem'), 'id="defaultitem'.'" class="select"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
