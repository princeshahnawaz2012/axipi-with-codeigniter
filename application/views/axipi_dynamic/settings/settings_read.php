<?php
if($stg) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('settings'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $stg->stg_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=update&amp;stg_id=<?php echo $stg->stg_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('stg_code'); ?></span><?php echo $stg->stg_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('stg_value'); ?></span><?php echo $stg->stg_value; ?></p>
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
