<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('groups'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('groups'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('grp_code'), 'groups_grp_code'); ?><?php echo form_input('groups_grp_code', set_value('groups_grp_code', $this->session->userdata('groups_grp_code')), 'id="groups_grp_code" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('grp_id'); ?></a></th>
<th><?php echo $this->lang->line('grp_code'); ?></th>
<th><?php echo $this->lang->line('permissions'); ?></th>
<th><?php echo $this->lang->line('items'); ?></th>
<th><?php echo $this->lang->line('users'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;grp_id=<?php echo $result->grp_id;?>"><?php echo $result->grp_id;?></a></td>
<td><?php echo $result->grp_code; ?></td>
<td><?php echo $result->count_permissions; ?></td>
<td><?php echo $result->count_items; ?></td>
<td><?php echo $result->count_users; ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;grp_id=<?php echo $result->grp_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_items == 0 && $result->grp_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;grp_id=<?php echo $result->grp_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
