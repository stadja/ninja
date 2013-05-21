<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min", "libs/handlebars", "libs/ember", "libs/jquery.calx"));
    set_js_path('calcs');
	set_css_path("libs/uniform.default");
    set_js_fx("$('input, textarea').placeholder();
        $('select, input, input:checkbox, input:radio, input:file').uniform();");

    set_js_fx("$('#total').attr('data-formula', $('#formula').val());");
    set_js_fx("$('#calx').calx();");

    $vars = json_decode($tool->serialization);
?>


<div id="main" class="wrapper clearfix">

    <h2>Information du patient</h2>
    <input type="text" name="firstname" id="firstname" placeholder="Prénom">
    <input type="text" name="name" id="name" placeholder="Nom">
    <hr>

	<div class='scale' id='scaleToolRoot'>

        <h1><?php echo $tool->title; ?></h1>
        <form id="calx">
            <?php foreach($vars->vars as $var): ?>
                <b><?php echo $var->title; ?></b><br />
                <input type="text" id="<?php echo $var->id; ?>" value="" data-format="format:number" /><br />
                <?php echo $var->description; ?><br /><br />
            <?php endforeach; ?>

            <h1>Total: </h1>
            <input type="text" id="total" data-formula="<?php echo $vars->formula; ?>" data-format="format:number" /><br /><br />
            
        </form>

    <hr/>
    <?php if ($tool->results != ''): ?>
        <h1>Explication des résultats</h1>
        <?php echo $tool->results; ?>
        <hr/>
    <?php endif ?>
    </div>

     <a id='printit' onclick="javascript:window.print();return false;" href="#">Imprimer le test</a>
</div>
