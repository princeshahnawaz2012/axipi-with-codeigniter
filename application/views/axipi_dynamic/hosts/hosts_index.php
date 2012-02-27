<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('hosts'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('hosts'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
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
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('hst_id'); ?></a></th>
<th><?php echo $this->lang->line('hst_code'); ?></th>
<th><?php echo $this->lang->line('hst_url'); ?></th>
<th><?php echo $this->lang->line('hst_environment'); ?></th>
<th><?php echo $this->lang->line('hst_gzhandler'); ?></th>
<th><?php echo $this->lang->line('hst_debug'); ?></th>
<th><?php echo $this->lang->line('lay_code'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;hst_id=<?php echo $result->hst_id;?>"><?php echo $result->hst_id;?></a></td>
<td><?php echo $result->hst_code; ?></td>
<td><?php echo $result->hst_url; ?></td>
<td><?php echo $result->hst_environment; ?></td>
<td><?php echo $result->hst_gzhandler; ?></td>
<td><?php echo $result->hst_debug; ?></td>
<td><?php echo $result->lay_code; ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;hst_id=<?php echo $result->hst_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->hst_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;hst_id=<?php echo $result->hst_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
