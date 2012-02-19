<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $this->axipi_library->get_head(); ?>
</head>
<body>

<div id="box-page">
<div id="display-page">

<div id="box-pageheader">
<div id="display-pageheader">
<?php if(isset($zones['pageheader']) == 1) { echo $zones['pageheader']; } ?>
</div>
</div>

<div id="box-pagecontent">
<div id="display-pagecontent">
<?php echo $zones['content']; ?>
</div>
</div>

<div id="box-pagesidebar">
<div id="display-pagesidebar">
<?php if(isset($zones['pagesidebar']) == 1) { echo $zones['pagesidebar']; } ?>
</div>
</div>

<div id="box-pagefooter">
<div id="display-pagefooter">
<?php if(isset($zones['pagefooter']) == 1) { echo $zones['pagefooter']; } ?>
</div>
</div>

</div>
</div>

<?php echo $this->axipi_library->get_debug(); ?>
<?php echo $this->axipi_library->get_foot(); ?>
</body>
</html>
