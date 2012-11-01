<?php 
	set_js_path(array("libs/chosen.jquery.min", "admin"));
	set_css_path(array("libs/chosen"));
	set_js_fx("$('.chzn-select').chosen().change(function(){changeFluxRights(this);});");

?>

<div id="main" class="wrapper clearfix">
	<h1>Gérer les droits des flux</h1>

	<div class='flux_collection'>
		<?php foreach ($flux_collection as $flux) : ?>
		<section>
			<div class='flux'>
				<h2><?php echo $flux->getTitle(); ?></h2>
				<select id='<?php echo $flux->getId(); ?>' class="chzn-select" tabindex="3" multiple="" style="width:350px;" data-placeholder="Séléctionnez des utilisateurs">
					<?php $cdc_id = ''; ?>;

					<?php foreach ($users_cdc as $cdc) : ?>
						<?php $selected = $flux->isAuthoredBy($cdc) ? "selected" : ""; ?>
						<option <?php echo $selected; ?> value="<?php echo $cdc->getId(); ?>">
							<?php echo $cdc->getEmail(); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		</section>
		<?php endforeach; ?>
	</div>
</div>