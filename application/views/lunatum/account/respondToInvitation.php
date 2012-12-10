<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min"));
	set_css_path(array("libs/uniform.default", "signup"));
	set_js_fx("$('input, textarea').placeholder();");
?>
<?php echo (validation_errors() == '') ? '' : '<p>Erreur : </p>'.validation_errors(); ?>
<?php echo form_open('invitation/'.$invitation_id, array('id' => 'signup')); ?>
	<h1>Invitation</h1>
	<p>Utilisez le courriel &agrave; lequel vous a &eacute;t&eacute; envoy&eacute; votre invitation</p>
	<fieldset id="inputs">
		<input name="email" id="email" type="email" placeholder="Courriel" value="<?php echo set_value('email'); ?>" autofocus required>
		<input id="password" name="password" type="password" placeholder="Nouveau mot de passe" value="<?php echo set_value('password'); ?>" required>
		<input id="password_conf" name="password_conf" type="password" placeholder="Confirmez votre mot de passe" value="<?php echo set_value('password_conf'); ?>" required>
	</fieldset>
	<fieldset id="actions">
		<input id="submit" type="submit" value="Enregistrez-vous !">
	</fieldset>
</form>