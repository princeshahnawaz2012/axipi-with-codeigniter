<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('update'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $zon->lay_code; ?> - <?php echo $zon->zon_code; ?> - <?php echo $itm->itm_code; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/<?php echo $zon->zon_id; ?>/<?php echo $itm->itm_id; ?>"><?php echo $this->lang->line('read'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('update'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url()); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('itm_zon_ordering').' *', 'itm_zon_ordering'); ?><?php echo form_input('itm_zon_ordering', set_value('itm_zon_ordering', $itm_zon->itm_zon_ordering), 'id="itm_zon_ordering" class="inputtext numericfield"'); ?></p>
<p><?php echo form_label($this->lang->line('itm_zon_ispublished'), 'itm_zon_ispublished'); ?><?php echo form_checkbox('itm_zon_ispublished', 1, set_value('itm_zon_ispublished', $itm_zon->itm_zon_ispublished), 'id="itm_zon_ispublished" class="inputcheckbox"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
