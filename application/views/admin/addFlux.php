<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min"));
	set_css_path("libs/uniform.default");
	set_js_fx("$('input, textarea').placeholder();
		$('select, input, input:checkbox, input:radio, input:file').uniform();");
?>
<articles>
	<article>
<div class="info message">
                 <h3>Utilisateur ajout&eacute; !</h3>
                 <p id="info">This is just an info notification message.</p>
</div>
<?php set_js_fx("hideInfoMessage();"); ?>
<?php if ($this->session->flashdata("alert") != '') {
	 set_js_fx("showInfoMessage('".$this->session->flashdata("alert")."');");
} ?>

<?php echo validation_errors(); ?>
<?php echo form_open('admin/addFlux', array('id' => 'invit')); ?>
<h1>Créer un flux</h1>
	<fieldset id="infos">
		<legend> Le flux </legend>
		<input name="title" type="text" placeholder="Titre du flux" value="<?php echo set_value('title'); ?>" autofocus required="">
		<input name="id" type="text" placeholder="id du flux" value="<?php echo set_value('id'); ?>" required="">
		<textarea rows="4" cols="50" name="description" type="text" placeholder="description du flux" required=""><?php echo set_value('description'); ?></textarea> 
	</fieldset>
	<fieldset id="actions">
		<input type="submit" id="submit" value="Créer le flux">
	</fieldset>
</form>
</article>
</articles>