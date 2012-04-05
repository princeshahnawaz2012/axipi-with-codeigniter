<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('components'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('components'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(base_url().$this->itm->itm_code); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('cmp_code'), 'components_cmp_code'); ?><?php echo form_input('components_cmp_code', set_value('components_cmp_code', $this->session->userdata('components_cmp_code')), 'id="components_cmp_code" class="inputtext"'); ?></div>
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
<?php display_column('components', $columns[0], $this->lang->line('cmp_id')); ?>
<?php display_column('components', $columns[1], $this->lang->line('cmp_code')); ?>
<?php display_column('components', $columns[2], $this->lang->line('lay_code')); ?>
<?php display_column('components', $columns[3], $this->lang->line('cmp_ispage')); ?>
<?php display_column('components', $columns[4], $this->lang->line('cmp_iselement')); ?>
<?php display_column('components', $columns[5], $this->lang->line('cmp_isrelation')); ?>
<?php display_column('components', $columns[6], $this->lang->line('items')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/?cmp_id=<?php echo $result->cmp_id;?>"><?php echo $result->cmp_id;?></a></td>
<td><?php echo $result->cmp_code; ?></td>
<td><?php echo $result->lay_code; ?></td>
<td><?php echo $this->lang->line('reply_'.$result->cmp_ispage); ?></td>
<td><?php echo $this->lang->line('reply_'.$result->cmp_iselement); ?></td>
<td><?php echo $this->lang->line('reply_'.$result->cmp_isrelation); ?></td>
<td><?php echo $result->count_items; ?></td>
<th>
<a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/?cmp_id=<?php echo $result->cmp_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_items == 0 && $result->cmp_islocked == 0) { ?><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/?cmp_id=<?php echo $result->cmp_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
