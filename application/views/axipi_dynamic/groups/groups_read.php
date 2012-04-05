<?php
if($grp) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('groups'); ?></a></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $grp->grp_code; ?></h1>
<ul>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/?grp_id=<?php echo $grp->grp_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('grp_code'); ?></span><?php echo $grp->grp_code; ?></p>
</div>

<div class="column1 columnlast">
<p><span class="label"><?php echo $this->lang->line('grp_isitem'); ?></span><?php echo $this->lang->line('reply_'.$grp->grp_isitem); ?></p>
<p><span class="label"><?php echo $this->lang->line('grp_isuser'); ?></span><?php echo $this->lang->line('reply_'.$grp->grp_isuser); ?></p>
<p><span class="label"><?php echo $this->lang->line('grp_ispermission'); ?></span><?php echo $this->lang->line('reply_'.$grp->grp_ispermission); ?></p>
</div>

<?php if($translations) { ?>
<?php foreach($translations as $trl) { ?>
<h2><?php echo $trl->lng_title; ?> (<?php echo $trl->lng_code; ?>)</h2>
<p><span class="label"><?php echo $this->lang->line('grp_trl_title'); ?></span><?php echo $trl->grp_trl_title; ?></p>
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
