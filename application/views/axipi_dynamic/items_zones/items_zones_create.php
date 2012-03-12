<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('create'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $zon->lay_code; ?> - <?php echo $zon->zon_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('create'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=create&amp;zon_id='.$zon->zon_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('itm_code').' *', 'itm_id'); ?><?php echo form_dropdown('itm_id', $select_item, set_value('itm_id'), 'id="itm_id" class="select"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_zon_ordering').' *', 'itm_zon_ordering'); ?><?php echo form_input('itm_zon_ordering', set_value('itm_zon_ordering', 0), 'id="itm_zon_ordering" class="inputtext numericfield"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
