<?
$this->pageTitle = 'Purchase more Push Offers'; 
?>
		<div id='main_right'>
			<div id='maincontent_right'>
				<div id="left">
					<br clear="both" />
					<?=$html->image('no_image.png', array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Purchase more Push Offers</h3>
					<br clear="both" />
					<br clear="both" />
					I don't need anymore push offers.  <a href="" class="blue">Go back to your Profile.</a>
					<br clear="both" />
					<br clear="both" />
					<div class="step_header">
						<div class="foot">1</div>
						<h3><strong>How many Push Offers would you like to buy?</strong></h3>
					</div>
					<br clear="both" />
					<br clear="both" />
					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<div class="form_field"><?=$form->select('Business.previous', array('1' => '1 Push'), null, null, false)?></div>
						<div style="float: left;font-size: 16px;margin: 6px 0 0 10px;">this purchase costs <strong>$25</strong>.</div>
						<br clear="both" />
					</div>
					<div class="rounded_box_bottom">
					</div>
					<div style="color: #666666;font-size: 12px;">&nbsp;Note: Individual Push notifications purchased here <strong>DO NOT</strong> expire.</div>
					<br clear="both" />
					<br clear="both" />
					<h4 class="blue">Upgrade Opportunity</h4>
					<input type="checkbox" /> <strong>Yes.</strong> I would like to Upgrade my Account.
					<br clear="both" />
					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<strong style="font-size: 16px;">Upgrade Details:</strong>
						<br clear="both" />
						<br clear="both" />
						Hey, some text goes here.
						<br clear="both" />
						<br clear="both" />
						<strong style="float: left;padding: 10px 10px 0 0;">Change my plan to:</strong> <div class="form_field"><?=$form->select('Business.previous', array('premium' => 'Premium Plan - 21 Push Offers a month for $349'), null, null, false)?></div>
						<br clear="both" />
					</div>
					<div class="rounded_box_bottom">
					</div>
					<br clear="both" />
					<br clear="both" />
					
					<div class="step_header">
						<div class="foot">2</div>
						<h3><strong>Confirm your billing information - SECURE</strong></h3>
					</div>
					<br clear="both" />
					<br clear="both" />
					<div class="gray">We can charge the individual Push Offers to the Credit Card we have on file<br />via your subscription to the service.  Otherwise, modify the information below.</div>
					<br clear="both" />
					<br clear="both" />
					<h4 class="blue">Card Details</h4>
					<div class="form_label">Card Number</div>
					<div class="form_field"><?=$form->text('Business.card_number', array('size' => '25'))?></div>
					<div class="form_field">&nbsp;&nbsp;<?=$html->image('cards.png')?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_label">Expires on</div>
					<div class="form_field"><?=$form->dateTime('Business.card_exp', 'MY', 'NONE', 'today', array( 'label' => NULL, 'minYear' => date('Y')));?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_label">Billing Zip</div>
					<div class="form_field"><?=$form->text('Business.card_zip', array('size' => '10'))?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="form_note">By clicking Make the Purchase you agree to the <a href="#">Terms of Service</a>, <a href="#">Privacy</a>, and <a href="#">Refund Policiy</a>.</div>
					<br clear="both" />
					<br clear="both" />

					<div class="rounded_color_top">
					</div>
					<div class="rounded_color_middle">
						<div class="step_header">
							<div class="foot">3</div>
							<h3><strong>Your Receipt</strong></h3>
						</div>
						<br clear="both" />
						<br clear="both" />
						<div style="font-size: 16px;">
						You've chosen to purchase <strong>4 push offers</strong> at <strong>$25 each</strong>.
						<br clear="both" />
						You will be billed <strong>$100</strong>.
						</div>
						<br clear="both" />
						All sales are final.
						<br clear="both" />
						<br clear="both" />
						<?=$form->submit('buttons/make_the_purchase.png')?>
					</div>
					<div class="rounded_color_bottom">
					</div>
				</div>
				<div id="right">
				</div>
			</div>
	    </div>

