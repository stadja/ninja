<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min"));
	set_css_path("libs/uniform.default");
	set_js_fx("$('input, textarea').placeholder();
		$('select, input, input:checkbox, input:radio, input:file').uniform();");
?>
<?php foreach($crud->css_files as $file) {
	set_css_path($file);
}	?>
<?php foreach($crud->js_files as $file) {
	set_js_path($file);
}	?>

<div id="main" class="clearfix">

	<?php echo $crud->output; ?>

</div>