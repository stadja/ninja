<?php 
	set_js_path(array('libs/handlebars','libs/ember','libs/jquery.masonry.min'));
	set_js_path(array("reader"));
	foreach($user->getSubscribedFlux() as $flux) {
		set_js_fx("RSSreader.read(".$flux->getId().",".(int)$flux->isExternal().");");
	}
	set_js_fx("$('#masonry_hook').masonry({
  // options
  itemSelector : 'section',
  columnWidth : 370
});

");
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
			<div id="masonry_hook">
			<?php foreach($user->getSubscribedFlux() as $flux) : ?>
				<section>
					<h2 style='color:red'><?php echo $flux->getTitle(); ?></h2>
						<ul>
							{{#bind RSSreader.rssCollection.flux<?php echo $flux->getId();?>.preview}}
								{{#for this end=4}}
									<li style="">
										<h3>{{linkTo link title isExternal='<?php echo $flux->isExternal(); ?>'}}</h3>
										{{{description}}}
									</li>
								{{/for}}
							{{/bind}}
						</ul>
				</section>
			<?php endforeach; ?>
			</div>
		</script>
	</article>

</div>
