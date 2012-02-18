<?php
if($itm) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>axipi/dynamic/items">items</a></li>
<li><a href="<?php echo base_url(); ?>axipi/dynamic/items?a=view&amp;itm_id=<?php echo $itm[0]->itm_id; ?>"><?php echo $itm[0]->itm_code; ?></a></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $itm[0]->itm_code; ?> / Update project</h1>
<ul>
<li><a href="<?php echo current_url(); ?>">Index</a></li>
</ul>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;itm_id='.$itm[0]->itm_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('sct_code'), 'sct_id'); ?><?php echo form_dropdown('sct_id', $select_section, set_value('sct_id', $itm[0]->sct_id), 'class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_code'), 'itm_code'); ?><?php echo form_input('itm_code', set_value('itm_code', $itm[0]->itm_code), 'class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('cmp_code'), 'cmp_id'); ?><?php echo form_dropdown('cmp_id', $select_component, set_value('cmp_id', $itm[0]->cmp_id), 'class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_content'), 'itm_content'); ?><?php echo form_textarea('itm_content', set_value('itm_content', $itm[0]->itm_content), 'class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('lng_code'), 'lng_id'); ?><?php echo form_dropdown('lng_id', $select_language, set_value('lng_id', $itm[0]->lng_id), 'class="select"'); ?></p>
</div>
<div class="column1 columnlast">
<p><input type="submit" name="submit" id="submit"></p>
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
