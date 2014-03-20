<?
$this->pageTitle = 'Welcome'; 
?>
				<div id="widget_content">
					<div align="center"><?=$html->image('logo.png')?></div>
					<div align="center"><?=$html->link('View Full Site', '/')?></div>
					<br clear="both" />
					<?
						echo $this->renderElement('widget_mobile');
					?>
				</div>
	    </div>
