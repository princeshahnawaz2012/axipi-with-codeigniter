<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('groups'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('groups'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('grp_code'), 'groups_grp_code'); ?><?php echo form_input('groups_grp_code', set_value('groups_grp_code', $this->session->userdata('groups_grp_code')), 'id="groups_grp_code" class="inputtext"'); ?></div>
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
<?php display_column('groups', $columns[0], $this->lang->line('grp_id')); ?>
<?php display_column('groups', $columns[1], $this->lang->line('grp_code')); ?>
<?php display_column('groups', $columns[2], $this->lang->line('permissions')); ?>
<?php display_column('groups', $columns[3], $this->lang->line('items')); ?>
<?php display_column('groups', $columns[4], $this->lang->line('users')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/?grp_id=<?php echo $result->grp_id;?>"><?php echo $result->grp_id;?></a></td>
<td><?php echo $result->grp_code; ?></td>
<td><?php echo $result->count_permissions; ?></td>
<td><?php echo $result->count_items; ?></td>
<td><?php echo $result->count_users; ?></td>
<th>
<a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/?grp_id=<?php echo $result->grp_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_items == 0 && $result->grp_islocked == 0) { ?><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/?grp_id=<?php echo $result->grp_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
