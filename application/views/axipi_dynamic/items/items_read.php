<?php
if($itm) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('items'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $itm[0]->itm_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=update&amp;itm_id=<?php echo $itm[0]->itm_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('sct_code'); ?></span><?php echo $itm[0]->sct_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_code'); ?></span><?php echo $itm[0]->itm_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_virtualcode'); ?></span><?php echo $itm[0]->itm_virtualcode; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_title'); ?></span><?php echo $itm[0]->itm_title; ?></p>
<p><span class="label"><?php echo $this->lang->line('cmp_code'); ?></span><?php echo $itm[0]->cmp_code; ?></p>
</div>

<div class="column1 columnlast">
</div>

</div>
</div>

<?php
} else {
?>

<?php
}
?>
