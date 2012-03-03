<?php
if($per) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('permissions'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $per->per_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=update&amp;per_id=<?php echo $per->per_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('per_code'); ?></span><?php echo $per->per_code; ?></p>
</div>

<div class="column1 columnlast">
</div>

<?php if($translations) { ?>
<?php foreach($translations as $trl) { ?>
<h2><?php echo $trl->lng_title; ?> (<?php echo $trl->lng_code; ?>)</h2>
<p><span class="label"><?php echo $this->lang->line('per_trl_title'); ?></span><?php echo $trl->per_trl_title; ?></p>
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
