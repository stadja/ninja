jQuery.support.cors = true;


/************************** 
* Application 
**************************/ 
Tools = Ember.Application.create({ 
	rootElement: '#scaleToolRoot',
	setId: function(toolId) {
		Tools.scaleTool.set('id', toolId); 
	},
	parse: function(description) {
		// Tools.toolDescription = '{ "title" : "Une échelle", "questionSets" : {"0" : { "questions" : {"0" : { "label" : "Question", "value" : "Score" }}, "title" : "Titre du set de question" }} }';
		// Tools.toolDescription = JSON.parse(Tools.toolDescription);
		Tools.toolDescription = description;

		Tools.scaleTool.set('title',Tools.toolDescription.title);

		jQuery.each(Tools.toolDescription.questionSets, function(index, value) {
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
					fatherSet: Tools.questionSetTemp,
				});
				Tools.questionSetTemp.get('questions').pushObject(Tools.questionTemp);
			});
			Tools.scaleTool.get('questionSets').pushObject(Tools.questionSetTemp);
		});
	}
});


/**************************
* Models 
**************************/ 
Tools.scale = Ember.Object.extend({ 
	id: null,
	title: 'Une échelle', 
	questionSets: [],
	maximum: function() {
		var questionSets = this.get('questionSets');
		var maximum = 0;
		$(questionSets).each(function(index, value){ 
			maximum += parseInt(value.get('maximum')); 
		});
		return maximum;
	}.property('questionSets.@each.maximum'),
	score: function() {
		var score = 0;
		var questionSets = this.get('questionSets');
		$(questionSets).each(function(index, value){ 
			score += parseInt(value.get('score')); 
		});
		return score;
	}.property('questionSets.@each.score'),
	addQuestionSet: function() {
		Tools.questionSetTemp = Tools.questionSet.create({
			id : this.get('questionSets').length,
			label: 'Titre du set de question',
			questions: [],
		});
		this.get('questionSets').pushObject(Tools.questionSetTemp);
	},
	serialize: function() {
		var output = '{ "title" : "'+this.get('title')+'", "questionSets" : {';

		var questionSets = this.get('questionSets');

		$(questionSets).each(function(index, value){ 
			output += value.serialize(); 
			if (index < ($(questionSets).length - 1)) {
				output += ', ';
			}
		});

		output += '} }';

		return output;
	}
});

Tools.questionSet = Ember.Object.extend({ 
	id: null,
	label: '', 
	questions: [],
	maximum: function() {
		var questions = this.get('questions');
		var maximum = 0;
		$(questions).each(function(index, value){ 
			maximum += parseInt(value.get('value')); 
		});
		return maximum;
	}.property('questions.@each.value'),
	score: function() {
		var score = 0;
		var questions = this.get('questions');
		$(questions).each(function(index, value){ 
			score += parseInt(value.get('score')); 
		});
		return score;
	}.property('questions.@each.score'),
	addQuestion: function() {
		Tools.questionTemp = Tools.question.create({
			id: this.questions.length, 
			label: 'Question',
			value: 'Score',
			fatherSet: this
		});
		this.get('questions').pushObject(Tools.questionTemp);
	},
	serialize: function() {
		
		var output = '"'+this.get('id')+'" : { "questions" : {'; 

		var questions = this.get('questions');
		$(questions).each(function(index, value){ 
			output += value.serialize();
			if (index < ($(questions).length - 1)) {
				output += ', ';
			}
		});
		output += '}, '+'"title" : "'+this.get('label')+'" }';

		return output;
	}
});

Tools.question = Ember.Object.extend({ 
	id: null,
	label: '',
	isChecked : false,
	value: 0,
	fatherSet: null,
	score: function() {
		if (!this.get('isChecked')) {
			return 0;
		}
		return this.get('value');
	}.property('isChecked'),
	serialize: function() {
		
		var output = '"'+this.get('id')+'" : { "label" : "'+this.get('label')+'", "value" : "'+this.get('value')+'" }'; 

		return output;
	}
});



/************************** 
* Views 
**************************/ 

Tools.EditScaleView = Ember.View.extend({
    addQuestion: function(event) {
    	event.context.bindingContext.addQuestion();
	},
	suppressQuestion: function(event) {
		var question = event.context.bindingContext;
		question.get('fatherSet').get('questions').removeObject(question);
	},
    addQuestionSet: function(event) {
    	event.context.addQuestionSet();		
	},
    suppressQuestionSet: function(event) {
    	Tools.scaleTool.get('questionSets').removeObject(event.context.bindingContext);
	},
	saveScale: function(event) {
		var serialized = event.context.serialize();	
		var scaleId = event.context.get('id');	
		$.ajax({
		  type: 'POST',
		  url: '/ninja/admin/save_scale',
		  data: {id : scaleId, serialization : serialized},
		  success: function(){alert("C'est bien sauvegard\xE9 !");}
		});
	}
});

/************************** 
* Controllers 
**************************/

Tools.scaleTool = Tools.scale.create({id: 1});

// Tools.toolDescription = '{ "title" : "Une échelle de test", "questionSets" : {"question1" : { "questions" : {"a" : { "label" : "Question bla bla ?", "value" : "1" }, "b" : { "label" : "Question bla bla ?", "value" : "2" }, "c" : { "label" : "Question bla bla ?", "value" : "1" }}, "title" : "Set de Question numéro 1" }, "question2" : { "questions" : {"a" : { "label" : "Question bla bla ?", "value" : "5" }, "b" : { "label" : "Question bla bla ?", "value" : "1" }, "c" : { "label" : "Question bla bla ?", "value" : "2" }}, "title" : "Set de Question numéro 2" }} }';
// Tools.toolDescription = JSON.parse(Tools.toolDescription);
// console.log(Tools.toolDescription);

// Tools.scaleTool.set('title',Tools.toolDescription.title);

// jQuery.each(Tools.toolDescription.questionSets, function(index, value) {
// 	Tools.questionSetTemp = Tools.questionSet.create({
// 		id : index,
// 		label: value.title,
// 		questions: [],
// 	});

// 	jQuery.each(value.questions, function(questionIndex, questionValue){
// 		Tools.questionTemp = Tools.question.create({
// 			id: questionIndex, 
// 			label: questionValue.label,
// 			value: questionValue.value,
// 			fatherSet: Tools.questionSetTemp,
// 		});
// 		Tools.questionSetTemp.get('questions').pushObject(Tools.questionTemp);
// 	});
// 	//console.log(Tools.questionSetTemp);
// 	Tools.scaleTool.get('questionSets').pushObject(Tools.questionSetTemp);
// });

