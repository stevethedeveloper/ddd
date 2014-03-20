<?
$this->pageTitle = 'Edit Company Logo'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$html->image('no_image.png', array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Company Logo</h3>
					<br clear="both" />
					<hr />
					<br clear="both" />
					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<br clear="both" />
						<div class="form_field"><?=$form->file('Business.company_logo', array('size' => '30'))?></div>
						<br clear="both" />
						<?=$html->image('no_image.png', array('style' => 'float: right;margin-right: 20px;'))?>
						<div class="form_label gray">Maximum size of 700k.  JPG, GIF, PNG.</div>
						<br clear="both" />
						<div class="floatleft"><?=$form->submit('buttons/delete_current.png', array('style' => 'padding-right: 10px;'))?></div>
						<div class="floatleft"><?=$form->submit('buttons/save_small.png')?></div> 
						<br clear="both" />
						<br clear="both" />
					</div>
					<div class="rounded_box_bottom">
					</div>
				</div>
			</div>
	    </div>

