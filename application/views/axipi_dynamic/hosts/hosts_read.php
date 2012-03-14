<?php
if($hst) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('hosts'); ?></a></li>
<li><?php echo $hst->hst_code; ?></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $hst->hst_code; ?></h1>
<ul>
<?php if($hst->hst_islocked == 0) { ?><li><a href="<?php echo current_url(); ?>?a=delete&amp;hst_id=<?php echo $hst->hst_id; ?>"><?php echo $this->lang->line('delete'); ?></a></li><?php } ?>
<li><a href="<?php echo current_url(); ?>?a=update&amp;hst_id=<?php echo $hst->hst_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('hst_code'); ?></span><?php echo $hst->hst_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('hst_url'); ?></span><?php echo $hst->hst_url; ?></p>
<p><span class="label"><?php echo $this->lang->line('hst_environment'); ?></span><?php echo $hst->hst_environment; ?></p>
<p><span class="label"><?php echo $this->lang->line('lay_code'); ?></span><?php echo $hst->lay_code; ?></p>
</div>

<div class="column1 columnlast">
<p><span class="label"><?php echo $this->lang->line('hst_gzhandler'); ?></span><?php echo $this->lang->line('reply_'.$hst->hst_gzhandler); ?></p>
<p><span class="label"><?php echo $this->lang->line('hst_debug'); ?></span><?php echo $this->lang->line('reply_'.$hst->hst_debug); ?></p>
</div>

<?php if($translations) { ?>
<?php foreach($translations as $trl) { ?>
<h2><?php echo $trl->lng_title; ?> (<?php echo $trl->lng_code; ?>)</h2>
<p><span class="label"><?php echo $this->lang->line('hst_trl_defaultitem'); ?></span><?php echo $trl->hst_trl_defaultitem; ?></p>
<?php } ?>
<?php } ?>

</div>
</div>

<?php
} else {
?>

<?php
}
?>
