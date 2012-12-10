<?php foreach($crud->css_files as $file) {
	set_css_path($file);
}	?>
<?php foreach($crud->js_files as $file) {
	set_js_path($file);
}	?>

<div id="main" class="clearfix">

	<?php echo $crud->output; ?>

</div>