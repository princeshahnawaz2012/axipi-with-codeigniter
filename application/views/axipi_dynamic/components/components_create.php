<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('components'); ?></a></li>
<li><?php echo $this->lang->line('create'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('component'); ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('create'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=create'); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('cmp_code').' *', 'cmp_code'); ?><?php echo form_input('cmp_code', set_value('cmp_code'), 'id="cmp_code" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('lay_code'), 'lay_id'); ?><?php echo form_dropdown('lay_id', $select_layout, set_value('lay_id'), 'id="lay_id" class="select"'); ?></p>
</div>

<div class="column1 columnlast">
<p><?php echo form_label($this->lang->line('cmp_ispage'), 'cmp_ispage'); ?><?php echo form_checkbox('cmp_ispage', 1, set_value('cmp_ispage'), 'id="cmp_ispage" class="inputcheckbox"'); ?></p>
<p><?php echo form_label($this->lang->line('cmp_iselement'), 'cmp_iselement'); ?><?php echo form_checkbox('cmp_iselement', 1, set_value('cmp_iselement'), 'id="cmp_iselement" class="inputcheckbox"'); ?></p>
<p><?php echo form_label($this->lang->line('cmp_isrelation'), 'cmp_isrelation'); ?><?php echo form_checkbox('cmp_isrelation', 1, set_value('cmp_isrelation'), 'id="cmp_isrelation" class="inputcheckbox"'); ?></p>
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
