	<div id="header-container">
		<header class="wrapper clearfix">
			<h1 id="title">NINJA Project</h1>
			<nav>
				<ul>
					<li><a href="#">nav ul li a</a></li>
					<li><a href="#">nav ul li a</a></li>
					<li><a href="#">nav ul li a</a></li>
				</ul>
			</nav>
		</header>
	</div>
	<div id="main-container">
		<div id="main" class="wrapper clearfix">
			<div id="dashboard">
				<toolbox>
                    <ul class="toolList">
                            <li><a href="<?php echo base_url('account/disconnect');?>">D&eacute;connexion</a></li>
                    </ul>
					
					<?php if ($user->hasRights('admin')) :?>
						<ul class="toolList">
							<li><a href="#">Utilisateurs</a></li>
							<li><a href="<?php echo base_url('admin/invit');?>">Inviter</a></li>
						</ul>
						<ul class="toolList">
							<li><a href="#">Flux</a></li>
							<li><a href="<?php echo base_url('admin/addFlux');?>">Créer flux</a></li>
							<li><a href="<?php echo base_url('admin/changeFluxRights');?>">Gérer droits</a></li>
						</ul>
					<?php endif; ?>
					<?php if ($user->hasRights('cdc')) :?>
						<ul class="toolList">
							<li><a href="#">Ajout de news</a></li>
							<li><a href="<?php echo base_url('cdc/addNews');?>">Ecrire</a></li>
						</ul>
					<?php endif; ?>
					<?php if ($user->hasRights('reader')) :?>
						<ul class="toolList">
							<li><a href="#">MES FLUX D'INFOS</a></li>
							<li><a href="<?php echo base_url('reader/setup');?>">PERSONNALISATION</a></li>
							<li><a href="<?php echo base_url('reader');?>">Consultation</a></li>
						</ul>
					<?php endif; ?>
					<ul class="toolList">
						<li><a href="#">OUTILS MEDICAUX</a></li>
						<li><a href="#">VIDAL</a></li>
						<li><a href="#">ECHELLES</a></li>
						<li><a href="#">OUTILS DE CALCULS</a></li>
						<li><a href="#">AGENDA</a></li>
						<li><a href="#">CRAT</a></li>
					</ul>
				</toolbox>
				

<?php $this->load->view($main_frame); ?>

			</div>
		</div> <!-- #main -->
	</div> <!-- #main-container -->

	<div id="footer-container">
		<footer class="wrapper">
			<h3>footer</h3>
		</footer>
	</div>
