<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('create'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $rel->itm_title; ?> (<?php echo $rel->itm_code; ?>)</h1>
<ul>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('create'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=create&amp;rel_id='.$rel->itm_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('itm_rel_parent'), 'itm_rel_parent'); ?><?php echo form_dropdown('itm_rel_parent', $select_item_parent, set_value('itm_rel_parent'), 'id="itm_rel_parent" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_code').' *', 'itm_id'); ?><?php echo form_dropdown('itm_id', $select_item, set_value('itm_id'), 'id="itm_rel_parent" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_rel_title'), 'itm_rel_title'); ?><?php echo form_input('itm_rel_title', set_value('itm_rel_title'), 'id="itm_rel_title" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_rel_ordering').' *', 'itm_rel_ordering'); ?><?php echo form_input('itm_rel_ordering', set_value('itm_rel_ordering', 0), 'id="itm_rel_ordering" class="inputtext numericfield"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
