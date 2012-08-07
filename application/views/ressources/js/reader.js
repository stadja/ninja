jQuery.support.cors = true;

/************************** 
* Application 
**************************/ 
RSSreader = Ember.Application.create({  
	read: function(fluxId, isExternal){
		RSSreader.rssCollection.read(fluxId, isExternal);
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
	newsCollection: null,
	preview: null,
	testBinding: function() {
		var id = this.get('id');
		var lastUpdate = this.get('lastUpdate');
		return id + ' ' + lastUpdate;
	}.property('id', 'lastUpdate'),
	init: function(){ 
			this._super();
			this.newsCollection = Ember.ArrayController.create({
				content: []
			}); 
			this.preview = Ember.ArrayController.create({
				content: []
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
				me.preview.clear();
				var i = 0;
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
					if (i < 5) {
						me.preview.pushObject(news);
						i++;
					}
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


/************************** 
* Controllers 
**************************/

RSSreader.rssCollection = Ember.ArrayController.create({ 
	content: [], 
	init: function(){ 
		this._super();
		flux = [];
		previewRss = [];
	}, 
	read: function(fluxId, isExternal) {
		rssCollection = this;

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
					var j = 0;
					$(jsonObject.newsCollection).each(function(index, value){ 
						var news = RSSreader.news.create({ 
							title: value.title,
							description: value.description,
							link: value.link
						}); 
						flux[fluxId].newsCollection.pushObject(news);
						if (j < 5) {
							flux[fluxId].preview.pushObject(news);
							j++;
						}
					});
				}
			}
/**/
			if (flux[fluxId] == '') {
				flux[fluxId] = RSSreader.RSSflux.create({ 
					id: fluxId,
					// previewRss: function() {
					// 	return this.get('newsCollection');
					// }.property()
				});
			}

		}
		rssCollection.set(fluxId, flux[fluxId]);
		flux[fluxId].update(fluxId);

	}
});
