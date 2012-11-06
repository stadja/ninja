<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min", "libs/handlebars", "libs/ember"));
    set_js_path('scales');
    set_css_path("libs/uniform.default");
    // set_css_path("print");
	set_js_fx("$('input, textarea').placeholder();
		$('select, input, input:checkbox, input:radio, input:file').uniform();");

    if ($scale) {
        set_js_fx("Tools.parse(".$scale->serialization.");");
    }
?>


<div id="main" class="wrapper clearfix">

    <h2>Information du patient</h2>
    <input type="text" name="firstname" id="firstname" placeholder="Prénom">
    <input type="text" name="name" id="name" placeholder="Nom">
    <hr>

	<div class='scale' id='scaleToolRoot'>
    <script type="text/x-handlebars"> 
		<h1>{{Tools.scaleTool.title}}</h1>

        <?php echo form_open('reader/scales'); ?>

        {{#each Tools.scaleTool.questionSets}}
            <div class='question_set'>
                <h2>{{label}}</h2>
                {{#each questions}}
                    <div class='question'>
                        <label>
                            {{label}}
                            {{#if question}}
                                {{view Ember.Checkbox checkedBinding="isChecked"}} / <b>{{value}}</b>
                            {{/if}}
                        </label>
                    </div>
                {{/each}}
                {{score}} / {{maximum}}
            </div>
        {{/each}}
        <hr/>
        <h1>Résultat: {{Tools.scaleTool.score}} /  {{Tools.scaleTool.maximum}}</h1>
	</form>
    </script>
    <hr/>
    <?php if ($scale->results != ''): ?>
        <h1>Explication des résultats</h1>
        <?php echo $scale->results; ?>
        <hr/>
    <?php endif ?>
	</div>

    <a id='printit' onclick="javascript:window.print();return false;" href="#">Imprimer le test</a>

</div>
