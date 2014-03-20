<?
$this->pageTitle = 'Billing Info'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?//=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$form->create('BusinessBilling', array('url' => '/manage/businesses/update_cc'))?>
					<?=$form->hidden('id')?>
					<?=$form->hidden('business_id')?>
					<?=$html->image($logo, array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Your plan has expired.  Please update your credit <br />card information.</h3>
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
					<a href="<?=$html->url('/manage/businesses/downgrade/Free')?>">If you would like to continue on the "Free" plan, click here.</a>
					<br />
					We will save your data, although it will not be viewable.  You can upgrade at any time by editing your billing information.
					<br clear="both" />
					<br clear="both" />
				</div>
				<br clear="both" />
			</div>
	    </div>

