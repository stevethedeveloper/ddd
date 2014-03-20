<?
$this->pageTitle = 'Edit Company Logo'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?php echo $form->create('Business', array('type' => 'file', 'action' => 'manage_company_logo')); ?>
					<?=$form->hidden('Business.id')?>
					<?=$html->image($logo."?foo=".md5(time()), array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Company Logo</h3>
					<br clear="both" />
					<hr />
					<br clear="both" />
					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<div class="form_field"><?=$form->input('Image.filedata', array('between'=>'<br />','type'=>'file', 'label' => ''));?></div>
						<br clear="both" />
						<?=$html->image($logo."?foo=".md5(time()), array('style' => 'float: right;margin-right: 20px;'))?>
						<div class="form_label gray">Maximum size of 700k.  JPG, GIF, PNG.</div>
						<br clear="both" />
						<div class="floatleft"><?php echo $html->link($html->image('buttons/delete_current.png', array('style' => 'float: right;margin-right: 10px;')), array('controller'=>'businesses', 'action' => 'manage_delete_company_logo'), array('escape' => false), 'Are you sure?');?></div>
						<div class="floatleft"><?=$form->submit('buttons/save_small.png')?></div> 
						<br clear="both" />
						<br clear="both" />
					</div>
					<div class="rounded_box_bottom">
					</div>
					<?=$form->end()?>
				</div>
			</div>
	    </div>

