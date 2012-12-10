<?php 
	set_js_path(array("libs/jquery-ui.min", "libs/jquery.placeholder.min", "libs/chosen.jquery.min", "libs/jtable/jquery.jtable", "cdc"));
	set_css_path(array("libs/chosen", "libs/jquery-ui", "libs/jtable/blue/jtable_blue"));
	// set_js_fx("$('.chzn-select').chosen().change(function(){show_news_table($(this).val());});");
	set_js_fx("$('.chzn-select').chosen().change(function(){window.open('writeNews/'+$(this).val())});");

?>

<?php $this->load->view('lunatum/fragments/headerNews', array('page_news' => 'write')); ?>

<div id="main" class="wrapper clearfix">
	<h1>Publiez une news</h1>

		<select class="chzn-select" tabindex="1" style="width:350px;" data-placeholder="Séléctionnez un flux">
			<option value=""></option>	
			<?php foreach ($user->getCDCFlux() as $flux) : ?>
				<option value="<?php echo $flux->getId(); ?>"><?php echo $flux->getTitle(); ?></option>
			<?php endforeach; ?>
		</select>

		<div id="NewsTableContainer"></div>
</div>