var calcId = false;
var numOfField = 1;

$('.add_var').click(function() {
	numOfField++;

	var new_var = $('#var_1').clone();

	$(new_var).attr('id', 'var_'+numOfField);

	$(new_var).children().each(function() {
		$(this).val('');
		var oldId = ''+$(this).attr('name');
		var newId = oldId.replace(/var_1/,'var_'+numOfField);
		$(this).attr('name', newId)
	});

	$('#vars').append($(new_var));
	return false;
});

$( "#vars_form" ).on( "submit", function( event ) {
	if (calcId) {
		event.preventDefault();
		var values = [];
		$.each($(this).serializeArray(), function() {
			if (values[this.name] == undefined) {
				values[this.name] = [];
			}
			values[this.name].push(this.value);
		});

		var i = 0;
		var serialized = '{ "vars" : [';
		$.each($(values['id']), function() {
			if (i) {
				serialized += ',';
			}
			serialized += '{"id" : "'+values['id'][i]+'", "title" : "'+values['title'][i]+'", "description" : "'+values['description'][i]+'"} ';
			i++;
		});
		serialized += '], "formula" : "'+values['formula'][0]+'" }';

		$.ajax({
		  type: 'POST',
		  url: '/ninja/admin/save_tool/calc',
		  data: {id : calcId, serialization : serialized},
		  success: function(){alert("C'est bien sauvegard\xE9 !");}
		});
	}
});