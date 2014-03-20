<?
$this->pageTitle = 'Edit Deal'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$form->create('BusinessOffer', array('url' => '/manage/deals/edit'))?>
					<?=$form->hidden('BusinessOffer.id')?>
					<h3 class="floatleft">Start a New Exploding Offer</h3><div class="form_note floatleft add_offer_note">Need help? <a href="#">Send us an email</a>.</div>
					<br clear="both" />
					<h4 class="blue">Deal &amp; Date</h4>
					<div class="floatleft">Basic Deal</div><div class="form_note floatleft">&nbsp;(As it will appear in listings)</div>
					<br clear="both" />
					<script language="javascript" type="text/javascript">
					function limitText(limitField, limitCount, limitNum) {
						if (limitField.value.length > limitNum) {
							limitField.value = limitField.value.substring(0, limitNum);
						} else {
							document.getElementById('countdown_span_basic').innerHTML = limitNum - limitField.value.length;
						}
					}
					</script>					
					<span class="orange mediumtext" id="countdown_span_basic"><?=30 - $title_length?></span> <span class="gray mediumtext">characters remain</span>
					<br clear="both" />
					<div class="form_field"><?=$form->input('dd_title', array('cols' => '65', 'rows' => '1', 'label' => '', 'onKeyDown' => 'limitText(this,this.form.countdown_span,30);', 'onKeyUp' => 'limitText(this,this.form.countdown_span,30);'))?></div>
					<br clear="both" />
					<br clear="both" />
					<div class="floatleft">Deal Details</div><div class="form_note floatleft">&nbsp;(Text to appear with offer)</div>
					<br clear="both" />
					<script language="javascript" type="text/javascript">
					function limitText2(limitField, limitCount, limitNum) {
						if (limitField.value.length > limitNum) {
							limitField.value = limitField.value.substring(0, limitNum);
						} else {
							document.getElementById('countdown_span').innerHTML = limitNum - limitField.value.length;
						}
					}
					</script>					
					<span class="orange mediumtext" id="countdown_span"><?=100 - $description_length?></span> <span class="gray mediumtext">characters remain</span>
					<br clear="both" />
					<div class="form_field"><?=$form->input('dd_description', array('cols' => '65', 'rows' => '1', 'label' => '', 'onKeyDown' => 'limitText2(this,this.form.countdown_span,100);', 'onKeyUp' => 'limitText2(this,this.form.countdown_span,100);'))?></div>
					<br clear="both" />
					<br clear="both" />



					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<?
						e($form->month('dd_start', null, array('id' => 'FieldId-mm'), false)." - ");
						e($form->day('dd_start', null, array('id' => 'FieldId-dd'), false)." - ");
						e($form->year('dd_start', '1900', date('Y') + 50, null, array('id' => 'FieldId', 'class' => 'show-weeks dateformat-d-ds-m-ds-Y statusformat-l-cc-sp-d-sp-F-sp-Y highlight-days-67 split-date opacity-90'), false)); 
						?> 
						<br clear="both" />
						<div class="form_label">Date of Offer</div>
						<br clear="both" />
						<br clear="both" />
						<br clear="both" />
						<div class="form_label">Start Time</div>
						<br clear="both" />
						<br clear="both" />
						<div class="form_field"><?=$form->dateTime('start_time', 'NONE', '12');?></div>
						<div class="errortag"><?php echo $form->error('start_time', 'Please enter a start time.')?></div>
						<br clear="both" />
						<div class="form_label">How many hours will this offer run?</div>
						<br clear="both" />
						<br clear="both" />
						<?
						$hours = array();
						for ($i = 1;$i <= 24; $i++) {
							$hours[$i] = $i;
						}
						$minutes = array('00' => '00', '30' => '30');
						?>
						<div class="form_field"><?=$form->select('duration_hours', $hours, null, null, false);?>:<?=$form->select('duration_minutes', $minutes, null, null, false);?></div>
						<div class="errortag"><?php echo $form->error('duration', 'Please enter a duration under 24 hours.')?></div>
						<br clear="both" />
						<br clear="both" />
						<br clear="both" />
						<div class="floatleft">Code Word?</div><div class="form_note floatleft">&nbsp;(A 'password' to validate the special deal.  If none, please leave this blank.)</div>
						<br clear="both" />
						<br clear="both" />
						<!--<div class="form_field gray"><input type="radio"> No Code Word&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"> Yes, use a Code Word</div>-->
						<div class="form_field">&nbsp;&nbsp;&nbsp;&nbsp;<?=$form->text('dd_word', array('size' => '10', 'maxlength' => '30'))?></div>
						<br clear="both" />
					</div>
					<div class="rounded_box_bottom">
					</div>
					<?if ($is_restaurant === true) {?>
						<br clear="both" />
						<br clear="both" />
						Does this deal involve alcoholic beverages?						
						<br clear="both" />
						<?=$form->radio('alcohol', array('1' => 'yes', '0' => 'no'), array('legend' => false))?>
					<?} else {?>
						<?=$form->hidden('alcohol', array('value' => '0'))?>
					<?}?>

					<br clear="both" />
					<br clear="both" />
					<div class="floatleft"><?=$form->submit('buttons/save.png')?></div> <div class="form_note floatleft"><br />&nbsp;&nbsp;<a href="<?=$html->url('/manage/deals/index')?>">Cancel</a></div>
					<?=$form->end()?>
					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
				</div>
				<br clear="both" />
			</div>
	    </div>

