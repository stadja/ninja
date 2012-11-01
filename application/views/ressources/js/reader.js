jQuery.support.cors = true;

/************************** 
* Application 
**************************/ 
RSSreader = Ember.Application.create({  
	rootElement: '#fluxRSS',
	read: function(fluxId, isExternal, minPreview, maxPreview){
		isExternal = 1;
		if (minPreview == undefined) {
			minPreview = 0;
		}
		if (maxPreview == undefined) {
			maxPreview = 1;
		}
		RSSreader.rssCollection.read(fluxId, isExternal, minPreview, maxPreview);
	},
	init: function() {
		this._super();
		//alert('hop');
	}
});

/**************************
* Models 
**************************/ 
RSSreader.news = Ember.Object.extend({ 
	title: null, 
	description: null,
	link: null,
	openingLink: function() {
		return '<a href="'+this.get('link')+'">';
	}.property('link'),
	openingExternalLink: function() {
		return '<a target="_blank" href="'+this.get('link')+'">';
	}.property('link'),
});

RSSreader.RSSflux = Ember.Object.extend({ 
	id: null, 
	lastUpdate: 0,
	newsCollection: [],
	minPreview: 0,
	maxPreview: 3,
	preview: function() {
		var minPreview = this.get('minPreview');
		var maxPreview = this.get('maxPreview');
		return this.get('newsCollection').filter(function(item, index, self) {
				if ((index >= minPreview) && (index <= maxPreview)) { return true; }
			});
	}.property('newsCollection.@each'),
	testBinding: function() {
		var id = this.get('id');
		var lastUpdate = this.get('lastUpdate');
		return id + ' ' + lastUpdate;
	}.property('id', 'lastUpdate'),
	init: function(){ 
			this._super();
			this.newsCollection = Ember.ArrayController.create({
				content: [],
			});  
		},
	update: function(fluxId) {
		var me = this;
		$.getJSON("http://stadja.net:8080/readRss/"+this.id+"/"+this.lastUpdate, function(data){
			if (data.timeout != 1) {
				var jsonWannabeFlux = new Object();
				jsonWannabeFlux.id = me.get('id');
				jsonWannabeFlux.lastUpdate = data.lastUpdate;
				jsonWannabeFlux.newsCollection = [];
				
				me.set('lastUpdate', data.lastUpdate);
				me.newsCollection.clear();
				$(data.articles).each(function(index, value){ 
					var jsonNews = new Object();
					jsonNews.title = value.title;
					jsonNews.description = value.description;
					jsonNews.link = value.link;
					var news = RSSreader.news.create({ 
						title: value.title,
						description: value.description,
						link: value.link
					}); 
					me.newsCollection.pushObject(news);
					jsonWannabeFlux.newsCollection.push(jsonNews);
				});
				if(typeof localStorage!='undefined') {
					localStorage.setItem('fluxRSS_'+me.get('id'), JSON.stringify(jsonWannabeFlux));
				}
			}
			me.update();
		});
	},	
});



/************************** 
* Views 
**************************/ 
// Handlebars.registerHelper("for", function forLoop(arrayToSummarize, options) {
// 	var context = (options.fn.contexts && options.fn.contexts[0]) || this;
// 	var data = Ember.Handlebars.get(context, arrayToSummarize, options.fn);

// 	console.log($(data.content));


// 	// var startIndex = options.hash.start || 0;
// 	// var endIndex = options.hash.end || data.content.length;
// 	// if (endIndex > data.content.length) {
// 	// 	endIndex = data.content.length - 1;
// 	// }
// 	// if (startIndex >= data.content.length) {
// 	// 	startIndex = 0;
// 	// }

// 	// for(i = startIndex; i <= endIndex; i++) {
// 	//     options(data.content[i]);
// 	// }
// });

/************************** 
* Controllers 
**************************/

RSSreader.rssCollection = Ember.ArrayController.create({ 
	content: [], 
	init: function(){ 
		this._super();
		flux = [];
	}, 
	read: function(fluxId, isExternal, minPreview, maxPreview) {
		rssCollection = this;
		fluxNumber = fluxId;
		fluxId = 'flux'+fluxId;
		flux[fluxId] = rssCollection.get(fluxId);
		if (!flux[fluxId]) {
			flux[fluxId] = '';
			if(typeof localStorage!='undefined') {
			// if(false) {
				var fluxStored = localStorage.getItem('fluxRSS_'+fluxId);
				// Vérification de la présence du compteur
				if(fluxStored != null) {
					var jsonObject = JSON.parse(fluxStored);
					if ((isExternal == 1)) {
						jsonObject.lastUpdate = 0;
					}

					flux[fluxId] = RSSreader.RSSflux.create({ 
						id: jsonObject.id,
						lastUpdate: jsonObject.lastUpdate
					});
					$(jsonObject.newsCollection).each(function(index, value){ 
						var news = RSSreader.news.create({ 
							title: value.title,
							description: value.description,
							link: value.link
						}); 
						flux[fluxId].newsCollection.pushObject(news);
					});
				}
			}
/**/
			if (flux[fluxId] == '') {
				flux[fluxId] = RSSreader.RSSflux.create({ 
					id: fluxNumber,
					minPreview: minPreview,
					maxPreview: maxPreview
				});
			}

		}
		rssCollection.set(fluxId, flux[fluxId]);
		flux[fluxId].update(fluxId, fluxNumber);

	}
});