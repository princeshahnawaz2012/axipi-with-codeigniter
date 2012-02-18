<?php
if($grp) {
?>

<div class="box-breadcrumbs box1">
<div class="display">
<ul>
<li class="first"><a href="<?php echo base_url(); ?>axipi/dynamic/groups">Groups</a></li>
<li><a href="<?php echo base_url(); ?>axipi/dynamic/groups?a=view&amp;grp_id=<?php echo $grp[0]->grp_id; ?>"><?php echo $grp[0]->grp_code; ?></a></li>
</ul>
</div>
</div>

<div class="box1">
<h1><?php echo $grp[0]->grp_code; ?> / Update project</h1>
<ul>
<li><a href="<?php echo base_url(); ?>axipi/view/<?php echo $grp[0]->grp_id; ?>">Cancel</a></li>
</ul>
<div class="display">

<?php echo validation_errors(); ?>

<?php echo form_open(current_url().'?a=update&amp;grp_id='.$grp[0]->grp_id); ?>

<div class="column1">
<p><?php echo form_label($this->lang->line('grp_code'), 'grp_code'); ?><?php echo form_input('grp_code', $grp[0]->grp_code, 'class="inputtext"'); ?></p>
</div>
<div class="column1 columnlast">
<p><input type="submit" name="submit" id="submit"></p>
</div>

</form>

</div>
</div>

<?php
} else {
?>

<?php
}
?>
