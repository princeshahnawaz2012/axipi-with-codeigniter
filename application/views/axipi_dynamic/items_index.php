<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('items'); ?></a></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->lang->line('items'); ?></h1>
<ul>
<li class="first"><a class="add" href="<?php echo current_url(); ?>?a=add"><?php echo $this->lang->line('add'); ?></a></li>
</ul>
<div class="display">

<div class="paging">
<?php echo $pagination; ?>
</div>
<table>
<thead>
<tr>
<th><?php echo $this->lang->line('itm_id'); ?></th>
<th><?php echo $this->lang->line('itm_code'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php foreach($items as $itm):?>

<tr>
<td><a href="<?php echo current_url(); ?>?a=view&amp;itm_id=<?php echo $itm->itm_id;?>"><?php echo $itm->itm_id;?></a></td>
<td><?php echo $itm->itm_code;?></td>
<th><a href="<?php echo current_url(); ?>?a=update&amp;itm_id=<?php echo $itm->itm_id;?>"><?php echo $this->lang->line('update'); ?></a>
<?php if($itm->count_children == 0) { ?>
<a href="<?php echo current_url(); ?>?a=delete&amp;itm_id=<?php echo $itm->itm_id;?>"><?php echo $this->lang->line('delete'); ?></a>
<?php } ?></th>
</tr>

<?php endforeach;?>
</tbody>
</table>
<div class="paging">
<?php echo $pagination; ?>
</div>

</div>
</div>
