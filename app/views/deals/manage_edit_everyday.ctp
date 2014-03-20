<?
$this->pageTitle = 'Add Deal'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$form->create('BusinessOffer', array('url' => '/manage/deals/edit_everyday'))?>
					<h3 class="floatleft">Edit Everyday Deal</h3><div class="form_note floatleft add_offer_note">Need help? <a href="#">Send us an email</a>.</div>
					<br clear="both" />
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
					<br clear="both" />
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

