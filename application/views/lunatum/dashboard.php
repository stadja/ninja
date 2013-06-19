<?php set_js_path(array(TEMPLATE_VERSION.'/tabzilla', 'tools')); ?>
<?php //set_js_fx('Tabzilla.toggle();'); ?>

        <div class="header-container">
        	<header class="header-wrapper clearfix">
        		<a href="http://www.mozilla.org/" id="tabzilla"><img src="/ninja/assets/tabzilla/media/img/tab.png" alt=""></a>
        		<ul class="topInfos">
        			<li><a href="<?php echo base_url(''); ?>"><h1 class="title">lunatum</h1></a></li>
        		</ul>
        		<nav>
        			<ul>
        				<li><a href="#">Dr Gorovitchov</a></li>
        				<li><a href="<?php echo base_url(''); ?>" class="active">Tableau <span class="menuBreak"><br /></span>de bord</a></li>
        				<li><a href="#">College <span class="menuBreak"><br /></span>Medical</a></li>
        				<!--<li><a href="#">Pharma <span class="menuBreak"><br /></span>Panels</a></li>-->
        			</ul>
        		</nav>
        	</header>
        </div>

        <div class="main-container">
        	<div id="dashboard">

	    		<?php $this->load->view($main_frame); ?>

        	</div>
        </div> <!-- #main-container -->

        <div class="footer-container">

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
        			<li><a href="<?php echo base_url('admin/tools');?>">Créer/Modifier les outils</a></li>
        		<?php endif; ?>
                <li><a href="<?php echo base_url('reader/tool/20');?>">Un exemple d'échelle</a></li>
        		<li><a href="<?php echo base_url('reader/tool/99');?>">Un exemple de calcul</a></li>
        	</ul>
        	<ul class="toolList">
        		<li>OUTILS MEDICAUX : </li>
        		<li><a href="#">VIDAL</a></li>
        		<li><a href="<?php echo base_url('admin/tools');?>">Outils</a></li>
        		<li><a href="#">AGENDA</a></li>
        		<li><a href="#">CRAT</a></li>
        	</ul>
        </toolbox>
    </footer>

</div>
