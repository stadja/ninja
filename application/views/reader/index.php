<?php 
	set_js_path('libs/ember-0.9.8.1.min');
	set_js_path(array("reader"));
	
	foreach($user->getSubscribedFlux() as $flux) {
		set_js_fx("RSSreader.read(".$flux->getId().",".(int)$flux->isExternal().");");
	}

	// set_js_fx("
	// 	$('.fluxNews').each(function(index) {
	// 				if (RSSreader != undefined) {
	// 					RSSreader.read($(this).attr('id'));
	// 				}
	// 			});
	// ");
	
?>

<?php $this->load->view('fragments/headerNews', array('page_news' => 'read')); ?>

<div id="main" class="wrapper clearfix">
	<article>
			<?php foreach($user->getSubscribedFlux() as $flux) : ?>
		<section>
			<h2 style='color:red'><?php echo $flux->getTitle(); ?></h2>
			<div class="fluxNews" id="<?php echo $flux->getId(); ?>">
				<ul>
					<script type="text/x-handlebars"> 
						{{#each RSSreader.rssCollection.<?php echo $flux->getId(); ?>.preview}}
							<li style="">
								<?php if ($flux->isExternal()): ?>
									<h3>{{{openingExternalLink}}}{{{title}}}</a></h3>
								<?php else : ?>
									<h3>{{{openingLink}}}{{{title}}}</a></h3>
								<?php endif; ?>

								{{{description}}}
							</li>
						{{/each}}
						<!--{{RSSreader.rssCollection.<?php echo $flux->getId(); ?>.testBinding}}-->
					</script>
				</ul>
			</div>
		</section>
			<?php endforeach; ?>
	</article>
</div>
