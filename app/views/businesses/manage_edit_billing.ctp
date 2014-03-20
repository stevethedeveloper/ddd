<?
$this->pageTitle = 'Billing Info'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$form->create('BusinessBilling', array('url' => '/manage/businesses/edit_billing'))?>
					<?=$form->hidden('id')?>
					<?=$form->hidden('business_id')?>
					<?=$html->image($logo, array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Password & Billing Info</h3>
					<br clear="both" />
					<hr />
					<?=$form->input('card_number', array('label' => 'Card Number<br />'));?>
					<br clear="both" />
					<?= $form->input('expiration_date', array( 'label' => 'Expires on<br />', 'dateFormat' => 'MY', 'minYear' => date('Y'), 'maxYear' => date('Y') + 20, 'type' => 'date' ))?>
					<br clear="both" />
					<?=$form->input('billing_zip', array('label' => 'Credit Card Zip<br />'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->end('buttons/save.png')?>
					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
					<?
					if ($b['Business']['plan'] != 'Trial') {
					$plans = array();
					$downgrade = array();
					
					switch ($b['Business']['plan']) {
						case 'Free':
							$current = '<strong>Free Plan - $0</strong><br /> 0 Push Offers a month';
							$plans['Premium'] = '<strong>Premium Plan - $349</strong><br /> 21 Push Offers a month';
							$plans['Plus'] = '<strong>Plus Plan - $249</strong><br /> 14 Push Offers a month';
							$plans['Basic'] = '<strong>Basic Plan - $149</strong><br /> 7 Push Offers a month';
							$plans['Personal'] = '<strong>Personal Plan - $49</strong><br /> 4 Push Offers a month';
							break;
						case 'Personal':
							$current = '<strong>Personal Plan - $49</strong><br /> 4 Push Offers a month';
							$plans['Premium'] = '<strong>Premium Plan - $349</strong><br /> 21 Push Offers a month';
							$plans['Plus'] = '<strong>Plus Plan - $249</strong><br /> 14 Push Offers a month';
							$plans['Basic'] = '<strong>Basic Plan - $149</strong><br /> 7 Push Offers a month';
							$downgrade['Free'] = '<strong>Free Plan - $0</strong><br /> 0 Push Offers a month';
							break;
						case 'Basic':
							$current = '<strong>Basic Plan - $149</strong><br /> 7 Push Offers a month';
							$plans['Premium'] = '<strong>Premium Plan - $349</strong><br /> 21 Push Offers a month';
							$plans['Plus'] = '<strong>Plus Plan - $249</strong><br /> 14 Push Offers a month';
							$downgrade['Personal'] = '<strong>Personal Plan - $49</strong><br /> 4 Push Offers a month';
							$downgrade['Free'] = '<strong>Free Plan - $0</strong><br /> 0 Push Offers a month';
							break;
						case 'Plus':
							$current = '<strong>Plus Plan - $249</strong><br /> 14 Push Offers a month';
							$plans['Premium'] = '<strong>Premium Plan - $349</strong><br /> 21 Push Offers a month';
							$downgrade['Basic'] = '<strong>Basic Plan - $149</strong><br /> 7 Push Offers a month';
							$downgrade['Personal'] = '<strong>Personal Plan - $49</strong><br /> 4 Push Offers a month';
							$downgrade['Free'] = '<strong>Free Plan - $0</strong><br /> 0 Push Offers a month';
							break;
						case 'Premium':
							$current = '<strong>Premium Plan - $349</strong><br /> 21 Push Offers a month';
							$downgrade['Plus'] = '<strong>Plus Plan - $249</strong><br /> 14 Push Offers a month';
							$downgrade['Basic'] = '<strong>Basic Plan - $149</strong><br /> 7 Push Offers a month';
							$downgrade['Personal'] = '<strong>Personal Plan - $49</strong><br /> 4 Push Offers a month';
							$downgrade['Free'] = '<strong>Free Plan - $0</strong><br /> 0 Push Offers a month';
							break;
					}
					?>
					<h4 class="blue">Change Your Plan</h4>
					<?if ($b['Business']['plan'] == 'Premium') {?>
						You're already on our highest plan!
						<?if ($show_downgrade === true) {?>
						<table width="100%" style="border-collapse: collapse;">
							<?foreach ($downgrade as $plan => $text) {?>
								<tr>
									<td style="border-top: 1px solid #ebebeb;padding-top: 20px;">
										<?=$text?>
									</td>
									<td align="right" style="border-top: 1px solid #ebebeb;padding-top: 20px;">
										<?=$html->link($html->image("buttons/downgrade_button.png"), '/manage/businesses/downgrade/'.$plan, array(), 'Are you sure you want to downgrade to the '.$plan.' Plan?', false )?>
									</td>
								</tr>
								<tr>
									<td>
										<br clear="both" />
									</td>
								</tr>
							<?}?>
							<tr>
								<td style="border-top: 1px solid #ebebeb;padding-top: 20px;">
									<?=$current?>
								</td>
								<td align="right" style="border-top: 1px solid #ebebeb;padding-top: 20px;">
									<strong>Your current plan.</strong>
								</td>
							</tr>
							<tr>
								<td>
									<br clear="both" />
								</td>
							</tr>
						<?}?>
						</table>
					<?} else {?>
						<table width="100%" style="border-collapse: collapse;">
						<?foreach ($plans as $plan => $text) {?>
							<tr>
								<td style="border-top: 1px solid #ebebeb;padding-top: 20px;">
									<?=$text?>
								</td>
								<td align="right" style="border-top: 1px solid #ebebeb;padding-top: 20px;">
								<?if ($card_present === true) {?>
									<?=$html->link($html->image("buttons/upgrade.png"), '/manage/businesses/upgrade/'.$plan, array(), 'Are you sure you want to upgrade to the '.$plan.' Plan?', false )?>
								<?} else {?>
									<?=$html->link($html->image("buttons/upgrade.png"), '/manage/businesses/edit_billing', array('onClick' => 'alert(\'You must submit a credit card before upgrading your plan.\')'), null, false )?>
								<?}?>
								</td>
							</tr>
							<tr>
								<td>
									<br clear="both" />
								</td>
							</tr>
						<?}?>
						<?if ($show_downgrade === true) {?>
							<tr>
								<td style="border-top: 1px solid #ebebeb;padding-top: 20px;">
									<?=$current?>
								</td>
								<td align="right" style="border-top: 1px solid #ebebeb;padding-top: 20px;">
									<strong>Your current plan.</strong>
								</td>
							</tr>
							<tr>
								<td>
									<br clear="both" />
								</td>
							</tr>
							<?foreach ($downgrade as $plan => $text) {?>
								<tr>
									<td style="border-top: 1px solid #ebebeb;padding-top: 20px;">
										<?=$text?>
									</td>
									<td align="right" style="border-top: 1px solid #ebebeb;padding-top: 20px;">
										<?=$html->link($html->image("buttons/downgrade_button.png"), '/manage/businesses/downgrade/'.$plan, array(), 'Are you sure you want to downgrade to the '.$plan.' Plan?', false )?>
									</td>
								</tr>
								<tr>
									<td>
										<br clear="both" />
									</td>
								</tr>
							<?}?>
						<?}?>
						</table>
					<?}?>
					<?if ($show_downgrade === false) {?>
						<a href="<?=$html->url('/manage/businesses/edit_billing/?downgrade=true')?>"><?=$html->image('buttons/downgrade.png')?><a>
					<?}?>
					<br clear="both" />
					<br clear="both" />
					<?}?>
				</div>
				<br clear="both" />
			</div>
	    </div>

