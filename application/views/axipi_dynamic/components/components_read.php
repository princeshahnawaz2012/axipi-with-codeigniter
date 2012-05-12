<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('components'); ?></a></li>
<li><?php echo $cmp->cmp_code; ?></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $cmp->cmp_code; ?></h1>
<ul>
<?php if($cmp->cmp_islocked == 0) { ?><li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/<?php echo $cmp->cmp_id; ?>"><?php echo $this->lang->line('delete'); ?></a></li><?php } ?>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/<?php echo $cmp->cmp_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
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
