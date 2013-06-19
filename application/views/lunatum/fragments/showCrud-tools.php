<?php foreach($crud->css_files as $file) {
	set_css_path($file);
}	?>
<?php foreach($crud->js_files as $file) {
	set_js_path($file);
}	?>

<div id="main" class="clearfix">
<a href='<?php echo base_url('/admin/tools'); ?>'>Outils</a> &nbsp;
<a href='<?php echo base_url('/admin/specialities'); ?>'>Spécialités</a>
	<?php echo $crud->output; ?>

</div>