<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/


/*
| -------------------------------------------------------------------------
| Ressources 
| -------------------------------------------------------------------------
| Création d'un hook permettant d'injecter les fichiers JS et CSS 
| dans le DOM
|
|
*/

$hook['display_override'][] = array(
                                'class'    => 'ressources',
                                'function' => 'set_ressources',
                                'filename' => 'ressources.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );


/* End of file hooks.php */
/* Location: ./application/config/hooks.php */