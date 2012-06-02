<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('hosts'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('hosts'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(base_url().$this->itm->itm_code); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('hst_code'), 'hosts_hst_code'); ?><?php echo form_input('hosts_hst_code', set_value('hosts_hst_code', $this->session->userdata('hosts_hst_code')), 'id="hosts_hst_code" class="inputtext"'); ?></div>
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
<?php display_column(base_url().$this->itm->itm_code, 'hosts', $columns[0], $this->lang->line('hst_id')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'hosts', $columns[1], $this->lang->line('hst_code')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'hosts', $columns[2], $this->lang->line('hst_url')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'hosts', $columns[3], $this->lang->line('hst_environment')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'hosts', $columns[4], $this->lang->line('hst_gzhandler')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'hosts', $columns[5], $this->lang->line('hst_debug')); ?>
<?php display_column(base_url().$this->itm->itm_code, 'hosts', $columns[6], $this->lang->line('lay_code')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/<?php echo $result->hst_id;?>"><?php echo $result->hst_id;?></a></td>
<td><?php echo $result->hst_code; ?></td>
<td><?php echo $result->hst_url; ?></td>
<td><?php echo $result->hst_environment; ?></td>
<td><?php echo $this->lang->line('reply_'.$result->hst_gzhandler); ?></td>
<td><?php echo $this->lang->line('reply_'.$result->hst_debug); ?></td>
<td><?php echo $result->lay_code; ?></td>
<th>
<a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/<?php echo $result->hst_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->hst_islocked == 0) { ?><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/<?php echo $result->hst_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
