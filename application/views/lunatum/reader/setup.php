<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min"));
	set_css_path("libs/uniform.default");
	set_js_fx("$('input, textarea').placeholder();
		$('select, input, input:checkbox, input:radio, input:file').uniform();");
?>

<?php $this->load->view('lunatum/fragments/headerNews', array('page_news' => 'setup')); ?>

<div id="main" class="wrapper clearfix">
	<?php echo form_open('reader/setup', array('id' => 'setup')); ?>
	<h1>Configurez vos flux</h1>
		<fieldset id="infos">
			<legend>Séléctionnez les flux dont vous voulez être abonné</legend>
			<?php foreach($flux_collection as $flux) : ?>
				<div id='<?php echo $flux->getId(); ?>'>
					<p>
						<label> 
							<input type=checkbox name="flux[]" value="<?php echo $flux->getId(); ?>" <?php echo ($user->hasSuscribedToFlux($flux->getId())) ? 'checked' : ''; ?>> <?php echo $flux->getTitle(); ?> 
						</label>
					</p>

				</div>
			<?php endforeach; ?>
		</fieldset>
		<fieldset id="actions">
			<input type="submit" id="submit" name="flux_setup" value="Sauvegardez votre séléction">
		</fieldset>
	</form>
</div>