<div id="wide-margins">
	<div id="header-container">
		<header class="wrapper clearfix">
			<div id="user-header">
				<ul>
					<li id="title"><a href="<?php echo base_url();?>">Dr <?php echo $user->name; ?></a></li>
					<li id="logout"><a href="<?php echo base_url('account/disconnect');?>">D&eacute;connexion</a></li>
				</ul>
			</div>

			<nav>
				<ul>
					<li><a href="#">Outils</a></li>

					<?php $selected = (isset($page_chosen) && ($page_chosen == 'board')) ? 'selected' : ''; ?>
					<li><a href="<?php echo base_url();?>" class="<?php echo $selected; ?>">&nbsp;Tableau de bord&nbsp;</a></li>

					<li><a href="#">&nbsp;Pharma Panels&nbsp;</a></li>

					<li><a href="#">&nbsp;Collège Medical&nbsp;</a></li>

					<li><a href="#">&nbsp;Pharma Panels&nbsp;</a></li>

					<?php $selected = (isset($page_chosen) && ($page_chosen == 'board')) ? 'selected' : ''; ?>
					<li><a href="<?php echo base_url();?>" class="<?php echo $selected; ?>">&nbsp;Tableau de bord&nbsp;</a></li>

				</ul>
			</nav>
		</header>
	</div>

	<div id="main-container">
			<div id="dashboard">
				
				

<?php $this->load->view($main_frame); ?>

			</div>
	</div> <!-- #main-container -->

	<div id="footer-container">
		<footer class="wrapper">
			<toolbox>					
					<?php if ($user->hasRights('admin')) :?>
						<ul class="toolList">
							<li><a href="<?php echo base_url('admin/invit');?>">Inviter de nouveaux utilisateurs</a></li>
						</ul>
						<ul class="toolList">
							<li><a href="<?php echo base_url('admin/addFlux');?>">Créer/Gérer flux</a></li>
						</ul>
					<?php endif; ?>
						<ul class="toolList">
					<?php if ($user->hasRights('admin')) :?>
						<li><a href="<?php echo base_url('admin/tools');?>">Créer/Modifier les échelles</a></li>
					<?php endif; ?>
						<li><a href="<?php echo base_url('reader/scales');?>">Un exemple d'échelle</a></li>
						</ul>
					<ul class="toolList">
						<li>OUTILS MEDICAUX : </li>
						<li><a href="#">VIDAL</a></li>
						<li><a href="<?php echo base_url('reader/scales');?>">ECHELLES</a></li>
						<li><a href="#">OUTILS DE CALCULS</a></li>
						<li><a href="#">AGENDA</a></li>
						<li><a href="#">CRAT</a></li>
					</ul>
				</toolbox>
		</footer>
	</div>
</div>
