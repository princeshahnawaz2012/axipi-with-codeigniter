<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('layouts'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('layouts'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(base_url().$this->itm->itm_code); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('lay_code'), 'layouts_lay_code'); ?><?php echo form_input('layouts_lay_code', set_value('layouts_lay_code', $this->session->userdata('layouts_lay_code')), 'id="layouts_lay_code" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<?php display_column(base_url().$this->itm->itm_code, 'layouts', $columns[0], $this->lang->line('lay_id')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'layouts', $columns[1], $this->lang->line('lay_code')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'layouts', $columns[2], $this->lang->line('lay_type')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'layouts', $columns[3], $this->lang->line('sections')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/<?php echo $result->lay_id;?>"><?php echo $result->lay_id;?></a></td>
<td><?php echo $result->lay_code; ?></td>
<td><?php echo $result->lay_type; ?></td>
<td><?php echo $result->count_sections; ?></td>
<th>
<a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/<?php echo $result->lay_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_sections == 0 && $result->lay_islocked == 0) { ?><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/<?php echo $result->lay_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
</th>
</tr>
<?php } ?>

</tbody>
</table>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php } ?>

</div>
</div>
