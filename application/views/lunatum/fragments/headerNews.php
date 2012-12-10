<div id="header-content" class="wrapper clearfix">

	<?php $selected = ($page_news == 'read') ? 'selected' : ''; ?>
	<a href="<?php echo base_url('reader');?>" style="float:right; margin-right: 300px;" class="perso <?php echo $selected ?>">Lire</a>

	<?php if ($user->hasRights('cdc')) :?>
		<?php $selected = ($page_news == 'write') ? 'selected' : ''; ?>
		<a href="<?php echo base_url('cdc/addNews');?>" style="float:right; margin-right: 20px;" class="perso <?php echo $selected ?>">Ecrire</a>
	<?php endif; ?>

	<?php $selected = ($page_news == 'setup') ? 'selected' : ''; ?>
	<a class="perso <?php echo $selected ?>" style="float:right; margin-right: 20px;" href="<?php echo base_url('reader/setup');?>">Personnaliser</a>

	<h1>Bienvenue dans votre tableau de bord</h1>
	<p>Vous pouvez le personnaliser en choisissant vos flux d'informations préférés via le bouton.
	</p>
</div>