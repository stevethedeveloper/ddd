<?
$this->pageTitle = 'Manage Your Deals'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$html->image($logo, array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Manage Your Deals</h3>
					<br clear="both" />
					<hr />
					<br clear="both" />
					
				<?if ($business['Business']['plan'] != 'Free') {?>
					<?if ($remaining > 0) {?>
						<div class="push_number floatleft"><?=$remaining?></div>
						<div class="push_text floatleft">
						<div class="orange">push offer<?=($remaining == 1) ? '' : 's'?> left.</div>
							<div class="gray">Expiration date <?=date('n/j/Y', strtotime($expiration))?>.</div>
						</div>
						<div class="floatleft">
							<a href="<?=$html->url('/manage/deals/add/')?>"><?=$html->image('buttons/make_a_new.png', array('style' => 'margin-left: 30px;'))?></a>
						</div>
					<?} else {?>
						<div class="push_number floatleft">0 push offers</div>
						<div class="floatleft">
							<a href="<?=$html->url('/manage/deals/purchase_pushes')?>"><?=$html->image('buttons/purchase_more_push_offers.png', array('style' => 'margin-left: 30px;'))?></a>
							<br clear="both" />
							<div style="color: #666666;font-size: 12px; padding-left: 40px;">You could <a href="" class="blue">upgrade your plan</a> from <strong>Plus</strong> to <strong>Premium</strong>.</div>
						</div>
					<?}?>
					<br clear="both" />
					<h4 class="blue">Your Deals</h4>
					<div class="floatleft">
						<?=$html->image('foot_exclamation.png', array('style' => 'float: left'))?> <div style="float: left;padding: 4px 10px 0 5px;">Live</div>
						<?=$html->image('calendar.png', array('style' => 'float: left'))?> <div style="float: left;padding: 4px 10px 0 5px;">Scheduled</div>
						<?=$html->image('no.png', array('style' => 'float: left'))?> <div style="float: left;padding: 4px 10px 0 5px;">Expired</div>
					</div>
					<br clear="both" />
					<br clear="both" />
					
					<?foreach ($live as $data) {?> 
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
										<div style="font-size: 12px;">
											<span class="gray">
											<?=(!empty($data['BusinessOffer']['dd_word'])) ? 'Password: '.$data['BusinessOffer']['dd_word'].'&nbsp;|&nbsp;' : ''?>
												<a href="<?=$html->url('/manage/deals/add/'.$data['BusinessOffer']['id'])?>" class="blue">Use as Template</a>
												&nbsp;|&nbsp;
												<?=$html->link('Cancel Offer', '/manage/deals/cancel/'.$data['BusinessOffer']['id'], array('class' => 'blue'), "Are you sure you want to cancel this offer?  This cannot be undone.")?>
											</span>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="rounded_box_bottom">
						</div>
						<br clear="both" />
					<?}?>

					<?foreach ($scheduled as $data) {?> 
						<div class="rounded_box_top">
						</div>
						<div class="rounded_box_middle">
							<table>
								<tr>
									<td align="center" valign="middle" style="padding: 10px 20px 10px 10px;border-right: 1px solid #E7E7E7;">
										<?=$html->image('calendar.png')?>
									</td>
									<td style="padding-left: 10px;">
									<strong><?=date("g:ia", strtotime($data['BusinessOffer']['dd_start']))?> - <?=date("g:ia", strtotime($data['BusinessOffer']['dd_end']))?>, <?=date("l, F j, Y", strtotime($data['BusinessOffer']['dd_start']))?></strong>
										<br clear="both" />
										<?=$data['BusinessOffer']['dd_description']?>
										<br clear="both" />
										<br clear="both" />
										<div style="font-size: 12px;">
											<span class="gray">
											<?=(!empty($data['BusinessOffer']['dd_word'])) ? 'Password: '.$data['BusinessOffer']['dd_word'].'&nbsp;|&nbsp;' : ''?>
												<a href="<?=$html->url('/manage/deals/edit/'.$data['BusinessOffer']['id'])?>" class="blue">Edit</a>
												&nbsp;|&nbsp;
												<a href="<?=$html->url('/manage/deals/add/'.$data['BusinessOffer']['id'])?>" class="blue">Use as Template</a>
												&nbsp;|&nbsp;
												<?=$html->link('Cancel Offer', '/manage/deals/cancel/'.$data['BusinessOffer']['id'], array('class' => 'blue'), "Are you sure you want to cancel this offer?  This cannot be undone.")?>
											</span>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="rounded_box_bottom">
						</div>
						<br clear="both" />
					<?}?>

					<?foreach ($expired as $data) {?> 
						<div class="rounded_box_top">
						</div>
						<div class="rounded_box_middle">
							<table>
								<tr>
									<td align="center" valign="middle" style="padding: 10px 20px 10px 10px;border-right: 1px solid #E7E7E7;">
										<span class="faded"><?=$html->image('no.png')?></span>
									</td>
									<td style="padding-left: 10px;">
									<span class="faded">
									<strong><?=date("g:ia", strtotime($data['BusinessOffer']['dd_start']))?> - <?=date("g:ia", strtotime($data['BusinessOffer']['dd_end']))?>, <?=date("l, F j, Y", strtotime($data['BusinessOffer']['dd_start']))?></strong>
										<br clear="both" />
										<?=$data['BusinessOffer']['dd_description']?>
										<br clear="both" />
										<br clear="both" />
									</span>
										<div style="font-size: 12px;">
											<span class="gray">
											<?=(!empty($data['BusinessOffer']['dd_word'])) ? 'Password: '.$data['BusinessOffer']['dd_word'].'&nbsp;|&nbsp;' : ''?>
												<a href="<?=$html->url('/manage/deals/add/'.$data['BusinessOffer']['id'])?>" class="blue">Edit and Reuse Offer</a>
											</span>
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
					<h4 class="blue">Everyday Deal</h4>
					<?if (count($general) < 1) {?>
						You have not entered an Everyday Deal.  <?=$html->link('Click here to add one.', '/manage/deals/add_everyday')?>
					<?} else {?>
					<?foreach ($general as $data) {?> 
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
										<div style="font-size: 12px;">
											<span class="gray">
												<a href="<?=$html->url('/manage/deals/edit_everyday/')?>" class="blue">Edit</a>
												&nbsp;|&nbsp;
												<?=$html->link('Delete', '/manage/deals/delete_everyday/', array('class' => 'blue'), "Are you sure you want to delete this offer?  This cannot be undone.")?>
											</span>
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

				</div>
				<br clear="both" />
			</div>
	    </div>

