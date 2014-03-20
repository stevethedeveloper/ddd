<?
$this->pageTitle = 'Edit Your Merchant Profile'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$form->create('Business', array('action' => 'manage_edit_profile'))?>
					<?=$form->hidden('id')?>
					<?=$html->image($logo, array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Edit Your Merchant Profile</h3>
					<br clear="both" />
					<hr />
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
					<h4 class="blue">Details</h4>
					<?=$form->input('website', array('label' => 'Website<br />'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('twitter', array('label' => 'Twitter<br />'));?>
					<br clear="both" />
					<div style="color: #666666; width: 325px; margin-left: 100px;">Don't have a Twitter account?  Go to twitter.com to find out more information.</div>

					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
					<h4 class="blue">Change Password</h4>
					<?=$form->input('Business.password', array('label' => 'Password<br />', 'value' => '', 'size' => '33', 'style' => 'clear: both;float: left;'));?>
					<br clear="both" />
					<?=$form->input('Business.password2', array('label' => 'Verify Password<br />', 'type' => 'password', 'value' => '', 'size' => '33', 'style' => 'clear: both;float: left;'));?>

					<br clear="both" />
					<br clear="both" />
					<h4 class="blue">Merchant Description</h4>
					<div class="form_note">Give a brief description of your business for customers.</div>
					<br clear="both" />
					<script language="javascript" type="text/javascript">
					function limitText(limitField, limitCount, limitNum) {
						if (limitField.value.length > limitNum) {
							limitField.value = limitField.value.substring(0, limitNum);
						} else {
							document.getElementById('countdown_span').innerHTML = limitNum - limitField.value.length;
						}
					}
					</script>					
					<span class="orange mediumtext" id="countdown_span"><?=140 - $description_length?></span> <span class="gray mediumtext">characters remain</span>
					<br clear="both" />
					<div class="form_field"><?=$form->input('Business.description', array('cols' => '65', 'rows' => '3', 'label' => '', 'onKeyDown' => 'limitText(this,this.form.countdown_span,140);', 'onKeyUp' => 'limitText(this,this.form.countdown_span,140);'))?></div>
					<br clear="both" />
					<br clear="both" />
					<?=$form->end('buttons/save.png')?>
					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
				</div>
				<br clear="both" />
			</div>
	    </div>

