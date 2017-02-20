<?php
/*
 * @version             2.0.0
 * @package             Ananda Theme
 * @copyright			Copyright (C) 2015 schefa.com. All rights reserved.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
	
$app			= JFactory::getApplication(); 
$doc			= JFactory::getDocument();
$view			= $app->input->getCmd('view', '');
$itemid			= $app->input->getVar('Itemid');
$templateName	= $this->template;
$sitename		= $app->getCfg('sitename');

// Ananda Framework
require_once(JPATH_SITE.'/templates/'.$templateName.'/lib/framework.php');
$ananda = new AnandaTemplate($doc, $this->params);

// Component Width
$content_width = $ananda->getContentWidth();
	
// Pageclass
$menu		= $app->getMenu();
$active		= $menu->getItem($itemid);
$params 	= $menu->getParams( $active->id );
$pageclass	= $params->get( 'pageclass_sfx' );

?>
    
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
	<jdoc:include type="head" />
    
    <?php include_once(JPATH_SITE.'/templates/'.$templateName.'/lib/head.php') ?>
    
</head>

<body class="<?php echo $view . '-view ' . $pageclass; ?>">
    
    <div class="offcanvas">
    
        <div class="col-sm-3 offcanvas-smartphones sidebar-offcanvas offcanvas-right visible-xs">
        	<?php $ananda->getModule( "mainmenu", "module", "ananda_sidebar" ) ?>
            <?php $ananda->getModule( "submenu", "module","ananda_sidebar" ) ?>
        </div>
        
        <?php
		// Mainmenu & Top
		if( $doc->countModules('mainmenu') || $doc->countModules('top') ) {
		?>
        <nav class="navbar navigation-top navbar-fixed-top ananda-nav">
            <div class="container">
                <?php $ananda->getModule( "logo", "brand-logo visible-xs" ) ?>
        		<?php $ananda->getNavbarToggle(); ?>
                <?php $ananda->getModule( "mainmenu", "hidden-xs pull-left" ) ?>
                <?php $ananda->getModule( "top", "ananda-top" ) ?>
            </div>
        </nav>
        <?php } ?>
        
        <?php $ananda->getModule( "header", "ananda-headerfull" ) ?>
        
        <?php 
		// Logo & Search
		if( $doc->countModules('logo') || ($doc->countModules('search')) ) {
			if( $doc->countModules('logo') && ($doc->countModules('search')) ) { 	
				$headerWidth = array("7", "5");
			} else {
				$headerWidth = array("12", "12");
			}
		?>
        <div class="ananda-header">
            <div class="container">
                <?php if(!$doc->countModules('mainmenu') && !$doc->countModules('top') ) { $css = ""; } else { $css = " hidden-xs"; } ?>
                <?php $ananda->getModule("logo","logo col-sm-".$headerWidth[0] . $css ) ?>
                <?php $ananda->getModule("search","ananda-search col-sm-". $headerWidth[1],"none") ?>
            </div>
        </div>
        <?php } ?>
		
        <?php
		// Submenu
		if( ($doc->countModules('submenu')) || ($doc->countModules('login')) )
		{
			if( $doc->countModules('submenu') && ($doc->countModules('login')) ) { 	
				$navBottomWidth = array("9", "3");
			} else {
				$navBottomWidth = array("12", "12");
			}
		?>
        <div class="navigation-bottom ananda-nav <?php if(!$doc->countModules('login') && ($doc->countModules('mainmenu') || $doc->countModules('top'))) { ?>hidden-xs<?php } ?>">
            <div class="container"><div class="row">
				<?php $ananda->getModule( "submenu", "col-xs-". $navBottomWidth[0] ."  navigation-bottom-inner hidden-xs" ) ?>
				<?php $ananda->getModule( "login", "col-xs-". $navBottomWidth[1] ) ?>
        		<?php $ananda->getNavbarToggle(); ?>
            </div></div>
        </div>
        <?php } ?>
        
        <div class="ananda-maincontent">
            
            <div class="container">
            
                <?php $ananda->getModulesContainer( array( 'position-1' => 'xhtml', 'position-2' => 'xhtml', 'position-3' => 'xhtml', 'position-3' => 'xhtml', 'position-4' => 'xhtml', 'position-5' => 'xhtml', 'position-6' => 'xhtml' ) ); ?>
                
                <div class="ananda-content-outer offcanvas">
                
                    <div class="row">
                    
                        <?php $ananda->getSidebarModule("left",$content_width); ?>
                        
                        <div class="col-sm-<?php echo $content_width[1]; ?>" id="content-outer">
                        
        					<?php $ananda->getModule("banner","ananda-banner","none") ?>
            
        					<?php $ananda->getModule("breadcrumbs","ananda-breadcrumbs") ?>
                            
                            <div id="content">
                                <jdoc:include type="message" />
								<?php require_once(dirname(__FILE__) .'/css/system.php'); ?>
                                <jdoc:include type="component" />
                            </div>
                            
							<?php $ananda->getModulesContainer(array('content-bottom-1'=>'xhtml','content-bottom-2'=>'xhtml','content-bottom-3'=>'xhtml')); ?>
                     
                        </div>
                    
                        <?php $ananda->getSidebarModule("right",$content_width); ?>
                            
                    </div>
                     
                </div> 
                
				<?php $ananda->getModulesContainer( array( 'position-7' => 'xhtml', 'position-8' => 'xhtml', 'position-9' => 'xhtml', 'position-10' => 'xhtml' ) ); ?>
                            
            </div>
              
        </div>
        
        <?php $ananda->getFooter($sitename); ?>
                     
    </div>
    
</body>
</html>