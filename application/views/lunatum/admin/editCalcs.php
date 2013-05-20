<?php 
	set_js_path(array("libs/jquery.uniform.min", "libs/jquery.placeholder.min", "libs/handlebars", "libs/ember", "libs/jquery.calx"));
    set_js_path('calcs');
	set_css_path("libs/uniform.default");
    set_js_fx("$('input, textarea').placeholder();
        $('select, input, input:checkbox, input:radio, input:file').uniform();");

    set_js_fx("$('#total').attr('data-formula', $('#formula').val());");
    set_js_fx("$('#formula').keyup(function() {
        $('#total').attr('data-formula', $('#formula').val());
        $('#calx').calx();
    });");
    set_js_fx("$('#formula').change(function() {
       $('#calx').calx();
    });");
    set_js_fx("$('#calx').calx();");
	
?>


<div id="main" class="wrapper clearfix">
	<div class='scale' id='scaleToolRoot'>
    

<form id="calx">
    Price :<br />
    <input type="text" id="price" value="3.001" data-format="format:number" /><br />
    Qty :<br />
    <input type="text" id="qty" value="4" data-format="format:number"/><br />
    Formula :<br />
    <input type="text" id="formula" value="$qty*$price" data-format="format:formula"/><br />
    Total :<br />
    <input type="text" id="total" data-formula="" data-format="format:number" /><br />
</form>

	</div>
</div>
