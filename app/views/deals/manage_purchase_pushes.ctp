<?
$this->pageTitle = 'Purchase More Push Offers';
$price = 25;
?>
		<div id='main_right'>
			<div id='maincontent_right'>
				<div id="left">
					<?=$form->create('Business', array('url' => '/manage/deals/purchase_pushes'))?>
					<br clear="both" />
					<?=$html->image($logo, array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Purchase more Push Offers</h3>
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
						<script language="javascript" type="text/javascript">
						function updateTotal(num) {
							var total = 0;
							total = num * <?=$price?>;
							document.getElementById('push_total').innerHTML = total;
							document.getElementById('push_total2').innerHTML = total;
							if (num == 1) {
								document.getElementById('push_summary').innerHTML = '1 push offer';
							} else {
								document.getElementById('push_summary').innerHTML = num + ' push offers';
							}
						}
						</script>					
						<?
						$pushes = array('1' => '1 Push');
						for ($i = 2; $i <= 9; $i++) {
							$pushes[$i] = $i.' Pushes';
						}
						?>
						<div class="form_field"><?=$form->select('Business.number_pushes', $pushes, null, array('onClick' => 'updateTotal(this.value)'), false)?></div>
						<div style="float: left;font-size: 16px;margin: 6px 0 0 10px;" id="purchase_cost">this purchase costs <strong>$<span id="push_total">25</span></strong>.</div>
						<br clear="both" />
					</div>
					<div class="rounded_box_bottom">
					</div>
					<div style="color: #666666;font-size: 12px;">&nbsp;Note: Individual Push notifications purchased here <strong>DO NOT</strong> expire.</div>
					<?if ($b['Business']['plan'] != 'Trial') {?>
						<br clear="both" />
						<br clear="both" />
						<h4 class="blue">Upgrade Opportunity</h4>
						<script language="javascript" type="text/javascript">
						function updateUpgrade(state) {
							if (state == false) {
								document.getElementById('upgrade_summary').style.display = 'none';
								document.getElementById('purchase_summary').style.display = 'block';
								document.getElementById('plans').disabled = true;
								document.getElementById('card_details').style.display = 'block';
								document.getElementById('no_card_details').style.display = 'none';
							} else {
								document.getElementById('upgrade_summary').style.display = 'block';
								document.getElementById('purchase_summary').style.display = 'none';
								document.getElementById('plans').disabled = false;
								current = document.getElementById('plans').selectedIndex;
								document.getElementById('upgrade_detail').innerHTML = document.getElementById('plans').options[current].text;
								document.getElementById('card_details').style.display = 'none';
								document.getElementById('no_card_details').style.display = 'block';
							}
						}
						function updateUpgradeDetail(o) {
							document.getElementById('upgrade_detail').innerHTML = o;
						}
						</script>					
						<?
						$plans = array();
						
						if ($b['Business']['plan'] == 'Free') {
							$plans['Personal'] = 'Personal Plan - 4 Push Offers a month for $49';
						}
						if ($b['Business']['plan'] == 'Free' || $b['Business']['plan'] == 'Personal') {
							$plans['Basic'] = 'Basic Plan - 7 Push Offers a month for $149';
						}
						if ($b['Business']['plan'] == 'Free' || $b['Business']['plan'] == 'Personal' || $b['Business']['plan'] == 'Basic') {
							$plans['Plus'] = 'Plus Plan - 14 Push Offers a month for $249';
						}
						if ($b['Business']['plan'] == 'Free' || $b['Business']['plan'] == 'Personal' || $b['Business']['plan'] == 'Basic' || $b['Business']['plan'] == 'Plus') {
							$plans['Premium'] = 'Premium Plan - 21 Push Offers a month for $349';
						}
						if ($b['Business']['plan'] == 'Premium') {
							$plans['Personal'] = 'You\'re already on our highest plan!';
						}
						?>
						<?if ($b['Business']['plan'] == 'Premium') {?>
							<?=$form->checkbox('Business.disabled', array('disabled' => 'true', 'value' => '1', 'onChange' => 'updateUpgrade(this.checked)'))?> <strong>Yes.</strong> I would like to Upgrade my Account.
						<?} else {?>
							<?=$form->checkbox('Business.upgrade_check', array('value' => '1', 'onChange' => 'updateUpgrade(this.checked)'))?> <strong>Yes.</strong> I would like to Upgrade my Account.
						<?}?>
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
							<strong style="float: left;padding: 10px 10px 0 0;">Change my plan to:</strong> <div class="form_field"><?=$form->select('Business.plan', $plans, null, array('id' => 'plans', 'onChange' => 'updateUpgradeDetail(this.options[this.value])'), false)?></div>
							<br clear="both" />
						</div>
						<div class="rounded_box_bottom">
						</div>
					<?}?>
					<br clear="both" />
					<br clear="both" />
					
					<div class="step_header">
						<div class="foot">2</div>
						<h3><strong>Enter your billing information - SECURE</strong></h3>
					</div>
					<!--<br clear="both" />
					<br clear="both" />
					<div class="gray">We can charge the individual Push Offers to the Credit Card we have on file<br />via your subscription to the service.  Otherwise, modify the information below.</div>
					-->
					<br clear="both" />
					<br clear="both" />
					<h4 class="blue">Card Details</h4>
					<div id="card_details">
						<?=$form->input('BusinessBilling.card_number', array('label' => 'Card Number<br />', 'size' => '25'));?>
						<div style="float: left;">&nbsp;&nbsp;<?=$html->image('cards.png')?></div>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('BusinessBilling.expiration_date', array( 'label' => 'Expires on<br />', 'dateFormat' => 'MY', 'minYear' => date('Y'), 'maxYear' => date('Y') + 20, 'type' => 'date' ))?>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('BusinessBilling.billing_zip', array('label' => 'Billing Zip<br />'));?>
						<br clear="both" />
						<br clear="both" />
					</div>
					<div id="no_card_details" style="display: none;">
						We will use your card details on file.
						<br clear="both" />
						<br clear="both" />
					</div>
					<div class="form_note">By clicking Create my account you agree to the <a href="#" onclick="javascript:document.getElementById('terms').style.display='block';return false;">Terms of Service</a>, <a href="#" onclick="javascript:document.getElementById('privacy').style.display='block';return false;">Privacy</a>, and <a href="#" onclick="javascript:document.getElementById('refund').style.display='block';return false;">Refund Policiy</a>.</div>
					<br clear="both" />
					<br clear="both" />
					<iframe id="terms" src="<?=$html->url('/businesses/terms')?>" style="display: none;width: 500px; height: 200px; overflow: auto;">
					</iframe>
					<iframe id="refund" src="<?=$html->url('/businesses/terms#refund')?>" style="display: none;width: 500px; height: 200px; overflow: auto;">
					</iframe>
					<iframe id="privacy" src="<?=$html->url('/businesses/privacy')?>" style="display: none;width: 500px; height: 200px; overflow: auto;">
					</iframe>
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
						<div style="font-size: 16px;" id="purchase_summary">
							You've chosen to purchase <strong><span id="push_summary">1 push offer</strong> at <strong>$<?=$price?> each</strong>.
							<br clear="both" />
							You will be billed <strong>$<span id="push_total2">25</span></strong>.
						</div>
						<div style="font-size: 16px;display: none;" id="upgrade_summary">
						You've chosen to upgrade your plan to:
						<br clear="both" />
						<strong><span id="upgrade_detail"></span></strong>
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
				<?=$form->end()?>
				<div id="right">
				</div>
				<br clear="both" />
			</div>
	    </div>
<script language="javascript" type="text/javascript">
	document.getElementById('plans').disabled = true;
</script>

