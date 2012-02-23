<?php
if($zon) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $zon[0]->zon_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=update&amp;zon_id=<?php echo $zon[0]->zon_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('lay_code'); ?></span><?php echo $zon[0]->lay_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('zon_code'); ?></span><?php echo $zon[0]->zon_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('zon_ordering'); ?></span><?php echo $zon[0]->zon_ordering; ?></p>
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
