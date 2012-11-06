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

			jQuery.each(value.questions, function(elementIndex, elementValue){
				switch(elementValue.type) {
					case 'text':
						Tools.elementTemp = Tools.text.create({
							id: elementIndex, 
							label: elementValue.label,
							fatherSet: Tools.questionSetTemp,
						});
					break;
					case 'question':
					default:
						Tools.elementTemp = Tools.question.create({
							id: elementIndex, 
							label: elementValue.label,
							value: elementValue.value,
							fatherSet: Tools.questionSetTemp,
						});
					break;
				}

				Tools.questionSetTemp.get('questions').pushObject(Tools.elementTemp);
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
			if(value.get('value') > 0) {
				maximum += parseInt(value.get('value')); 
			}
		});
		return maximum;
	}.property('questions.@each.value'),
	score: function() {
		var score = 0;
		var questions = this.get('questions');
		$(questions).each(function(index, value){ 
			if(value.get('score') > 0) {
				score += parseInt(value.get('score')); 
			}
		});
		return score;
	}.property('questions.@each.score'),
	changeTypeElement: function(element) {
		var indexElement = this.get('questions').indexOf(element);
		if (element.get('type') == 'text') {
			this.get('questions').replace(indexElement, 1, [this.createQuestion(element)]);
		} else {
			this.get('questions').replace(indexElement, 1, [this.createText(element)]);
		}
	},
	createQuestion: function(element) {
		var prefilled = (element != undefined);
		return Tools.question.create({
					id: (prefilled) ? element.get('id') : this.questions.length, 
					label: (prefilled) ? element.get('label') : 'Question',
					fatherSet: (prefilled) ? element.get('fatherSet') : this
				});
	},
	createText: function(element) {
		var prefilled = (element != undefined);
		return Tools.textTemp = Tools.text.create({
					id: (prefilled) ? element.get('id') : this.questions.length, 
					label: (prefilled) ? element.get('label') : 'Texte',
					fatherSet: (prefilled) ? element.get('fatherSet') : this
				});
	},
	addQuestion: function() {
		this.get('questions').pushObject(this.createQuestion());
	},
	addText: function() {
		this.get('questions').pushObject(this.createText());
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

Tools.element = Ember.Object.extend({ 
	id: null,
	label: '',
	fatherSet: null,
	type: 'element',
	serialize: function() {
		var output = '"'+this.get('id')+'" : { "label" : "'+this.get('label')+'", "type" : "'+this.get('type')+'" }'; 
		return output;
	}
});

Tools.question = Tools.element.extend({ 
	isChecked : false,
	value: 'Score',
	question: 1,
	type: 'question',
	score: function() {
		if (!this.get('isChecked')) {
			return 0;
		}
		return this.get('value');
	}.property('isChecked'),
	serialize: function() {
		var output = '"'+this.get('id')+'" : { "label" : "'+this.get('label')+'", "value" : "'+this.get('value')+'", "type" : "'+this.get('type')+'" }'; 
		return output;
	}
});

Tools.text = Tools.element.extend({ 
	type: 'text'
});



/************************** 
* Views 
**************************/ 

Tools.EditScaleView = Ember.View.extend({
    addQuestion: function(event) {
    	this.bindingContext.addQuestion();
	},
    addText: function(event) {
    	this.bindingContext.addText();
	},
	changeTypeElement: function(event) {
		var element = this.bindingContext;
		element.get('fatherSet').changeTypeElement(element);
	},
	suppressElement: function(event) {
		var element = this.bindingContext;
		element.get('fatherSet').get('questions').removeObject(element);
	},
    addQuestionSet: function(event) {
    	Tools.scaleTool.addQuestionSet();		
	},
    suppressQuestionSet: function(event) {
    	Tools.scaleTool.get('questionSets').removeObject(this.bindingContext);
	},
	saveScale: function(event) {
		var serialized = Tools.scaleTool.serialize();	
		var scaleId = Tools.scaleTool.get('id');	
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

