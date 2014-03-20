<?
$this->pageTitle = 'Pricing & Sign Up'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<h3>Previous Exploding Offers</h3>
					<div class="form_field"><?=$form->select('Business.previous', array('previous' => 'Start from a previous offer'), null, null, false)?></div>
					<br clear="both" />
					<br clear="both" />
					<h3 class="floatleft">Start a New Exploding Offer</h3><div class="form_note floatleft add_offer_note">Need help? <a href="#">Send us an email</a>.</div>
					<br clear="both" />
					<h4 class="blue">Deal &amp; Date</h4>
					<div class="floatleft">Basic Deal</div><div class="form_note floatleft">&nbsp;(As it will appear in listings)</div>
					<br clear="both" />
					<span class="orange mediumtext">40</span> <span class="gray mediumtext">characters</span>
					<br clear="both" />
					<div class="form_field"><?=$form->textarea('Business.basic_deal', array('cols' => '65', 'rows' => '3'))?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="floatleft">Deal Details</div><div class="form_note floatleft">&nbsp;(Text to appear with offer)</div>
					<br clear="both" />
					<span class="orange mediumtext">200</span> <span class="gray mediumtext">characters remain</span>
					<br clear="both" />
					<div class="form_field"><?=$form->textarea('Business.deal_details', array('cols' => '65', 'rows' => '5'))?></div>
					<br clear="both" />
					<br clear="both" />



					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<div class="form_field"><?=$form->text('Business.offer_date', array('size' => '10'))?></div>
						<br clear="both" />
						<div class="form_label">Date of Offer</div>
						<br clear="both" />
						<br clear="both" />
						<br clear="both" />
						<br clear="both" />
						<div class="form_label">Range in Time</div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_field"><?=$form->dateTime('Business.deal_time', 'NONE', '12');?> through <?=$form->dateTime('Business.deal_time', 'NONE', '12');?></div>
						<br clear="both" />
						<br clear="both" />
						<br clear="both" />
						<div class="floatleft">Code Word?</div><div class="form_note floatleft">&nbsp;(A 'password' to validate the special deal)</div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_field gray"><input type="radio"> No Code Word&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"> Yes, use a Code Word</div>
						<div class="form_field">&nbsp;&nbsp;&nbsp;&nbsp;<?=$form->text('Business.offer_date', array('size' => '10'))?></div>
					</div>
					<div class="rounded_box_bottom">
					</div>

					<br clear="both" />
					<h4 class="blue">Deal Details</h4>
					<div class="form_label">Type of Deal</div>
					<br clear="both" />
					<div class="form_field"><?=$form->select('Business.previous', array('previous' => 'Choose...'), null, null, false)?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_label">Meal</div>
					<br clear="both" />
					<div class="form_field"><?=$form->select('Business.previous', array('previous' => 'Choose...'), null, null, false)?></div>
					<br clear="both" />
					<br clear="both" />

					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<br clear="both" />
						<strong>The specifics of your deal.</strong>
						<br clear="both" />
						<br clear="both" />
						<div class="form_label">Offer applies to</div>
						<br clear="both" />
						<div class="form_field"><?=$form->select('Business.previous', array('previous' => 'Choose...'), null, null, false)?></div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_label">Discount type</div>
						<br clear="both" />
						<div class="form_field">
							<?=$form->select('Business.previous', array('previous' => 'Choose...'), null, null, false)?>
							&nbsp;&nbsp;
							<?=$html->image('right_arrow_on.png')?>
							&nbsp;&nbsp;
							<?=$form->select('Business.previous', array('previous' => 'Choose...'), null, null, false)?>
							&nbsp;&nbsp;
							<?=$html->image('right_arrow_off.png')?>
							&nbsp;&nbsp;
							<?=$form->text('Business.offer_date', array('size' => '10'))?>
						</div>
						<br clear="both" />
						<br clear="both" />
					</div>
					<div class="rounded_box_bottom">
					</div>

					<br clear="both" />
					<br clear="both" />
					<div class="floatleft"><?=$form->submit('buttons/save.png')?></div> <div class="form_note floatleft"><br />&nbsp;&nbsp;<a href="">Cancel</a></div>
					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
				</div>
			</div>
	    </div>

