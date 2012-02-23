<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('layouts'); ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('layouts'); ?></h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('lay_code'), 'layouts_lay_code'); ?><?php echo form_input('layouts_lay_code', set_value('layouts_lay_code', $this->session->userdata('layouts_lay_code')), 'class="inputtext"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('lay_id'); ?></a></th>
<th><?php echo $this->lang->line('lay_code'); ?></th>
<th><?php echo $this->lang->line('lay_type'); ?></th>
<th><?php echo $this->lang->line('sections'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result):?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;lay_id=<?php echo $result->lay_id;?>"><?php echo $result->lay_id;?></a></td>
<td><?php echo $result->lay_code; ?></td>
<td><?php echo $result->lay_type; ?></td>
<td><?php echo $result->count_sections; ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;lay_id=<?php echo $result->lay_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($result->count_sections == 0 && $result->lay_islocked == 0) { ?><a href="<?php echo current_url(); ?>?a=delete&amp;lay_id=<?php echo $result->lay_id;?>"><?php echo $this->lang->line('delete'); ?></a><?php } ?>
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
