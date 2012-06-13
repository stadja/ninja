<?php 
	set_js_path(array("libs/chosen.jquery.min", "admin"));
	set_css_path(array("libs/chosen"));
	set_js_fx("$('.chzn-select').chosen().change(function(){changeFluxRights(this);});");

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
		<h1>Gérer les droits des flux</h1>

		<div class='flux_collection'>
			<?php foreach ($flux_collection as $flux) : ?>
				<div class='flux'>
					<h2><?php echo $flux->getTitle(); ?></h2>
					<select id='<?php echo $flux->id; ?>' class="chzn-select" tabindex="3" multiple="" style="width:350px;" data-placeholder="Séléctionnez des utilisateurs">
						<?php $cdc_id = ''; ?>;

						<?php foreach ($users_cdc as $cdc) : ?>
							<?php $selected = $flux->isAuthoredBy($cdc) ? "selected" : ""; ?>
							<option <?php echo $selected; ?> value="<?php echo $cdc->getId(); ?>">
								<?php echo $cdc->getEmail(); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endforeach; ?>
		</div>

	</article>
</articles>