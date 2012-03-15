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
<div class="display">

<?php echo form_open(current_url()); ?>
<div class="filters">
<div><?php echo form_label($this->lang->line('itm_code'), 'items_relations_itm_code'); ?><?php echo form_input('items_relations_itm_code', set_value('items_relations_itm_code', $this->session->userdata('items_relations_itm_code')), 'id="items_relations_itm_code" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('itm_title'), 'items_relations_itm_title'); ?><?php echo form_input('items_relations_itm_title', set_value('items_relations_itm_title', $this->session->userdata('items_relations_itm_title')), 'id="items_relations_itm_title" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('sct_code'), 'items_relations_sct_id'); ?><?php echo form_dropdown('items_relations_sct_id', $select_section, set_value('items_relations_sct_id', $this->session->userdata('items_relations_sct_id')), 'id="items_relations_sct_id" class="select"'); ?></div>
<div><?php echo form_label($this->lang->line('cmp_code'), 'items_relations_cmp_code'); ?><?php echo form_input('items_relations_cmp_code', set_value('items_relations_cmp_code', $this->session->userdata('items_relations_cmp_code')), 'id="items_relations_cmp_code" class="inputtext"'); ?></div>
<div><?php echo form_label($this->lang->line('lng_code'), 'items_relations_lng_id'); ?><?php echo form_dropdown('items_relations_lng_id', $select_language, set_value('items_relations_lng_id', $this->session->userdata('items_relations_lng_id')), 'id="items_relations_lng_id" class="select"'); ?></div>
<div><input class="inputsubmit" type="submit" name="submit" id="submit" value="<?php echo $this->lang->line('validate'); ?>"></div>
</div>
</form>

<div class="paging">
<?php echo $pagination; ?>
</div>

<?php foreach($results as $result) { ?>
<div class="box1">
<h1><?php echo $result->itm_title; ?> (<?php echo $result->itm_code; ?>)</h1>
<ul>
<li><a class="create" href="<?php echo current_url(); ?>?a=create&amp;rel_id=<?php echo $result->itm_id; ?>"><?php echo $this->lang->line('create'); ?></a></li>
</ul>
<div class="display">

<?php if(isset($items_relations[$result->itm_id]) == 1) { ?>

<table>
<thead>
<tr>
<th><?php echo $this->lang->line('itm_title'); ?></th>
<th><?php echo $this->lang->line('sct_code'); ?></th>
<th><?php echo $this->lang->line('cmp_code'); ?></th>
<th><?php echo $this->lang->line('lng_code'); ?></th>
<th><?php echo $this->lang->line('itm_rel_ordering'); ?></th>
<th><?php echo $this->lang->line('itm_rel_ispublished'); ?></th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>

<?php foreach($items_relations[$result->itm_id] as $itm_rel) { ?>
<tr>
<td><a href="<?php echo current_url(); ?>?a=read&amp;rel_id=<?php echo $result->itm_id;?>&amp;itm_id=<?php echo $itm_rel->itm_id;?>"><?php echo $itm_rel->itm_title;?></a></td>
<td><?php echo $itm_rel->sct_code; ?></td>
<td><?php echo $itm_rel->cmp_code; ?></td>
<td><?php echo $itm_rel->lng_code; ?></td>
<td><?php echo $itm_rel->itm_rel_ordering; ?></td>
<td><?php echo $itm_rel->itm_rel_ispublished; ?></td>
<th>
<a href="<?php echo current_url(); ?>?a=update&amp;rel_id=<?php echo $result->itm_id;?>&amp;itm_id=<?php echo $itm_rel->itm_id;?>"><?php echo $this->lang->line('update'); ?></a>
<a href="<?php echo current_url(); ?>?a=delete&amp;rel_id=<?php echo $result->itm_id;?>&amp;itm_id=<?php echo $itm_rel->itm_id;?>"><?php echo $this->lang->line('delete'); ?></a>
</th>
</tr>
<?php } ?>

</tbody>
</table>

<?php } ?>

</div>
</div>

<?php } ?>

<div class="paging">
<?php echo $pagination; ?>
</div>

</div>
</div>
