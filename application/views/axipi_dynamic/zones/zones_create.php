<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('create'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('zone'); ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('create'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=create'); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('lay_code').' *', 'lay_id'); ?><?php echo form_dropdown('lay_id', $select_layout, set_value('lay_id'), 'id="lay_id" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('zon_code').' *', 'zon_code'); ?><?php echo form_input('zon_code', set_value('zon_code'), 'id="zon_code" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('zon_ordering').' *', 'zon_ordering'); ?><?php echo form_input('zon_ordering', set_value('zon_ordering', 0), 'id="zon_ordering" class="inputtext numericfield"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

<?php if($translations) { ?>
<?php foreach($translations as $trl) { ?>
<h2><?php echo $trl->lng_title; ?> (<?php echo $trl->lng_code; ?>)</h2>
<p><?php echo form_label($this->lang->line('trl_zon_title').' *', 'title'.$trl->lng_id); ?><?php echo form_input('title'.$trl->lng_id, set_value('title'.$trl->lng_id, $trl->trl_zon_title), 'id="title'.$trl->lng_id.'" class="inputtext"'); ?></p>
<?php } ?>
<?php } ?>

</form>

</div>
</div>
