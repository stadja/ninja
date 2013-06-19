$().ready(function () {

$.ajax({
dataType: "json",
url: "/ninja/reader/json_get_specialities",
success: function(data) {
	var list = "<li><a class='speciality_element' href='/ninja/reader/json_get_tool_by_specialities/'>Tous les outils</a></li>";
	$(data).each(function(speciality) {
		list += "<li><a class='speciality_element' href='/ninja/reader/json_get_tool_by_specialities/"+this.id+"'>"+this.name+"</a></li>";
	});
	$('#speciality').html(list);
	$('.speciality_element').click(function() {
		Tabzilla.closeSubmenu($('#tool_title'), $('#tool_list'));
		populate_tool_list($(this).attr('href'));
		return false;
	});
}
});
populate_tool_list("/ninja/reader/json_get_tool_by_specialities");

});

var populate_tool_list = function(url) {
	$.ajax({
		dataType: "json",
		url: url,
		success: function(data) {
			var list = "";
			$(data).each(function(speciality) {
				list += "<li><a target='_blank' href='/ninja/reader/tool/"+this.id+"'>"+this.title+"</a></li>";
			});
			$('#tool_list').html(list);
			Tabzilla.openSubmenu($('#tool_title'), $('#tool_list'), $('#speciality').height());
		}
	});
}

