<?php
/**
 * debug : print human readable information about a variable
 * if $mixed is an array or object, the debug function add "<pre>" tag for a human readable render
 * 
 * <code>
 * <?php
 * $a_data = array('this is an','example');	
 * debug($a_data,'txt');
 * //--This will ouput 
 * array(....) * 2;
 * ?>
 * </code>
 * @param mixed $data, define 
 * @param string $output, optional : define the ouput method (screen,email,js(trougth firebug console))
 * @return -
 * @author Stéphane Legouffe
 * @copyright 2008 - 2011 Stéphane Legouffe
*/
if ( ! function_exists('debug')) {
	function debug($data,$output = "txt") { 
		$s_data = '';
		if(is_array($data) || is_object($data)) {
			$s_data = "<pre>";
				$s_data.= print_r($data, true);
			$s_data.= "</pre>";
		} else {
			$s_data.= $data;
		}
		//--
		if($output == "html") {
			setDebugHtml($s_data);
		} else {
			echo $s_data."<br/>----------<br/>";
		}
	}  
}

/**
 * setDebugHtml : display content in a nice HTML representation
 * 
 * @param mixed $data
 * @author Stéphane Legouffe
 * @copyright 2008 - 2011 Stéphane Legouffe
*/
if ( ! function_exists('setDebugHtml')) {
	function setDebugHtml($data) {
		$uniqId = uniqid();
		$html = '<div id="debugBox'.$uniqId.'" style="height:150px; width:650px; background-color:#DEFDE2; margin-left:100px; margin-top:20px; border:1px solid #64AF64; position:absolute; z-index:20000; padding:2px;">';
			$html.= '<div style="width:645px; height:20px; border-bottom:1px dotted #64AF64;">';
				$html.= '<div style="float:left; padding-left:5px; font-weight:bold;">Debug Output <span style="font-weight:normal;"> - '.date('H:i:s').'</span></div>';
				$html.= '<div style="float:right; padding-right:5px;"><a href="javascript:void(0);" onClick="$(\'#debugBox'.$uniqId.'\').css(\'display\',\'none\');" style="font-size:11px; color:#000;">X fermer</a></div>';
			$html.= '</div>';
			$html.= '<div style="clear:both;"></div>';
			$html.= '<div style="padding-left:5px; height:130px; overflow:scroll;">'.$data.'</div>';
		$html.= '</div>';
		//---
		echo $html;
	}
}
?>