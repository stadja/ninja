<?php
/**
 * generate full pics path 
 * @param string $pic, name of the image file (ie. 'logout.png','alert.gif') 
 * @return full web path to the images "ressources" folder.
 * @author Stéphane Legouffe
*/
if ( ! function_exists('setPicPath')) {
	function setPicPath($pic) {
		
		//-- Définition des chemins dans lequels sont stokés les fichiers CSS.
		$ressources_app_path = APPPATH.'views/ressources/img/';
		$ressources_web_path = base_url().'application/views/ressources/img/';
		
		// on test l'existence du fichier...
		if(!file_exists($ressources_app_path.$pic)) { // si il n'existe pas, on retourne une erreur
			return "Img error : The img file : <b>".$ressources_app_path.$pic."</b> doesn't exists";
		} else { //-- si l'image existe, on renvoi le chemin "web" complet.
			return $ressources_web_path.$pic;
		}
	}
}


/**
 * Set all jascript function, declaration, etc...at the bottom of the page
 * in $.(readay) function, in order to prevent javascript function execution
 * before the entire DOM is load.
 * @param string $js_fx, javascript function 
 * @return void.
 * @author Stéphane Legouffe
*/

if ( ! function_exists('set_js_fx')) {
	function set_js_fx($js_fx) {
		//-- création de la variable d'instance permettant d'accéder au tableau des fichiers JS.
		$CI =& get_instance();
		if(!isset($CI->a_js_fx)) { $CI->a_js_fx = array(); }
	
		$CI->a_js_fx[] = $js_fx;
	}
}



/**
 * generate full JS path 
 * @param string $js, name of the js file witout extension (.js) - (ie. 'draganddrop.js','edit_entry.js') 
 * @return full web path to the js "ressources" folder.
 * @author Stéphane Legouffe
*/

if ( ! function_exists('set_js_path')) {
	function set_js_path($m_js) {
	
		//-- création de la variable d'instance permettant d'accéder au tableau des fichiers JS.
		$CI =& get_instance();
		if(!isset($CI->a_js)) { $CI->a_js = array(); }
	
		//-- Définition des chemins dans lequels sont stokés les fichiers JS.
		$ressources_app_path = APPPATH.'views/ressources/js/';
		$ressources_web_path = base_url().'application/views/ressources/js/';
		
		if(!is_array($m_js) OR !(sizeOf($m_js) > 0)) {
			$m_js = array($m_js);
		}
		
		foreach($m_js AS $js) {
			if(preg_match('/^http/',$js)) { // si il n'existe pas, on retourne une erreur
				$path = $js;
			} else {
				$js.= '.js';
				// on test l'existence du fichier...
				if(!file_exists($ressources_app_path.$js)) { // si il n'existe pas, on retourne une erreur
					$path = "JS Error : The JS file : <b>".$ressources_app_path.$js."</b> doesn't exists";
				} else { //-- si le fichier JS existe, on renvoi le chemin "web" complet.
					$path =  $ressources_web_path.$js;
				}
			}
			//--
			$CI->a_js[] = $path;
		}
	}	
}

/**
 * generate full CSS path 
 * @param string $css, name of the css file witout extension (.css) - (ie. 'draganddrop','edit_entry') 
 * @return full web path to the css "ressources" folder.
 * @author Stéphane Legouffe
*/
if ( ! function_exists('set_css_path')) {
	function set_css_path($m_css) {
		
		//-- création de la variable d'instance permettant d'accéder au tableau des fichiers JS.
		$CI =& get_instance();
		if(!isset($CI->a_css)) { $CI->a_css = array(); }
	
		//-- Définition des chemins dans lequels sont stokés les fichiers JS.
		$ressources_app_path = APPPATH.'views/ressources/css/';
		$ressources_web_path = base_url().'application/views/ressources/css/';
		
		if(!is_array($m_css) OR !(sizeOf($m_css) > 0)) {
			$m_css = array($m_css);
		}

		foreach($m_css AS $css) {
			if(preg_match('/^http/',$css)) { // si il n'existe pas, on retourne une erreur
				$path = $css;
			} else {
				$css.= '.css';
				// on test l'existence du fichier...
				if(!file_exists($ressources_app_path.$css)) { // si il n'existe pas, on retourne une erreur
					$path = "CSS Error : The CSS file : <b>".$ressources_app_path.$css."</b> doesn't exists";
				} else { //-- si le fichier JS existe, on renvoi le chemin "web" complet.
					$path =  $ressources_web_path.$css;
				}
			}
			//--
			$CI->a_css[] = $path;
		}
		
	}
}
?>