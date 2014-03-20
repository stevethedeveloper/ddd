<?
$this->pageTitle = 'Pricing & Sign Up'; 
?>
		<div id='main_right'>
			<div id='header_text'>
			<h3>You have selected a <strong><?=ucfirst($plan)?> Plan ($<?=$prices[$plan]?>)!</strong><?=($plan == 'plus') ? ' Enjoy the <strong>two month free trial!</strong>' : ''?></h3>
			</div>
			<div id='maincontent_right'>
				<div id="left">
					<?=$form->create('Business', array('action' => 'signup'))?>
					<?=$form->hidden('Business.plan')?>
					<h3>Only <strong class="blue">2 easy steps</strong> to signing up!</strong></h3>
					<div class="step_header">
						<div class="foot">1</div>
						<h3><strong>Create an account</strong></h3>
						<div class="gray">All fields are required</div>
					</div>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('first_name', array('label' => 'First Name', 'size' => '25'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('last_name', array('label' => 'Last Name', 'size' => '25'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('email', array('label' => 'Email', 'size' => '25'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('business_name', array('label' => 'Company', 'size' => '25'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('address1', array('label' => 'Address 1<br />'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('address2', array('label' => 'Address 2<br />'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('city', array('label' => 'City<br />'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('state', array('label' => 'State<br />', 'type' => 'select', 'options' => $statesList->states_array()));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('zip', array('label' => 'Zip<br />'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('phone', array('label' => 'Phone<br />'));?>
					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
					<div class="step_header">
						<div class="foot">2</div>
						<?if ($plan == 'free' || $plan == 'plus') {?>
							<h3><strong>Enter your account information</strong></h3>
						<?} else {?>
							<h3><strong>Enter your billing information - SECURE</strong></h3>
						<?}?>
						<br clear="both" />
						<br clear="both" />
					</div>
					<?if ($plan != 'free' && $plan != 'plus') {?>
						<h4 class="blue">Card Details</h4>
						<?=$form->input('BusinessBilling.card_number', array('label' => 'Card Number<br />', 'size' => '25', 'style' => 'width: 240px;'));?>
						<div style="float: left;">&nbsp;&nbsp;<?=$html->image('cards.png')?></div>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('BusinessBilling.expiration_date', array( 'label' => 'Expires on<br />', 'dateFormat' => 'MY', 'minYear' => date('Y'), 'maxYear' => date('Y') + 20, 'type' => 'date' ))?>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('BusinessBilling.billing_zip', array('label' => 'Billing Zip<br />'));?>
						<br clear="both" />
						<br clear="both" />
					<?}?>
					<h4 class="blue">Secure Your Account</h4>
					Username
					<div class="form_note">This is what you'll use to sign in to your account</div>
					<?=$form->input('username', array('label' => '', 'size' => '33', 'style' => 'clear: both;float: left;'));?>
					<br clear="both" />
					<?=$form->input('password', array('label' => 'Password<br />', 'value' => '', 'size' => '33', 'style' => 'clear: both;float: left;'));?>
					<br clear="both" />
					<?=$form->input('password2', array('label' => 'Verify Password<br />', 'type' => 'password', 'value' => '', 'size' => '33', 'style' => 'clear: both;float: left;'));?>
					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
					<div class="form_note">By clicking Create my account you agree to the <a href="#" onclick="javascript:document.getElementById('terms').style.display='block';return false;">Terms of Service</a>, <a href="#" onclick="javascript:document.getElementById('privacy').style.display='block';return false;">Privacy</a>, and <a href="#" onclick="javascript:document.getElementById('refund').style.display='block';return false;">Refund Policiy</a>.</div>
					<br clear="both" />
					<br clear="both" />
					<iframe id="terms" src="<?=$html->url('/businesses/terms')?>" style="display: none;width: 500px; height: 200px; overflow: auto;">
					</iframe>
					<iframe id="refund" src="<?=$html->url('/businesses/terms#refund')?>" style="display: none;width: 500px; height: 200px; overflow: auto;">
					</iframe>
					<iframe id="privacy" src="<?=$html->url('/businesses/privacy')?>" style="display: none;width: 500px; height: 200px; overflow: auto;">
					</iframe>
					<?=$form->end('buttons/create_my_account.png')?>
				</div>
				<div id="right">
					<h3 class="light_blue">Already have an account</h3>
					<?=$this->renderElement('login');?>
					<div id="bottom_image">
						<?=$html->image('thanks.png');?>
					</div>
				</div>
				<br clear="both" />
			</div>
	    </div>

