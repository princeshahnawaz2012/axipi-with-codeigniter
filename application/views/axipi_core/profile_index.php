<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo current_url(); ?>"><?php echo $this->itm->itm_title; ?></a></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $usr->usr_email; ?></h1>
<ul>
<li><a href="<?php echo current_url(); ?>?a=update"><?php echo $this->lang->line('update'); ?></a></li>
</ul>
<div class="display">

<div class="column1">
<p><span class="label"><?php echo $this->lang->line('usr_email'); ?></span><?php echo $usr->usr_email; ?></p>
<p><span class="label"><?php echo $this->lang->line('usr_firstname'); ?></span><?php echo $usr->usr_firstname; ?></p>
<p><span class="label"><?php echo $this->lang->line('usr_lastname'); ?></span><?php echo $usr->usr_lastname; ?></p>
</div>

<div class="column1 columnlast">
</div>

</div>
</div>
