<?php
if($sct) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('sections'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $sct->sct_code; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/?sct_id=<?php echo $sct->sct_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('sct_code'); ?></span><?php echo $sct->sct_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('lay_code'); ?></span><?php echo $sct->lay_code; ?></p>
</div>

<div class="column1 columnlast">
</div>

<?php if($translations) { ?>
<?php foreach($translations as $trl) { ?>
<h2><?php echo $trl->lng_title; ?> (<?php echo $trl->lng_code; ?>)</h2>
<p><span class="label"><?php echo $this->lang->line('sct_trl_title'); ?></span><?php echo $trl->sct_trl_title; ?></p>
<p><span class="label"><?php echo $this->lang->line('sct_trl_description'); ?></span><?php echo $trl->sct_trl_description; ?></p>
<p><span class="label"><?php echo $this->lang->line('sct_trl_keywords'); ?></span><?php echo $trl->sct_trl_keywords; ?></p>
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
