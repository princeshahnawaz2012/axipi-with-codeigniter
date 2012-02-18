<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>projects">Projects</a></li>
</ul>
</div>
</div>

<div class="box1">
<h1>Projects</h1>
<ul>
<li class="one"><a class="add" href="<?php echo base_url(); ?>axipi/dynamic/items/?a=add">Add</a></li>
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
<?php foreach($projects as $pro):?>

<tr>
<td><a href="<?php echo base_url(); ?>axipi/dynamic/items/?a=view&amp;itm_id=<?php echo $pro->itm_id;?>"><?php echo $pro->itm_id;?></a></td>
<td><?php echo $pro->itm_code;?></td>
<th><a href="<?php echo base_url(); ?>axipi/dynamic/items/?a=update&amp;itm_id=<?php echo $pro->itm_id;?>">Update</a></th>
</tr>

<?php endforeach;?>
</tbody>
</table>
<div class="paging">
<?php echo $pagination; ?>
</div>

</div>
</div>
