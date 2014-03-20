<?
$this->pageTitle = 'Edit Your Happy Hours'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$html->image($logo, array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Manage your Happy Hours</h3>
					<br clear="both" />
					<hr />
					<h4 class="blue">Happy Hour</h4>
					<div class="form_note">Add up to 5 Happy Hour listings for your establishment.</div>

					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<?=$form->create('BusinessHappyHour', array('url' => '/manage/happy_hours/edit'))?>
						<?=$form->hidden('business_id')?>
						<strong>Set a Happy Hour</strong>
						<br clear="both" />
						<br clear="both" />
						<div class="form_label">Range in Days</div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_field">
							<?=$form->select('start_day', $days_array, null, null, false)?> through <?=$form->select('end_day', $days_array, null, null, false)?>
						</div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_label">Range in Time</div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_field"><?=$form->dateTime('start_time', 'NONE', '12', array('meridian' => 'pm'));?> through <?=$form->dateTime('end_time', 'NONE', '12', array('meridian' => 'pm'));?></div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_note">What are the main deals during this Happy Hour</div>
						<script language="javascript" type="text/javascript">
						function limitText(limitField, limitCount, limitNum) {
							if (limitField.value.length > limitNum) {
								limitField.value = limitField.value.substring(0, limitNum);
							} else {
								document.getElementById('countdown_span').innerHTML = limitNum - limitField.value.length;
							}
						}
						</script>					
						<span class="orange mediumtext" id="countdown_span">140</span> <span class="gray mediumtext">characters remain</span>
						<br clear="both" />
						<div class="form_field"><?=$form->input('description', array('cols' => '65', 'rows' => '3', 'label' => '', 'onKeyDown' => 'limitText(this,this.form.countdown_span,140);', 'onKeyUp' => 'limitText(this,this.form.countdown_span,140);'))?></div>
						<br clear="both" />
						<br clear="both" />
						<div class="floatleft"><?=$form->submit('buttons/add_happy_hour.png', array('style' => 'margin-top: 10px;'))?></div> <div class="form_note floatleft"><br /></div>
						<br clear="both" />
						<?=$form->end()?>
					</div>
					<div class="rounded_box_bottom">
					</div>

					<div class="form_note">Happy Hour Index</div>
					<?foreach ($happy_hours as $h) {?>
					<div class="rounded_box_top"></div>
					<div class="rounded_box_middle">
						<strong><?=$days_array[$h['BusinessHappyHour']['start_day']]?> through <?=$days_array[$h['BusinessHappyHour']['end_day']]?> &middot; <?=date('g:ia', strtotime($h['BusinessHappyHour']['start_time']))?> - <?=date('g:ia', strtotime($h['BusinessHappyHour']['end_time']))?></strong>
						<br />
						<div class="form_note"><?=$h['BusinessHappyHour']['description']?></div>
						<br />
						<div class="form_note"><!--<?=$html->link('Edit', '/manage/happy_hours/edit_happy_hour/'.$h['BusinessHappyHour']['id'])?> | --><?=$html->link('Delete', '/manage/happy_hours/delete_happy_hour/'.$h['BusinessHappyHour']['id'], null, 'Are you sure?')?></div>
					</div>
					<div class="rounded_box_bottom"></div>
					<br clear="both" />
					<?}?>
				</div>
				<br clear="both" />
			</div>
	    </div>

