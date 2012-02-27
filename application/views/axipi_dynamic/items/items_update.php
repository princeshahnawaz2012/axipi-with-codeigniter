<?php
if($itm) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('items'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $itm->itm_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=read&amp;itm_id=<?php echo $itm->itm_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;itm_id='.$itm->itm_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('sct_code').' *', 'sct_id'); ?><?php echo form_dropdown('sct_id', $select_section, set_value('sct_id', $itm->sct_id), 'id="sct_id" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_parent'), 'itm_parent'); ?><?php echo form_dropdown('itm_parent', $select_item_parent, set_value('itm_parent', $itm->itm_parent), 'id="itm_parent" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_code'), 'itm_code'); ?><?php echo form_input('itm_code', set_value('itm_code', $itm->itm_code), 'id="itm_code" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_virtualcode'), 'itm_virtualcode'); ?><?php echo form_input('itm_virtualcode', set_value('itm_virtualcode', $itm->itm_virtualcode), 'id="itm_virtualcode" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_title').' *', 'itm_title'); ?><?php echo form_input('itm_title', set_value('', $itm->itm_title), 'id="itm_title" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('cmp_code').' *', 'cmp_id'); ?><?php echo form_dropdown('cmp_id', $select_component, set_value('', $itm->cmp_id), 'id="cmp_id" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_content'), 'itm_content'); ?><?php echo form_textarea('itm_content', set_value('itm_content', $itm->itm_content), 'id="itm_content" class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_summary'), 'itm_summary'); ?><?php echo form_textarea('itm_summary', set_value('', $itm->itm_summary), 'id="itm_summary" class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_link'), 'itm_link'); ?><?php echo form_input('itm_link', set_value('itm_link', $itm->itm_link), 'id="itm_link" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_publishstartdate'), 'itm_publishstartdate'); ?><?php echo form_input('itm_publishstartdate', set_value('itm_publishstartdate', $itm->itm_publishstartdate), 'id="itm_publishstartdate" class="inputtext datefield"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_publishstarttime'), 'itm_publishstarttime'); ?><?php echo form_input('itm_publishstarttime', set_value('itm_publishstarttime', $itm->itm_publishstarttime), 'id="itm_publishstarttime" class="inputtext timefield"'); ?></p>
</div>

<div class="column1 columnlast">
<p><?php echo form_label($this->lang->line('itm_description'), 'itm_description'); ?><?php echo form_textarea('itm_description', set_value('itm_description', $itm->itm_description), 'id="itm_description" class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_keywords'), 'itm_keywords'); ?><?php echo form_textarea('itm_keywords', set_value('itm_keywords', $itm->itm_keywords), 'id="itm_keywords" class="textarea"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_ordering').' *', 'itm_ordering'); ?><?php echo form_input('itm_ordering', set_value('itm_ordering', $itm->itm_ordering), 'id="itm_ordering" class="inputtext numericfield"'); ?></p>
<p><?php echo form_label($this->lang->line('lng_code').' *', 'lng_id'); ?><?php echo form_dropdown('lng_id', $select_language, set_value('lng_id', $itm->lng_id), 'id="lng_id" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('lay_code'), 'lay_id'); ?><?php echo form_dropdown('lay_id', $select_layout, set_value('lay_id', $itm->lay_id), 'id="lay_id" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_access').' *', 'itm_access'); ?><?php echo form_dropdown('itm_access', $this->lang->line('itm_access_values'), set_value('itm_access', $itm->itm_access), 'id="itm_access" class="select"'); ?></p>
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
