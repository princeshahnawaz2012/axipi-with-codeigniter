<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('users'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('users'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('usr_email'), 'groups_users_usr_email'); ?><?php echo form_input('groups_users_usr_email', set_value('groups_users_usr_email', $this->session->userdata('groups_users_usr_email')), 'id="groups_users_usr_email" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<?php if($results) { ?>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php echo form_open(current_url()); ?>

<table>
<thead>
<tr>
<?php display_column('groups_users', $columns[0], $this->lang->line('usr_id')); ?>
<?php display_column('groups_users', $columns[1], $this->lang->line('usr_email')); ?>
<?php foreach($groups as $group) { ?>
<th><?php echo $group->grp_trl_title; ?></th>
<?php } ?>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;usr_id=<?php echo $result->usr_id;?>"><?php echo $result->usr_id;?></a></td>
<td><?php echo $result->usr_email; ?></td>
<?php foreach($groups as $group) { ?>
<?php if($result->usr_islocked == 1 && $group->grp_islocked == 1) { ?>
<td>-</td>
<?php } else { ?>
<td><?php echo form_checkbox($result->usr_id.$group->grp_id, 1, isset($groups_saved[$result->usr_id][$group->grp_id]), 'id="'.$result->usr_id.$group->grp_id.'" class="inputcheckbox"'); ?></td>
<?php } ?>
<?php } ?>
</tr>
<?php } ?>

</tbody>
</table>

<p><input class="inputsubmit" type="submit" name="submit_groups" id="submit_groups" value="<?php echo $this->lang->line('validate'); ?>"></p>

</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php } ?>

</div>
</div>
