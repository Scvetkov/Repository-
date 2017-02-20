<?php 
/**
 *
 * modules view
 *
 * @version             1.0.0
 * @package             Ananda Theme
 * @copyright			Copyright (C) 2015 schefa.com. All rights reserved.
 *               
 */
 
// No direct access. 
defined('_JEXEC') or die;


function modChrome_ananda_sidebar( $module, &$params, &$attribs )
{
	
	$headerLevel = (isset( $attribs['headerLevel'] )) ? $attribs['headerLevel'] : 3;
	
	echo '<div class="ananda-module-sidebar' .$params->get( 'moduleclass_sfx' ) .'" >';
	 
		if ($module->showtitle) 
			echo '<h' .$headerLevel .'>' .$module->title .'</h' .$headerLevel .'>';
 
    	echo '<div class="ananda-module-inside">' . $module->content . '</div>';
 
    echo '</div>';
}


function modChrome_ananda ( $module, &$params, &$attribs )
{
	
	$class			= (isset( $attribs['class'] )) ? $attribs['class'] : "ananda-module";
	$headerLevel	= (isset( $attribs['headerLevel'] )) ? $attribs['headerLevel'] : 3;
	
	$document	= JFactory::getDocument();
	if( $document->countModules($attribs['name']) ) {
			
		echo '<div class="module'. $params->get( 'moduleclass_sfx' ) . ' ' . $class .'" >';
		 
			if ($module->showtitle)
				echo '<h' .$headerLevel .'>' .$module->title .'</h' .$headerLevel .'>';
	 
			echo '<div class="module-inside">' . $module->content . '</div>';
	 
		echo '</div>';
	}
}

?>