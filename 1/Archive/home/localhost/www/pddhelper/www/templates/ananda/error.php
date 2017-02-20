<?php
/*
 * Error Page 
 *
 * @version             2.0.0
 * @package             Ananda Theme
 * @copyright			Copyright (C) 2015 schefa.com. All rights reserved.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
	
	$app	= JFactory::getApplication(); 
	
if (!isset($this->error)) {
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}

// get template name and parameters
$tpn  = $this->template;
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
$templateName = $this->template;
$params = $app->getTemplate(true)->params;
$sitename = $app->getCfg('sitename');

// send correct HTTP status code
if ($this->error->getCode() == 404 ) {
	header("HTTP/1.0 404 Not Found");
}

require_once('lib/framework.php');
$ananda = new AnandaTemplate($doc);
		
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
    <title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
    
    <?php include_once(JPATH_SITE.'/templates/'.$templateName.'/lib/head.php') ?>
    
	<style type="text/css">
	html,body,#ananda-background-color{height:100%;width:100%;}
	</style>
</head>
<body>

    <div class="offcanvas">
    
        <div class="col-sm-3 offcanvas-smartphones sidebar-offcanvas offcanvas-right visible-xs">
            <?php echo $doc->getBuffer('modules', 'mainmenu', array('style' => 'ananda_sidebar')); ?>
            <?php echo $doc->getBuffer('modules', 'submenu', array('style' => 'ananda_sidebar')); ?>
        </div>
        
        <nav class="navbar navigation-top navbar-fixed-top ananda-nav">
            <div class="container">
            
                <button class="btn navbar-toggle visible-xs" data-toggle="offcanvas" data-id="active-right">
                    <span class="sr-only"><?php echo JText::_("Toggle navigation");?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="hidden-xs pull-left"><?php echo $doc->getBuffer('modules', 'mainmenu', array('style' => 'none')); ?></div>
                
				<?php if($doc->getBuffer('modules', 'social', array('style' => 'none'))) : ?>
                    <div id="social"><?php echo $doc->getBuffer('modules', 'social', array('style' => 'none')); ?></div>
                <?php endif; ?>
                
				<?php if($doc->getBuffer('modules', 'top', array('style' => 'none'))) : ?>
                    <div id="top"><?php echo $doc->getBuffer('modules', 'top', array('style' => 'none')); ?></div>
                <?php endif; ?>
                
            </div>
        </nav>
        
        <?php if($doc->getBuffer('modules', 'header', array('style' => 'none'))) { ?>
        <div class="ananda-headerfull">
        	<?php echo $doc->getBuffer('modules', 'header', array('style' => 'none')); ?>
		</div>
		<?php } ?>
        
        <?php if( $params->get("logo-image") || ($doc->getBuffer('modules', 'search', array('style' => 'none'))) ) { ?>
        <div class="ananda-header">
            <div class="container">
            <div class="row">
                <?php if( $params->get("logo-image")) { ?>
                <div class="col-md-5">
                    <div class="logo"><a href="<?php echo JURI::base(); ?>"><img title="<?php echo $app->getCfg('sitename'); ?>" src="<?php echo JURI::base() . $params->get("logo-image"); ?>" /></a></div>
                </div>
                <?php } ?>
                <div class="col-md-7">
        		<?php if($doc->getBuffer('modules', 'search', array('style' => 'none'))) { ?>
                    <div id="search"><?php echo $doc->getBuffer('modules', 'search', array('style' => 'none')); ?></div>
                <?php } ?>
                </div>
            </div>
            </div>
        </div>
        <?php } ?>
        
        <?php if( ($doc->getBuffer('modules', 'submenu', array('style' => 'none'))) || ($doc->getBuffer('modules', 'login', array('style' => 'none')))) { ?>
        <div class="navigation-bottom ananda-nav">
            <div class="container">
                <div class="row">
                    <div class="col-xs-9 navigation-bottom-inner hidden-xs">
                        <?php echo $doc->getBuffer('modules', 'submenu', array('style' => 'none')); ?>
                    </div>
                    <div class="col-xs-3">
                        <?php echo $doc->getBuffer('modules', 'login', array('style' => 'none')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
        <div class="ananda-maincontent">
            
            <div class="container">
            
                <div class="ananda-content-outer">
                
                	<div id="content">
                        <div class="errorboxoutline">
                            <h2 class="errorboxheader"><?php echo $this->error->getCode(); ?> - Uups</h2>
                            <div class="errorboxbody">
                                <p><strong><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>
                                <div id="techinfo">
                                <p><?php echo $this->error->getMessage(); ?></p>
                                <p>
                                    <?php if ($this->debug) :
                                        echo $this->renderBacktrace();
                                    endif; ?>
                                </p>
                                </div>
                            </div>
                        </div>
					</div>
                 
                </div> 
                
            </div>
              
        </div>
        
		<?php $ananda->getFooter($sitename); ?>  
            
    </div>
    
    </body>
</html>


