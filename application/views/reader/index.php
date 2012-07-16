<?php 
	set_js_path('libs/ember-0.9.8.1.min');
	set_js_path(array("reader"));
	set_js_fx("
		$('.fluxNews').each(function(index) {
					if (RSSreader != undefined) {
						RSSreader.read($(this).attr('id'));
					}
				});
	");
?>
<articles>
	<article>

		<h1>Consultation des flux</h1>

		<?php foreach($user->getSubscribedFlux() as $flux) : ?>
			<div class="fluxBox" id="<?php echo $flux->getId(); ?>">
				<hr/>
					<h2 style='color:red'><b><?php echo $flux->getTitle(); ?></b></h2>
					<div class="fluxNews" id="<?php echo $flux->getId(); ?>">
						<script type="text/x-handlebars"> 
							{{#each RSSreader.rssCollection.<?php echo $flux->getId(); ?>.preview}}
								<div style='border: 1px dotted'>
									<h3>{{title}}</h3>
									<p>{{description}}</p>
								</div>
							{{/each}}
							{{RSSreader.rssCollection.<?php echo $flux->getId(); ?>.testBinding}}
						</script>
					</div>
				<hr/>
			</div>
		<?php endforeach; ?>

	</article>
</articles>