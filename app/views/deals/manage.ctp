<?
$this->pageTitle = 'Manage Your Deals'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<div id="left">
					<?=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<?=$html->image('no_image.png', array('style' => 'float: left;margin-right: 10px;'))?><h3 class="floatleft">Manage Your Deals.</h3>
					<br clear="both" />
					<hr />
					<br clear="both" />
					
					<?if (1) {?>
						<div class="push_number floatleft">12</div>
						<div class="push_text floatleft">
							<div class="orange">push offers left.</div>
							<div class="gray">Expiration date 12/31/2009.</div>
						</div>
						<div class="floatleft">
							<a href=""><?=$html->image('buttons/make_a_new.png', array('style' => 'margin-left: 30px;'))?></a>
						</div>
					<?} else {?>
						<div class="push_number floatleft">0 push offers</div>
						<div class="floatleft">
							<a href=""><?=$html->image('buttons/purchase_more_push_offers.png', array('style' => 'margin-left: 30px;'))?></a>
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

					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<table>
							<tr>
								<td align="center" valign="middle" style="padding: 10px 20px 10px 10px;border-right: 1px solid #E7E7E7;">
									<?=$html->image('foot_exclamation.png')?>
								</td>
								<td style="padding-left: 10px;">
									<strong>3 - 5:30pm, Monday, December 23, 2009</strong>
									<br clear="both" />
									Get a burrito FREE when you do some other things.  You have to buy a drink.  It's not bad, really, buy a drink and get a free burrito.  You need food.
									<br clear="both" />
									<br clear="both" />
									<div style="font-size: 12px;">
										<span class="gray">
											Password: duckduck
											&nbsp;|&nbsp;
											<a href="" class="blue">Edit</a>
											&nbsp;|&nbsp;
											<a href="" class="blue">Use as Template</a>
											&nbsp;|&nbsp;
											<a href="" class="blue">Cancel Offer</a>
										</span>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="rounded_box_bottom">
					</div>
					<br clear="both" />

					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<table>
							<tr>
								<td align="center" valign="middle" style="padding: 10px 20px 10px 10px;border-right: 1px solid #E7E7E7;">
									<?=$html->image('calendar.png')?>
								</td>
								<td style="padding-left: 10px;">
									<strong>3 - 5:30pm, Monday, December 23, 2009</strong>
									<br clear="both" />
									Get a burrito FREE when you do some other things.  You have to buy a drink.  It's not bad, really, buy a drink and get a free burrito.  You need food.
									<br clear="both" />
									<br clear="both" />
									<div style="font-size: 12px;">
										<span class="gray">
											Password: duckduck
											&nbsp;|&nbsp;
											<a href="" class="blue">Edit</a>
											&nbsp;|&nbsp;
											<a href="" class="blue">Use as Template</a>
											&nbsp;|&nbsp;
											<a href="" class="blue">Cancel Offer</a>
										</span>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="rounded_box_bottom">
					</div>
					<br clear="both" />

					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle faded">
						<table>
							<tr>
								<td align="center" valign="middle" style="padding: 10px 20px 10px 10px;border-right: 1px solid #E7E7E7;">
									<?=$html->image('no.png')?>
								</td>
								<td style="padding-left: 10px;">
									<strong>3 - 5:30pm, Monday, December 23, 2009</strong>
									<br clear="both" />
									Get a burrito FREE when you do some other things.  You have to buy a drink.  It's not bad, really, buy a drink and get a free burrito.  You need food.
									<br clear="both" />
									<br clear="both" />
									<div style="font-size: 12px;">
										<span class="gray">
											Password: duckduck
											&nbsp;|&nbsp;
											<a href="" class="blue">Edit and Reuse Offer</a>
											&nbsp;|&nbsp;
											<a href="" class="blue">Delete</a>
										</span>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="rounded_box_bottom">
					</div>
					<br clear="both" />

					<h4 class="blue">Everyday Deal</h4>
					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<table>
							<tr>
								<td align="center" valign="middle" style="padding: 10px 20px 10px 10px;border-right: 1px solid #E7E7E7;">
								</td>
								<td style="padding-left: 10px;">
									Free medium soda with student ID.
									<br clear="both" />
									<br clear="both" />
									<div style="font-size: 12px;">
										<span class="gray">
											<a href="" class="blue">Edit</a>
											&nbsp;|&nbsp;
											<a href="" class="blue">Delete</a>
										</span>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="rounded_box_bottom">
					</div>
					<br clear="both" />

				</div>
			</div>
	    </div>

