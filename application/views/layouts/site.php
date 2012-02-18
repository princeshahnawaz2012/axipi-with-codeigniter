<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>axipi / CodeIgniter</title>
<link href="<?php echo base_url(); ?>styles/sct_code/site.dist.css" rel="stylesheet" type="text/css">
</head>
<body>

<div id="box-page">
<div id="display-page">

<div id="box-pageheader">
<div id="display-pageheader">
<?php if(isset($zones['header']) == 1) { echo $zones['header']; } ?>
</div>
</div>

<div id="box-pagecontent">
<div id="display-pagecontent">
<?php echo $zones['content']; ?>
</div>
</div>

<div id="box-pagefooter">
<div id="display-pagefooter">
</div>
</div>

</div>
</div>

</body>
</html>
