<?php 
/**
 *
 * Framework
 *
 * @version             2.0.0
 * @package             Ananda
 * @copyright			Copyright (C) 2014 vonfio.de. All rights reserved.
 *               
 */
  
// No direct access.
defined('_JEXEC') or die;

class AnandaTemplate
{
	var $doc;
	var $params;
	
	public function __construct($doc, $params = NULL) {
		$this->doc = $doc;
		$this->params = $params;
	}
			
	public function getNavbarToggle ()
	{
		$html[] = '<button class="btn navbar-toggle visible-xs" data-toggle="offcanvas" data-id="active-right">';
        $html[] = '<span class="icon-bar"></span>';
        $html[] = '<span class="icon-bar"></span>';
        $html[] = '<span class="icon-bar"></span>';
        $html[] = '</button>';
		echo implode("\n", $html);
	}
				
	public function getModule ( $name, $class ="ananda-module", $style = "xhtml" )
	{
		if( $this->doc->countModules($name) )
		{
			echo '<div class="'.$class.'"><jdoc:include type="modules" name="'.$name.'" style="'.$style.'" /></div>';
		}
	}

    public function getModulesContainer($modules = array(), $prefix = "col-sm-", $containerClass = "ananda-module-container" )
    { 
	
 		$count		= count($modules);
 
 		foreach($modules AS $key => $value) { if(!$this->doc->countModules($key)) { $count--; unset($modules[$key]);} }
        
		if(!empty($modules) && ($count <= 6)) {
			
			$count = (int) ( 12 / $count );
			
			echo '<div class="'.$containerClass.'"><div class="row">';
				
				foreach($modules AS $key => $value)
				{
					echo '<div class="'.$prefix .	$count	.'">';
					self::getModule( $key, 'ananda-module ananda-'.$key , $value );
					echo '</div>';
				}
				
			echo '</div></div>';
			
		}
		
	}
	
	public function getSidebarModule ( $name, $content_width )
	{
		if( $this->doc->countModules($name) )
		{ ?>
            <div class="offcanvas-btn offcanvas-btn-<?php echo $name; ?> visible-xs" data-toggle="offcanvas" data-id="active-<?php echo $name; ?>"><?php echo $this->params->get("toggleLeft"); ?></div>
            <div class="col-sm-<?php echo $content_width[0]; ?> sidebar-offcanvas offcanvas-<?php echo $name; ?>" id="<?php echo $name; ?>-sidebar">
                <jdoc:include type="modules" name="<?php echo $name; ?>" style="ananda_sidebar" />
            </div> 
        <?
		}
	}

	public function getContentWidth()
	{
	
		$content_width = array();
		if($this->doc->countModules('left') && $this->doc->countModules('right'))
			$content_width = array('3', '6');
		if(($this->doc->countModules('left') && !$this->doc->countModules('right')) or (!$this->doc->countModules('left') && $this->doc->countModules('right'))) 
			$content_width = array('3', '9');
		if(!$this->doc->countModules('left') && !$this->doc->countModules('right'))
			$content_width = array('0', '12');
		
		return $content_width;
	}
	
	
	public function getFooter($sitename)
	{
		?>
        <div id="ananda-footer">
            <div class="container"><div class="row">
                
                <?php $this->getModulesContainer(array('position-11'=>'ananda','position-12'=>'ananda','position-13'=>'ananda','position-14'=>'ananda')); ?>

                <div id="copy">&copy; <?php echo JHTML::Date( 'now', 'Y' ); ?> <?php echo $sitename; ?></div>
                <?php self::getModule( "footer", "footer-content textcenter" ); ?>
                <div id="webdesign-by" class="footer-content">designed by <a href="http://www.schefa.com" target="_blank">schefa</a></div>
                
            </div></div>
        </div>
        <?php
	}
}

?>