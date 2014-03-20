<?
$this->pageTitle = 'Business Listing'; 
?>
		<br clear="both" />
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$html->image($logo, array('style' => 'float: left;margin-right: 10px;'))?>
					<?=$business['Business']['business_name']?>
					<br />
					<?=$business['Business']['address1']?>
					<br />
					<?=$business['Business']['city']?>, <?=$business['Business']['state']?> <?=$business['Business']['zip']?>
					<br />
					<?=$business['Business']['phone']?>
					<?if (!empty($business['Business']['website'])) {?>
					<br />
					<?=$html->link('Visit Website', $business['Business']['website'])?>
					<?}?>
				</div>
				<div id="right">
					<h4 class="blue">Exploding Offer!</h4>
					<?if (count($business_live) < 1) {?>
						No current offer.
					<?} else {?>
					<?foreach ($business_live as $data) {?> 
						<div class="rounded_box_top">
						</div>
						<div class="rounded_box_middle">
							<table>
								<tr>
									<td align="center" valign="middle" style="padding: 10px 20px 10px 10px;border-right: 1px solid #E7E7E7;">
										<?=$html->image('foot_exclamation.png')?>
									</td>
									<td style="padding-left: 10px;">
									<strong><?=date("g:ia", strtotime($data['BusinessOffer']['dd_start']))?> - <?=date("g:ia", strtotime($data['BusinessOffer']['dd_end']))?>, <?=date("l, F j, Y", strtotime($data['BusinessOffer']['dd_start']))?></strong>
										<br clear="both" />
										<?=$data['BusinessOffer']['dd_description']?>
										<br clear="both" />
										<br clear="both" />
										<div style="font-size: 16px;font-weight: bold;">
											<?=(!empty($data['BusinessOffer']['dd_word'])) ? 'The password for this offer is \''.$data['BusinessOffer']['dd_word'].'\'' : ''?>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="rounded_box_bottom">
						</div>
						<br clear="both" />
					<?}?>
					<?}?>

					<h4 class="blue">Offer</h4>
					<?if (count($business_general) < 1) {?>
						No current offer.
					<?} else {?>
					<?foreach ($business_general as $data) {?> 
						<div class="rounded_box_top">
						</div>
						<div class="rounded_box_middle">
							<table>
								<tr>
									<td align="center" valign="middle" style="padding: 10px 20px 10px 10px;border-right: 1px solid #E7E7E7;">
									</td>
									<td style="padding-left: 10px;">
										<?=$data['BusinessOffer']['dd_description']?>
										<br clear="both" />
										<br clear="both" />
									</td>
								</tr>
							</table>
						</div>
						<div class="rounded_box_bottom">
						</div>
						<br clear="both" />
					<?}?>
					<?}?>

					<h4 class="blue">Happy Hours</h4>
					<?if (count($happy_hours) < 1) {?>
						No current happy hours.
					<?} else {?>
					<?foreach ($happy_hours as $h) {?>
					<div class="rounded_box_top"></div>
					<div class="rounded_box_middle">
						<strong><?=$days_array[$h['BusinessHappyHour']['start_day']]?> through <?=$days_array[$h['BusinessHappyHour']['end_day']]?> &middot; <?=date('g:ia', strtotime($h['BusinessHappyHour']['start_time']))?> - <?=date('g:ia', strtotime($h['BusinessHappyHour']['end_time']))?></strong>
						<br />
						<div class="form_note"><?=$h['BusinessHappyHour']['description']?></div>
					</div>
					<div class="rounded_box_bottom"></div>
					<br clear="both" />
					<?}?>
					<?}?>
				</div>
				<br clear="both" />
			</div>
	    </div>

