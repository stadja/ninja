jQuery.support.cors = true;

/************************** 
* Application 
**************************/ 
RSSreader = Ember.Application.create({  
	rootElement: '#fluxRSS',
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
	newsCollection: [],
	preview: function() {
		return this.get('newsCollection').toArray();
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
				window.setTimeout(masonry_beep,10);
			}
			me.update();
		});
	},	
});



/************************** 
* Views 
**************************/ 
Handlebars.registerHelper("for", function forLoop(arrayToSummarize, options) {
	var data = Ember.Handlebars.get(this, arrayToSummarize, options.fn);

	if (data.length == 0) {
		return 'Chargement...';
	}

  	filtered = data.slice(options.hash.start || 0, options.hash.end || data.length);

  	var ret = "";
	for(var i=0; i< filtered.length; i++) {
		ret = ret + options.fn(filtered[i]);
	}
	return ret;		
});

Handlebars.registerHelper('linkTo', function(url, img, title, options) {
  var url = Ember.Handlebars.get(this, url, options);
  var title = Ember.Handlebars.get(this, title, options);
  if (options.hash.isExternal || 0) {
	return new Handlebars.SafeString('<a target="_blank" href="'+url+'""><img src="'+img+'">'+title+'</a>');
  } else {
	return new Handlebars.SafeString('<a href="'+url+'""><img src="'+img+'">'+title+'</a>');
  }
});

/************************** 
* Controllers 
**************************/

RSSreader.rssCollection = Ember.ArrayController.create({ 
	content: [], 
	init: function(){ 
		this._super();
		flux = [];
	}, 
	read: function(fluxId, isExternal) {		

		rssCollection = this;
		fluxNumber = fluxId;
		fluxId = 'flux'+fluxId;
		flux[fluxId] = rssCollection.get(fluxId);
		if (!flux[fluxId]) {
			flux[fluxId] = '';
			if(typeof localStorage!='undefined') {
			// if(false) {
				var fluxStored = localStorage.getItem('fluxRSS_'+fluxNumber);
				// Vérification de la présence du compteur
				if(fluxStored != null) {
					var jsonObject = JSON.parse(fluxStored);
					if (isExternal == 1) {
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
					id: fluxNumber
				});
			}

		}
		rssCollection.set(fluxId, flux[fluxId]);
		flux[fluxId].update(fluxId, fluxNumber);

		window.setTimeout(masonry_beep,10);
	}
});


masonry_beep = function() {
	if($('#masonry_hook').length) {
		$('#masonry_hook').masonry({
					  // options
					  itemSelector : '.masonry_block',
					});
	}
}