<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('items'); ?></a></li>
<li><?php echo $itm->itm_code; ?></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $itm->itm_code; ?></h1>
<ul>
<?php if($itm->itm_islocked == 0) { ?><li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/<?php echo $itm->itm_id; ?>"><?php echo $this->lang->line('delete'); ?></a></li><?php } ?>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/<?php echo $itm->itm_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('sct_code'); ?></span><?php echo $itm->sct_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_code'); ?></span><?php echo $itm->itm_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_virtualcode'); ?></span><?php echo $itm->itm_virtualcode; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_title'); ?></span><?php echo $itm->itm_title; ?></p>
<p><span class="label"><?php echo $this->lang->line('cmp_code'); ?></span><?php echo $itm->cmp_code; ?></p>
</div>

<div class="column1 columnlast">
<?php foreach($this->storage_files as $file) { ?>
	<?php if($itm->{$file} && file_exists('storage/'.$this->storage_folder.'/'.$file.'/'.$itm->{$file})) { ?>
		<p><span class="label"><?php echo $this->lang->line($file); ?></span><a href="<?php echo base_url(); ?>storage/<?php echo $this->storage_folder; ?>/<?php echo $file; ?>/<?php echo $itm->{$file}; ?>"><?php echo $itm->{$file}; ?></a></p>
	<?php } ?>
<?php } ?>
<p><span class="label"><?php echo $this->lang->line('lng_code'); ?></span><?php echo $itm->lng_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('itm_ispublished'); ?></span><?php echo $this->lang->line('reply_'.$itm->itm_ispublished); ?></p>
</div>

</div>
</div>
