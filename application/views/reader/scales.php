<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min", "libs/ember-0.9.8.1.min"));
    set_js_path('scales');
	set_css_path("libs/uniform.default");
	set_js_fx("$('input, textarea').placeholder();
		$('select, input, input:checkbox, input:radio, input:file').uniform();");
?>


<articles>
	<div class='scale'>
    <script type="text/x-handlebars"> 

		<h1>Une échelle</h1>

        <?php echo form_open('reader/scales'); ?>

        {{#each Tools.scaleTool.questionSets}}
            <div class='question_set'>
                <h2>{{label}}</h2>
                {{#each questions}}
                    <div class='question'>
                        <label>
                            {{label}}
                            {{view Ember.Checkbox checkedBinding="isChecked"}} / <b>{{value}}</b>
                        </label>
                    </div>
                {{/each}}
                {{score}} / {{maximum}}
            </div>
        {{/each}}
         <b>{{Tools.scaleTool.score}}</b> /  <b>{{Tools.scaleTool.maximum}}</b>
    </script>

    </script>
	</div>
</articles>