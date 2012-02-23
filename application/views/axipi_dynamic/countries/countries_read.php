<?php
if($cou) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('countries'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $cou[0]->cou_alpha2; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=update&amp;cou_id=<?php echo $cou[0]->cou_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('cou_alpha2'); ?></span><?php echo $cou[0]->cou_alpha2; ?></p>
<p><span class="label"><?php echo $this->lang->line('cou_alpha3'); ?></span><?php echo $cou[0]->cou_alpha3; ?></p>
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
