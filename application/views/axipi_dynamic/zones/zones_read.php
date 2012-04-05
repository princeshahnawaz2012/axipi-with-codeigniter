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
<h1><?php echo $zon->zon_code; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/?zon_id=<?php echo $zon->zon_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('lay_code'); ?></span><?php echo $zon->lay_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('zon_code'); ?></span><?php echo $zon->zon_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('zon_ordering'); ?></span><?php echo $zon->zon_ordering; ?></p>
</div>

<div class="column1 columnlast">
</div>

<?php if($translations) { ?>
<?php foreach($translations as $trl) { ?>
<h2><?php echo $trl->lng_title; ?> (<?php echo $trl->lng_code; ?>)</h2>
<p><span class="label"><?php echo $this->lang->line('trl_zon_title'); ?></span><?php echo $trl->trl_zon_title; ?></p>
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
