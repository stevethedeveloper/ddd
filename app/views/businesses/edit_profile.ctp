<?
$this->pageTitle = 'Edit Your Merchant Profile'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$html->image('no_image.png', array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Edit Your Merchant Profile</h3>
					<br clear="both" />
					<hr />
					<h4 class="blue">Address</h4>
					<div class="form_label">Address 1</div>
					<div class="form_field"><?=$form->text('Business.address_1', array('size' => '25'))?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_label">Address 2</div>
					<div class="form_field"><?=$form->text('Business.address_2', array('size' => '25'))?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_label">City</div>
					<div class="form_field"><?=$form->text('Business.city', array('size' => '25'))?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_label">State</div>
					<div class="form_field"><?=$statesList->select('Business.state', null)?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_label">Zip Code</div>
					<div class="form_field"><?=$form->text('Business.zip', array('size' => '10'))?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_label">Phone #</div>
					<div class="form_field"><?=$form->text('Business.phone', array('size' => '15'))?></div>

					<br clear="both" />
					<br clear="both" />
					<h4 class="blue">Details</h4>
					<div class="form_label">Website</div>
					<div class="form_field"><?=$form->text('Business.website', array('size' => '25'))?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_label">Twitter</div>
					<div class="form_field"><?=$form->text('Business.twitter', array('size' => '25'))?></div>
					<br clear="both" />
					<div style="color: #666666; width: 325px; margin-left: 100px;">Don't have a Twitter account?  Go to twitter.com to find out more information.</div>

					<br clear="both" />
					<br clear="both" />
					<h4 class="blue">Merchant Description</h4>
					<div class="form_note">Give a brief description of your business for customers.</div>
					<br clear="both" />
					<span class="orange mediumtext">140</span> <span class="gray mediumtext">characters remain</span>
					<br clear="both" />
					<div class="form_field"><?=$form->textarea('Business.description', array('cols' => '65', 'rows' => '5'))?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="floatleft"><?=$form->submit('buttons/save.png')?></div>
					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
				</div>
			</div>
	    </div>

