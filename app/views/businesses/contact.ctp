<?
$this->pageTitle = 'Pricing & Sign Up'; 
?>
		<div id='main_right'>
			<div id='header_text'>
			<h3>Contact Us</h3>
			</div>
			<div id='maincontent_right'>
				<div id="left">
					<?php 
						echo $form->create('Contact', array('url' => '/businesses/contact'));
					?>
						<br clear="both" />
						<br clear="both" />
						* = required
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('first_name', array('label' => 'First Name*', 'size' => '25'));?>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('last_name', array('label' => 'Last Name*', 'size' => '25'));?>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('company_name', array('label' => 'Company', 'size' => '25'));?>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('email_address', array('label' => 'Email*', 'size' => '25'));?>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('phone_number', array('label' => 'Phone', 'size' => '25'));?>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('comments', array('label' => 'Comments*', 'cols' => '50'));?>
						<br clear="both" />
						<br clear="both" />
<img id="captcha" src="<?php echo $html->url('/businesses/captcha_image');?>" alt="" />
 <a href="javascript:void(0);" onclick="javascript:document.images.captcha.src='<?php echo $html->url('/businesses/captcha_image');?>?' + Math.round(Math.random(0)*1000)+1">Reload image</a>
						<br clear="both" />
						<br clear="both" />
						<?=$form->input('enter_captcha', array('label' => 'Enter the code displayed above*', 'size' => '25', 'value' => ''));?>
						<br clear="both" />
						<br clear="both" />
					<?php	
						echo $form->end('Send');
					?>
				</div>
				<div id="right">
				</div>
				<br clear="both" />
			</div>
	    </div>

