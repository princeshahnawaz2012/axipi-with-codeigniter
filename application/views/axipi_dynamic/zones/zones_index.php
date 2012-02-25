<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('zones'); ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('zon_code'), 'zones_zon_code'); ?><?php echo form_input('zones_zon_code', set_value('zones_zon_code', $this->session->userdata('zones_zon_code')), 'id="zones_zon_code" class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('zon_id'); ?></a></th>
<th><?php echo $this->lang->line('zon_code'); ?></th>
<th><?php echo $this->lang->line('lay_code'); ?></th>
<th><?php echo $this->lang->line('zon_ordering'); ?></th>
<th><?php echo $this->lang->line('items'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;zon_id=<?php echo $result->zon_id;?>"><?php echo $result->zon_id;?></a></td>
<td><?php echo $result->zon_code; ?></td>
<td><?php echo $result->lay_code; ?></td>
<td><?php echo $result->zon_ordering; ?></td>
<td><?php echo $result->count_items; ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;zon_id=<?php echo $result->zon_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->zon_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;zon_id=<?php echo $result->zon_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
