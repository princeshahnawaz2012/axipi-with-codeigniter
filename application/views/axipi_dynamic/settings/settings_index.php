<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('settings'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('settings'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('stg_code'), 'settings_stg_code'); ?><?php echo form_input('settings_stg_code', set_value('settings_stg_code', $this->session->userdata('settings_stg_code')), 'id="settings_stg_code" class="inputtext"'); ?></div>
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
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('stg_id'); ?></a></th>
<th><?php echo $this->lang->line('stg_code'); ?></th>
<th><?php echo $this->lang->line('stg_value'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;stg_id=<?php echo $result->stg_id;?>"><?php echo $result->stg_id;?></a></td>
<td><?php echo $result->stg_code; ?></td>
<td><?php echo $result->stg_value; ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;stg_id=<?php echo $result->stg_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->stg_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;stg_id=<?php echo $result->stg_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
