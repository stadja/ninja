<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min"));
	set_css_path(array("libs/uniform.default", "signup"));
	set_js_fx("$('input, textarea').placeholder();");
?>
<?php echo (validation_errors() == '') ? '' : '<p>Erreur : </p>'.validation_errors(); ?>
<?php echo form_open('account/login', array('id' => 'login')); ?>
	<h1>Connexion</h1>
	<fieldset id="inputs">
		<input name="email" id="email" type="email" placeholder="Courriel" value="<?php echo set_value('email'); ?>" autofocus required>
		<input id="password" name="password" type="password" placeholder="Nouveau mot de passe" value="<?php echo set_value('password'); ?>" required>
	</fieldset>
	<fieldset id="actions">
		<input id="submit" type="submit" value="Enregistrez-vous !">
	</fieldset>
</form>
