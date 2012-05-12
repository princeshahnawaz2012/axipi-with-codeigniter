<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('layouts'); ?></a></li>
<li><?php echo $lay->lay_code; ?></li>
<li><?php echo $this->lang->line('read'); ?></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $lay->lay_code; ?></h1>
<ul>
<?php if($lay->lay_islocked == 0) { ?><li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_delete/<?php echo $lay->lay_id; ?>"><?php echo $this->lang->line('delete'); ?></a></li><?php } ?>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>/_update/<?php echo $lay->lay_id; ?>"><?php echo $this->lang->line('update'); ?></a></li>
<li><a href="<?php echo base_url(); ?><?php echo $this->itm->itm_code; ?>"><?php echo $this->lang->line('index'); ?></a></li>
</ul>
<div class="display">

<h2><?php echo $this->lang->line('read'); ?></h2>

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('lay_code'); ?></span><?php echo $lay->lay_code; ?></p>
<p><span class="label"><?php echo $this->lang->line('lay_type'); ?></span><?php echo $lay->lay_type; ?></p>
</div>

<div class="column1 columnlast">
</div>

</div>
</div>
