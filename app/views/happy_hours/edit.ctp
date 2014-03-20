<?
$this->pageTitle = 'Edit Your Happy Hours'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$html->image('no_image.png', array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Manage your Happy Hours</h3>
					<br clear="both" />
					<hr />
					<h4 class="blue">Happy Hour</h4>
					<div class="form_note">Add up to 5 Happy Hour listings for your establishment.</div>

					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<strong>Set a Happy Hour</strong>
						<br clear="both" />
						<br clear="both" />
						<div class="form_label">Range in Days</div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_field">
							<?=$form->select('Business.previous', $days_array, null, null, false)?> through <?=$form->select('Business.previous', $days_array, null, null, false)?>
						</div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_label">Range in Time</div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_field"><?=$form->dateTime('Business.deal_time', 'NONE', '12');?> through <?=$form->dateTime('Business.deal_time', 'NONE', '12');?></div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_note">What are the main deals during this Happy Hour</div>
						<span class="orange mediumtext">140</span> <span class="gray mediumtext">characters remain</span>
						<br clear="both" />
						<div class="form_field"><?=$form->textarea('Business.description', array('cols' => '65', 'rows' => '5'))?></div>
						<br clear="both" />
						<br clear="both" />
						<div class="floatleft"><?=$form->submit('buttons/add_happy_hour.png', array('style' => 'margin-top: 10px;'))?></div> <div class="form_note floatleft"><br />&nbsp;&nbsp;<a href="">Cancel &amp; Close</a></div>
						<br clear="both" />
					</div>
					<div class="rounded_box_bottom">
					</div>

					<div class="form_note">Happy Hour Index</div>
					<div class="rounded_box_top"></div>
					<div class="rounded_box_middle">
						<strong>Monday through Friday &middot; 3 - 5:30pm</strong>
						<br />
						<div class="form_note">$3 Coronas and a bunch of other stuff.</div>
						<br />
						<div class="form_note"><a href="#">Edit</a> | <a href="#">Delete</a></div>
					</div>
					<div class="rounded_box_bottom"></div>
					<br clear="both" />
					<div class="rounded_box_top"></div>
					<div class="rounded_box_middle">
						<strong>Monday through Friday &middot; 3 - 5:30pm</strong>
						<br />
						<div class="form_note">$3 Coronas and a bunch of other stuff.</div>
						<br />
						<div class="form_note"><a href="#">Edit</a> | <a href="#">Delete</a></div>
					</div>
					<div class="rounded_box_bottom"></div>
				</div>
			</div>
	    </div>

