<?php
if($zon) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('zones'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $zon->lay_code; ?> - <?php echo $zon->zon_code; ?> - <?php echo $itm->itm_code; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/?zon_id=<?php echo $zon->zon_id.'&amp;itm_id='.$itm->itm_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('lay_code'); ?></span><?php echo $zon->lay_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('zon_code'); ?></span><?php echo $zon->zon_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_code'); ?></span><?php echo $itm->itm_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_title'); ?></span><?php echo $itm->itm_title; ?></p>
<p><span class="label"><?php echo $this->lang->line('cmp_code'); ?></span><?php echo $itm->cmp_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('lng_code'); ?></span><?php echo $itm->lng_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_zon_ordering'); ?></span><?php echo $itm_zon->itm_zon_ordering; ?></p>
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
