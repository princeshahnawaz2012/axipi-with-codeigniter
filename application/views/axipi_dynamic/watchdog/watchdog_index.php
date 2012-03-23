<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->itm->itm_title; ?></a></li>
<li><?php echo $this->lang->line('index'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $this->itm->itm_title; ?> (<?php echo $position; ?>)</h1>
<ul>
<li><a class="purge" href="<?php echo current_url(); ?>?a=purge"><?php echo $this->lang->line('purge'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('index'); ?></h2>

<?php if($results) { ?>

<div class="paging">
<?php echo $pagination; ?>
</div>

<table>
<thead>
<tr>
<th><?php echo $this->lang->line('wtd_id'); ?></th>
<th><?php echo $this->lang->line('wtd_content'); ?></th>
<th class="sort_desc"><span><?php echo $this->lang->line('wtd_datecreated'); ?></span></th>
</tr>
</thead>
<tbody>

<?php foreach($results as $result) { ?>
<tr>
<td><?php echo $result->wtd_id; ?></td>
<td><?php echo nl2br(str_replace(array('<', '>'), array('&lt;', '&gt;'), $result->wtd_content)); ?></td>
<td><?php echo $result->wtd_datecreated; ?></td>
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
