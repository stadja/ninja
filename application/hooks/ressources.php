<?php
/**
 * output all JS file in a "<script src...>" html tag
 * @param mixed optionel $m_js, name of the js file witout extension (.js) - (ie. 'draganddrop','edit_entry') 
 * @return "<script src...>" HTML tags for each $m_js value

 * output all CSS file in a "<link>" html tag
 * @param mixed $m_css, name of the css file witout extension (.css) - (ie. 'draganddrop','edit_entry') 
 * @return "<link>" HTML tags for each $m_css value
 *
 * Remplace le tag [css] par les balises "<link>" sur l'ensemble des fichiers CSS de l'application
 * Remplace également le tag [javascript] par les balises "<script >"  de l'application

 * @author Stéphane Legouffe
*/
class Ressources {
	
	/**
	 */
	function set_ressources() {
		$CI = &get_instance();
		
		if(!isset($CI->a_css)) { $CI->a_css = array(); }
		if(!isset($CI->a_js)) { $CI->a_js = array(); }
		if(!isset($CI->a_js_fx)) { $CI->a_js_fx = array(); }
		
		$content = $CI->output->get_output();
		
		// Parcours du tableau des fichiers CSS pour en générer les balises "<link>" nécessaires à l'application
		$s_link = "";
		if(sizeOf($CI->a_css) > 0) {
			foreach($CI->a_css AS $css) {
				// on test les éventuelles erreur liés à l'absence du fichier sur le serveur. 
				if(preg_match('/CSS Error/',$css)) {
					$s_link.= $css."<br>";
				} else {
					if (!strstr($css, '?') && !strstr($css, 'libs')) {
						$css .= '?t='.time();
					}
					$s_link.= '<link href="'.$css.'" rel="stylesheet" type="text/css" media="all" />'."\n";
				}
			}
		}
		$content = preg_replace('/\[css\]/i',$s_link,$content);
		
		// Parcours du tableau des fichiers JS pour en générer les balises "<script>" nécessaires à l'application
		$s_script = "";
		if(sizeOf($CI->a_js) > 0) {
			foreach($CI->a_js AS $js) {
				// on test les éventuelles erreur liés à l'absence du fichier sur le serveur. 
				if(preg_match('/JS Error/',$js)) {
					$s_script.= $js."<br>";
				} else {
					if (!strstr($js, '?') && !strstr($js, 'libs')) {
						$js .= '?t='.time();
					}
					$s_script.= '<script type="text/javascript" src="'.$js.'"></script>'."\n";
				}
			}
		}
		$content = preg_replace('/\[javascript\]/i',$s_script,$content);
			
			
		// Parcours du tableau des functions javascript appelées dans les différentes parties de l'application
		$s_script = "";
		if(sizeOf($CI->a_js_fx) > 0) {
			$s_script = "<script language=\"javascript\">"."\n";
			$s_script.= "$().ready(function () {"."\n";
				foreach($CI->a_js_fx AS $fx) {
					$s_script.= $fx."\n";
				}	
			$s_script.= "});"."\n";
			$s_script.= "</script>"."\n";
		}
		$content = preg_replace('/\[javascript_fx\]/i',$s_script,$content);
		
		
		// On affiche le contenu HTML de l'application
		echo $content;
	}
}
?>