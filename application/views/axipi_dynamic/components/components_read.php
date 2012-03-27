<?php
if($cmp) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('components'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $cmp->cmp_code; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=update&amp;cmp_id=<?php echo $cmp->cmp_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo current_url(); ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('cmp_code'); ?></span><?php echo $cmp->cmp_code; ?></p>
</div>

<div class="column1 columnlast">
<p><span class="label"><?php echo $this->lang->line('cmp_ispage'); ?></span><?php echo $this->lang->line('reply_'.$cmp->cmp_ispage); ?></p>
<p><span class="label"><?php echo $this->lang->line('cmp_iselement'); ?></span><?php echo $this->lang->line('reply_'.$cmp->cmp_iselement); ?></p>
<p><span class="label"><?php echo $this->lang->line('cmp_isrelation'); ?></span><?php echo $this->lang->line('reply_'.$cmp->cmp_isrelation); ?></p>
</div>

</div>
</div>

<?php
} else {
?>

<?php
}
?>
