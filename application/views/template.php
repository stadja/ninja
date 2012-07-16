<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title></title>

	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width">

	
	[css]
	<?php set_css_path('style'); ?>
	<script src="<?php echo base_url('application/views/ressources/js/libs/modernizr-2.5.3-respond-1.1.0.min.js'); ?>"></script>

	<!-- start Mixpanel --><script type="text/javascript">(function(d,c){var a,b,g,e;a=d.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===d.location.protocol?"https:":"http:")+'//api.mixpanel.com/site_media/js/api/mixpanel.2.js';b=d.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b);c._i=[];c.init=function(a,d,f){var b=c;"undefined"!==typeof f?b=c[f]=[]:f="mixpanel";g="disable track track_links track_forms register register_once unregister identify name_tag set_config".split(" ");for(e=0;e<
g.length;e++)(function(a){b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,0)))}})(g[e]);c._i.push([a,d,f])};window.mixpanel=c})(document,[]);
mixpanel.init("f6481ae94bbedfbed9bc16ea216a640a");</script><!-- end Mixpanel -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('application/views/ressources/css/print.css'); ?>" media="print" />
</head>
<body>

<div id='spy'></div>
<script type="text/javascript">  
function spy() {  
	var spy_alreadyReceived = $('#spy').html();
	if (spy_alreadyReceived == ''){
		spy_alreadyReceived = 0;
	}


	$.getJSON("http://stadja.net:8080/spy/"+spy_alreadyReceived, 
			function(data) { 
				if (data.timeout) {
					spy();
					return;
				}

				if (data.written) {
					$('#spy').html(data.written); 
				} else {
					$('#spy').html(''); 					
				}
				spy();
				return;
			});  
}
</script>

<?php $this->load->view($main_view); ?>

<script src="<?php echo base_url('application/views/ressources/js/libs/jquery-1.7.2.min.js'); ?>"></script>
[javascript][javascript_fx]

<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

</body>
</html>
