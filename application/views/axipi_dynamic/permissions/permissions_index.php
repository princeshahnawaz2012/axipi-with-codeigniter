<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('permissions'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('permissions'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('per_code'), 'permissions_per_code'); ?><?php echo form_input('permissions_per_code', set_value('permissions_per_code', $this->session->userdata('permissions_per_code')), 'id="permissions_per_code" class="inputtext"'); ?></div>
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
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('per_id'); ?></a></th>
<th><?php echo $this->lang->line('per_code'); ?></th>
<th><?php echo $this->lang->line('groups'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;per_id=<?php echo $result->per_id;?>"><?php echo $result->per_id;?></a></td>
<td><?php echo $result->per_code; ?></td>
<td><?php echo $result->count_groups; ?><?php if($result->count_groups > 0) { ?> (<?php echo $result->groups; ?>)<?php } ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;per_id=<?php echo $result->per_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_groups == 0 && $result->per_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;per_id=<?php echo $result->per_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
