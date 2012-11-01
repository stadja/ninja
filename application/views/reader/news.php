<?php 
	set_css_path('adelos/style_fluxNews');
	set_js_path('libs/ember-0.9.8.1.min');
	set_js_path(array("reader"));
	
	set_js_fx("RSSreader.read(".$news->getFlux()->getId().", 0, 0, 10);");
?>
<!-- ==========================================
	#header-content - Welcome and Admin buttons 
=========================================== -->				
<div id="header-content" class="wrapper clearfix">
	
	<a class="perso " style="float:right;" href="<?php echo base_url('reader'); ?>">Retour au tableau de bord</a>

</div> <!-- #header-content -->

<!-- ==========================================
	#main - Article
=========================================== -->
<div id="main" class="wrapper clearfix">
	<div id="article-box">
		<div class="article-info">
			<ul>
				<?php if ($news->getFlux()->isExternal()): ?>
					<li>Source: Top-santé.fr</li>
					<li><a href="#">Lire sur le site</a></li>
				<?php else: ?>
					<li>Ecrire &agrave; l'auteur: <a target='_blank' href="mailto:<?php echo $news->getAuthor()->getEmail(); ?>"><?php echo $news->getAuthor()->getPatronyme(); ?></a></li>
					<li></li>
				<?php endif ?>				
				<li><?php echo ucfirst($news->getLastlyUpdated()); ?></li>
			</ul>
		</div> <!-- .article-info -->
		<h1><?php echo $news->getTitle(); ?></h1>

		<?php echo $news->getText(); ?>

		<div class="article-info">
			<ul>
				<?php if ($news->getFlux()->isExternal()): ?>
					<li>Source: Top-santé.fr</li>
					<li><a href="#">Lire sur le site</a></li>
				<?php else: ?>
					<li>Ecrire &agrave; l'auteur: <a target='_blank' href="mailto:<?php echo $news->getAuthor()->getEmail(); ?>"><?php echo $news->getAuthor()->getPatronyme(); ?></a></li>
					<li></li>
				<?php endif ?>				
				<li><?php echo ucfirst($news->getLastlyUpdated()); ?></li>
			</ul>
		</div> <!-- .article-info -->
	</div> <!-- #article-box -->
	<div id="source-box">
		<img class="source-logo" src="http://lorempixel.com/150/150/">
		<h1><?php echo $news->getFlux()->getTitle(); ?></h1>
		<?php echo $news->getFlux()->getDescription(); ?>
		
		<article>
			<h2 style='color:red'>Derniers sujets</h2>
			<div class="fluxNews" id="<?php echo $news->getFlux()->getId(); ?>">
				<ul id='fluxRSS'>
					<script type="text/x-handlebars"> 
						{{#each RSSreader.rssCollection.flux<?php echo $news->getFlux()->getId(); ?>.preview}}
							<li style="">
								<h3>{{{openingLink}}}{{{title}}}</a></h3>
							</li>
						{{/each}}
					</script>
				</ul>
			</div>
		</article>
	</div>
</div> <!-- #main -->