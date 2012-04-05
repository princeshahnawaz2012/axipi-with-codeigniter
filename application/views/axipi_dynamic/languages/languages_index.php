<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('languages'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('languages'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('lng_code'), 'languages_lng_code'); ?><?php echo form_input('languages_lng_code', set_value('languages_lng_code', $this->session->userdata('languages_lng_code')), 'id="languages_lng_code" class="inputtext"'); ?></div>
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
<?php display_column('languages', $columns[0], $this->lang->line('lng_id')); ?>
<?php display_column('languages', $columns[1], $this->lang->line('lng_code')); ?>
<?php display_column('languages', $columns[2], $this->lang->line('lng_title')); ?>
<?php display_column('languages', $columns[3], $this->lang->line('items')); ?>
<?php display_column('languages', $columns[4], $this->lang->line('users')); ?>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_read/?lng_id=<?php echo $result->lng_id;?>"><?php echo $result->lng_id;?></a></td>
<td><?php echo $result->lng_code; ?></td>
<td><?php echo $result->lng_title; ?></td>
<td><?php echo $result->count_items; ?></td>
<td><?php echo $result->count_users; ?></td>
<th>
<a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/?lng_id=<?php echo $result->lng_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_items == 0 && $result->lng_islocked == 0) { ?><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/?lng_id=<?php echo $result->lng_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
