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

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('itm_code'), 'items_itm_code'); ?><?php echo form_input('items_itm_code', set_value('items_itm_code', $this->session->userdata('items_itm_code')), 'class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('itm_title'), 'items_itm_title'); ?><?php echo form_input('items_itm_title', set_value('items_itm_title', $this->session->userdata('items_itm_title')), 'class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('sct_code'), 'items_sct_id'); ?><?php echo form_dropdown('items_sct_id', $select_section, set_value('items_sct_id', $this->session->userdata('items_sct_id')), 'class="select"'); ?></div>
<div><?php echo form_label($this->lang->line('cmp_code'), 'items_cmp_code'); ?><?php echo form_input('items_cmp_code', set_value('items_cmp_code', $this->session->userdata('items_cmp_code')), 'class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('lng_code'), 'items_lng_id'); ?><?php echo form_dropdown('items_lng_id', $select_language, set_value('items_lng_id', $this->session->userdata('items_lng_id')), 'class="select"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<div class="paging">
<?php echo $pagination; ?>
</div>
<table>
<thead>
<tr>
<th><a class="sort_desc" href="#"><?php echo $this->lang->line('itm_id'); ?></a></th>
<th><?php echo $this->lang->line('itm_code'); ?></th>
<th><?php echo $this->lang->line('itm_title'); ?></th>
<th><?php echo $this->lang->line('sct_code'); ?></th>
<th><?php echo $this->lang->line('cmp_code'); ?></th>
<th><?php echo $this->lang->line('lng_code'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php foreach($items as $itm):?>

<tr>
<td><a href="<?php echo current_url(); ?>?a=view&amp;itm_id=<?php echo $itm->itm_id;?>"><?php echo $itm->itm_id;?></a></td>
<td><?php echo $itm->itm_code;?></td>
<td><?php echo $itm->itm_title;?></td>
<td><?php echo $itm->sct_code;?></td>
<td><?php echo $itm->cmp_code;?></td>
<td><?php echo $itm->lng_code;?></td>
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
