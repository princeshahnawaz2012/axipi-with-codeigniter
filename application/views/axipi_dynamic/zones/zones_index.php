<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('zones'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(base_url().$this->itm->itm_code); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('zon_code'), 'zones_zon_code'); ?><?php echo form_input('zones_zon_code', set_value('zones_zon_code', $this->session->userdata('zones_zon_code')), 'id="zones_zon_code" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('lay_code'), 'zones_lay_id'); ?><?php echo form_dropdown('zones_lay_id', $select_layout, set_value('zones_lay_id', $this->session->userdata('zones_lay_id')), 'id="zones_lay_id" class="select"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<?php display_column(base_url().$this->itm->itm_code, 'zones', $columns[0], $this->lang->line('zon_id')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'zones', $columns[1], $this->lang->line('zon_code')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'zones', $columns[2], $this->lang->line('lay_code')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'zones', $columns[3], $this->lang->line('zon_ordering')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'zones', $columns[4], $this->lang->line('items')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/<?php echo $result->zon_id;?>"><?php echo $result->zon_id;?></a></td>
<td><?php echo $result->zon_code; ?></td>
<td><?php echo $result->lay_code; ?></td>
<td><?php echo $result->zon_ordering; ?></td>
<td><?php echo $result->count_items; ?></td>
<th>
<a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/<?php echo $result->zon_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->zon_islocked == 0) { ?><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/<?php echo $result->zon_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
</th>
</tr>
<?php } ?>

</tbody>
</table>

<div class="paging">
<?php echo $pagination; ?>
</div>

</div>
</div>
