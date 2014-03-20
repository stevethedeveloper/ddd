<?
$this->pageTitle = 'Reset Password'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
				</div>
				<div id="right">
					<h3 class="floatleft light_blue">Reset Password</h3>
					<br clear="both" />
					<hr />
					<br clear="both" />
					<form action="<?=$html->url('/businesses/forgot_password')?>" method="post">
					Username
					<br clear="both" />
					<div class="form_field"><?=$form->text('Business.username', array('size' => '18'))?></div>
					<br clear="both" />
					<br clear="both" />
					<?=$form->submit('Submit')?>
					<br clear="both" />
					</form>
				</div>
			</div>
	    </div>

