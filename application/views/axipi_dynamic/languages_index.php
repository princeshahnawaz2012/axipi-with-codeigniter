<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('languages'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('languages'); ?></h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('lng_code'), 'languages_lng_code'); ?><?php echo form_input('languages_lng_code', set_value('languages_lng_code', $this->session->userdata('languages_lng_code')), 'class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('lng_id'); ?></a></th>
<th><?php echo $this->lang->line('lng_code'); ?></th>
<th><?php echo $this->lang->line('lng_title'); ?></th>
<th><?php echo $this->lang->line('items'); ?></th>
<th><?php echo $this->lang->line('users'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result):?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;lng_id=<?php echo $result->lng_id;?>"><?php echo $result->lng_id;?></a></td>
<td><?php echo $result->lng_code;?></td>
<td><?php echo $result->lng_title;?></td>
<td><?php echo $result->count_items;?></td>
<td><?php echo $result->count_users;?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;lng_id=<?php echo $result->lng_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_items == 0 && $result->lng_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;lng_id=<?php echo $result->lng_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
</th>
</tr>
<?php endforeach;?>

</tbody>
</table>

<div class="paging">
<?php echo $pagination; ?>
</div>

</div>
</div>