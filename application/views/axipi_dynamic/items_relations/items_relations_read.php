<?php
if($rel) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('relations'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $rel->itm_title; ?> (<?php echo $rel->itm_code; ?>) - <?php echo $itm->itm_title; ?> (<?php echo $itm->itm_code; ?>)</h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/?rel_id=<?php echo $rel->itm_id.'&amp;itm_id='.$itm->itm_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('itm_rel_title'); ?></span><?php echo $itm_rel->itm_rel_title; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_rel_ordering'); ?></span><?php echo $itm_rel->itm_rel_ordering; ?></p>
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
