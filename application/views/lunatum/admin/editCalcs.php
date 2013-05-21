<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min"));
    set_js_path('calcs');
	set_css_path("libs/uniform.default");
    set_js_fx("$('input, textarea').placeholder();
        $('select, input, input:checkbox, input:radio, input:file').uniform();");
    set_js_fx('calcId = '.$toolId.';');

    $tool = json_decode($tool->serialization);
?>


<div id="main" class="wrapper clearfix">
	<div class='scale' id='scaleToolRoot'>
    
        <form id='vars_form'>
            <div id="vars">
                <?php if ($tool): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($tool->vars as $var): ?>
                        <div id='var_<?php echo $i; ?>' style='border: 1px dashed; margin-bottom: 10px;'>
                            <input name='id' type="text" placeholder='Id de la variable' value='<?php echo $var->id; ?>'/><br/>
                            <input name='title' type="text" placeholder='Nom de la variable' value='<?php echo $var->title; ?>'/><br/>
                            <textarea name='description' placeholder='Description de la variable' /><?php echo $var->description; ?></textarea>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div id='var_1' style='border: 1px dashed; margin-bottom: 10px;'>
                        <input name='id' type="text" placeholder='Id de la variable'/><br/>
                        <input name='title' type="text" placeholder='Nom de la variable'/><br/>
                        <textarea name='description' placeholder='Description de la variable' /></textarea>
                    </div>
                <?php endif; ?>
            </div>
            <a href='#' class="add_var">+ Ajouter une variable</a>
            <br/>
            <br/>
            <input type="text" name="formula" placeholder="formule" value='<?php echo isset($tool) ? $tool->formula : ''; ?>'/><br />
            <br/>
            <input type="submit" id='var_submit' value='sauver le formulaire'/>
            <br/>
        </form>

	</div>
</div>
