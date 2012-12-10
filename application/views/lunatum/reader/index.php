



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

<?php $this->load->view('lunatum/fragments/headerNews', array('page_news' => 'read')); ?>

<div id="main" class="wrapper clearfix">

	<article id='fluxRSS'>
		<script type="text/x-handlebars"> 
			<div id="masonry_hook">
			<?php foreach($user->getSubscribedFlux() as $flux) : ?>

				<div class="bulbWrap masonry_block">
					<img class="bulbLogo" src="<?php echo setPicPath('lunatum/ffc.jpeg'); ?>" alt="">
					<ul class="bulbTitle">
						<li><a href="#"><?php echo $flux->getTitle(); ?></a></li>
						<li><a href="#">tous les articles</a></li>
					</ul>
					<ul class="bulbContent">
						<li class="bulbDates"><a href="#">Aujourd&#039;hui</a></li>
						{{#bind RSSreader.rssCollection.flux<?php echo $flux->getId();?>.preview}}
							{{#for this end=4}}
								<li class="bulbNews">
									{{linkTo link "<?php echo setPicPath('lunatum/26.png'); ?>" title isExternal='<?php echo $flux->isExternal(); ?>'}}
								</li>
							{{/for}}
						{{/bind}}
					</ul>
				</div>

			<?php endforeach; ?>
			</div>
		</script>
	</article>

</div>


