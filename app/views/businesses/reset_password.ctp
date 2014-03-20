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
					<?=$form->create('Business', array('action' => 'reset_password'))?>
					<?=$form->hidden('Business.token')?>
					<br clear="both" />
					<?=$form->input('password', array('label' => 'Password<br />', 'value' => '', 'size' => '33', 'style' => 'clear: both;float: left;'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->input('password2', array('label' => 'Verify Password<br />', 'type' => 'password', 'value' => '', 'size' => '33', 'style' => 'clear: both;float: left;'));?>
					<br clear="both" />
					<br clear="both" />
					<?=$form->submit('Submit')?>
					<br clear="both" />
					</form>
				</div>
			</div>
	    </div>

