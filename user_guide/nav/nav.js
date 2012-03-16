function create_menu(basepath)
{
	var base = (basepath == 'null') ? '' : basepath;

	document.write(
		'<table cellpadding="0" cellspaceing="0" border="0" style="width:98%"><tr>' +
		'<td class="td" valign="top">' +

		'<ul>' +
		'<li><a href="'+base+'index.html">User Guide Home</a></li>' +
		'<li><a href="'+base+'toc.html">Table of Contents Page</a></li>' +
		'</ul>' +

		'<h3>Basic Info</h3>' +
		'<ul>' +
		'<li><a href="'+base+'changes.html">Changes on CodeIgniter</a></li>' +
		'<li><a href="'+base+'installation.html">Installation</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +

		'<h3>General Topics</h3>' +
		'<ul>' +
		'<li><a href="'+base+'general/layouts.html">Layouts</a></li>' +
		'<li><a href="'+base+'general/zones.html">Zones</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +

		'<h3>Class Reference</h3>' +
		'<ul>' +
		'<li><a href="'+base+'libraries/axipi_library.html">axipi Class</a></li>' +
		'</ul>' +

		'</td><td class="td_sep" valign="top">' +

		'<h3>Helper Reference</h3>' +
		'<ul>' +
		'<li><a href="'+base+'helpers/axipi_helper.html">axipi Helper</a></li>' +
		'</ul>' +

		'</td></tr></table>');
}