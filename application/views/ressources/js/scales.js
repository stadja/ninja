jQuery.support.cors = true;


/************************** 
* Application 
**************************/ 
Tools = Ember.Application.create({ 
});


/**************************
* Models 
**************************/ 
Tools.scale = Ember.Object.extend({ 
	id: null,
	title: '', 
	questionSets: [],
	maximum: function() {
		var questionSets = this.get('questionSets');
		var maximum = 0;
		$(questionSets).each(function(index, value){ 
			maximum += value.get('maximum'); 
		});
		return maximum;
	}.property('questionSets.@each.maximum'),
	score: function() {
		var score = 0;
		var questionSets = this.get('questionSets');
		$(questionSets).each(function(index, value){ 
			score += value.get('score'); 
		});
		return score;
	}.property('questionSets.@each.score'),
});

Tools.questionSet = Ember.Object.extend({ 
	id: null,
	label: '', 
	questions: [],
	maximum: function() {
		var questions = this.get('questions');
		var maximum = 0;
		$(questions).each(function(index, value){ 
			maximum += value.get('value'); 
		});
		return maximum;
	}.property('questions.@each.value'),
	score: function() {
		var score = 0;
		var questions = this.get('questions');
		$(questions).each(function(index, value){ 
			score += value.get('score'); 
		});
		return score;
	}.property('questions.@each.score'),
});

Tools.question = Ember.Object.extend({ 
	id: null,
	label: '',
	isChecked : false,
	value: 0,
	score: function() {
		if (!this.get('isChecked')) {
			return 0;
		}
		return this.get('value');
	}.property('isChecked'),
});



/************************** 
* Views 
**************************/ 


/************************** 
* Controllers 
**************************/

Tools.scaleTool = Tools.scale.create({});

Tools.toolDescription = '{"question1": {"questions": { "a": { "label": "Question bla bla ?", "value": 1 }, "b": { "label": "Question bla bla ?", "value": 2 }, "c": { "label": "Question bla bla ?", "value": 1 }},"title": "Set de Question numéro 1"},"question2": {"questions": { "a": { "label": "Question bla bla ?", "value": 5 }, "b": { "label": "Question bla bla ?", "value": 1 }, "c": { "label": "Question bla bla ?", "value": 2 }},"title": "Set de Question numéro 2"}}';

Tools.toolDescription = JSON.parse(Tools.toolDescription);

jQuery.each(Tools.toolDescription, function(index, value) {
	Tools.questionSetTemp = Tools.questionSet.create({
		id : index,
		label: value.title,
		questions: [],
	});

	jQuery.each(value.questions, function(questionIndex, questionValue){
		Tools.questionTemp = Tools.question.create({
			id: questionIndex, 
			label: questionValue.label,
			value: questionValue.value,
		});
		Tools.questionSetTemp.get('questions').pushObject(Tools.questionTemp);
	});
	//console.log(Tools.questionSetTemp);
	Tools.scaleTool.get('questionSets').pushObject(Tools.questionSetTemp);
});

