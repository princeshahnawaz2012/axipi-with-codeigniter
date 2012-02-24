<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('countries'); ?></a></li>
<li><?php echo $this->lang->line('create'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('country'); ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('create'); ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=create'); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('cou_alpha2').' *', 'cou_alpha2'); ?><?php echo form_input('cou_alpha2', set_value('cou_alpha2'), 'id="cou_alpha2" class="inputtext"'); ?></p>
<p><?php echo form_label($this->lang->line('cou_alpha3').' *', 'cou_alpha3'); ?><?php echo form_input('cou_alpha3', set_value('cou_alpha3'), 'id="cou_alpha3" class="inputtext"'); ?></p>
</div>

<div class="column1 columnlast">
<p><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></p>
</div>

</form>

</div>
</div>
