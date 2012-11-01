<?php 
	set_js_path(array('libs/handlebars','libs/ember'));
	set_js_path(array("reader"));
	
	foreach($user->getSubscribedFlux() as $flux) {
		set_js_fx("RSSreader.read(".$flux->getId().",".(int)$flux->isExternal().", 0, 3);");
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

	<article id='fluxRSS'>
		<script type="text/x-handlebars"> 
			<?php foreach($user->getSubscribedFlux() as $flux) : ?>
				<section>
					<h2 style='color:red'><?php echo $flux->getTitle(); ?></h2>
						<ul>
							{{#each RSSreader.rssCollection.flux<?php echo $flux->getId(); ?>.preview}}
								<li style="">
									<?php if ($flux->isExternal()): ?>
										<h3>{{{openingExternalLink}}}{{{title}}}</a></h3>
									<?php else : ?>
										<h3>{{{openingLink}}}{{{title}}}</a></h3>
									<?php endif; ?>

									{{{description}}}
								</li>
							{{/each}}
						</ul>
					</div>
				</section>
			<?php endforeach; ?>
		</script>
	</article>

</div>
