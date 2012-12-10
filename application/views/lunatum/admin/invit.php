<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min"));
	set_css_path("libs/uniform.default");
	set_js_fx("$('input, textarea').placeholder();
		$('select, input, input:checkbox, input:radio, input:file').uniform();");
?>

<div id="main" class="wrapper clearfix">
<div class="info message">
                 <h3>Utilisateur ajout&eacute; !</h3>
                 <p id="info">This is just an info notification message.</p>
</div>
<?php set_js_fx("hideInfoMessage();"); ?>
<?php if ($this->session->flashdata("invitation_sent") != '') {
	 set_js_fx("showInfoMessage('".$this->session->flashdata("invitation_sent")."');");
} ?>

<?php echo validation_errors(); ?>
<?php echo form_open('admin/invit', array('id' => 'invit')); ?>
<h1>Inviter</h1>
	<fieldset id="infos">
		<legend> Infos </legend>
		<input name="firstname" type="text" placeholder="Prénom" value="<?php echo set_value('firstname'); ?>" autofocus>
		<input name="name" type="text" placeholder="Nom" value="<?php echo set_value('name'); ?>" autofocus>
		<input name="email" type="email" placeholder="Courriel" value="<?php echo set_value('email'); ?>" required="">
	</fieldset>
	<fieldset id="droits">
		<legend> Droits </legend>
		<?php foreach($rights as $right) : ?>
			<p><label> <input type=checkbox name="rights[]" value="<?php echo $right->value; ?>" <?php echo set_checkbox('rights[]', $right->value); ?>> <?php echo $right->name; ?> </label></p>
		<?php endforeach; ?>
	</fieldset>
	<fieldset id="actions">
		<input type="submit" id="submit" value="Inviter">
	</fieldset>
</form>
</div>