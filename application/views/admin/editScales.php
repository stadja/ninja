<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min", "libs/ember-0.9.8.1.min"));
    set_js_path('scales');
	set_css_path("libs/uniform.default");
    set_js_fx("$('input, textarea').placeholder();
        $('select, input, input:checkbox, input:radio, input:file').uniform();");
	
	set_js_fx("Tools.setId(".$toolId.");");
    if ($scale) {
        set_js_fx("Tools.parse(".$scale->serialization.");");
    }
?>


<div id="main" class="wrapper clearfix">
	<div class='scale'>
    <script type="text/x-handlebars"> 
		<h1>{{view Ember.TextArea valueBinding="Tools.scaleTool.title"}}</h1>

        <?php echo form_open('reader/scales'); ?>

        {{#each Tools.scaleTool.questionSets}}
            <div class='question_set'>
                <h2>{{view Ember.TextArea valueBinding="label"}}                
                    {{#view Tools.EditScaleView contentBinding="this"}}
                        <a {{action "suppressQuestionSet" on="click"}}>
                            Supprimer le set
                        </a>
                    {{/view}}
                </h2>

                {{#each questions}}
                    <div class='question'>
                        <label>
                            {{view Ember.TextArea valueBinding="label"}}
                            {{view Ember.Checkbox checkedBinding="isChecked"}} / <b>{{view Ember.TextField valueBinding="value"}}</b>
                            {{#view Tools.EditScaleView contentBinding="this"}}
                                <a {{action "suppressQuestion" on="click"}}>
                                Supprimer la question
                                </a>
                            {{/view}}
                        </label>

               
                    </div>
                {{/each}}
                {{#view Tools.EditScaleView contentBinding="this"}}
                    <a {{action "addQuestion" on="click"}}>
                        Ajouter une question
                    </a>
                {{/view}}
                {{score}} / {{maximum}}
            </div>
        {{/each}}
        {{#view Tools.EditScaleView contentBinding="this"}}
            <a {{action "addQuestionSet" on="click" context="Tools.scaleTool"}}>
                Ajouter un set de questions
            </a>
        {{/view}}
         <b>{{Tools.scaleTool.score}}</b> /  <b>{{Tools.scaleTool.maximum}}</b>
        <div>
            {{#view Tools.EditScaleView contentBinding="this"}}
                <a {{action "saveScale" on="click" context="Tools.scaleTool"}}>
                    Sauvez cette échelle
                </a>
            {{/view}}
        </div>
	</form>
    </script>
	</div>
</div>
