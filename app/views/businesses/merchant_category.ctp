<?
$this->pageTitle = 'Pricing & Sign Up'; 
?>
		<div id='main_no_hr'>
			<div id='maincontent'>
				<form action="<?=$html->url('/businesses/merchant_category')?>" method="post">
				<div id="left">
					<?//=$this->renderElement('merchant_menu')?>
				</div>
				<div id="right">
					<h3>Thanks for signing up!  Fill out Merchant Details.</h3>
					<?if (count($similar) > 0) {?>
					We found a few listings that might be you.  If you don&apos;t see your establishment skip to merchant category and move on.
					<br clear="both" />
					<h4 class="blue">Is this you?</h4>
					<div class="rounded_box_top">
					</div>
					<div class="rounded_box_middle">
						<table width="100%">
							<tr>
								<td width="30">
									<input type="radio" name="data[Business][select_similar]" value="0" checked>
								</td>
								<td>
									<strong>My company is not on this list.</strong>
								</td>
							</tr>
							<?foreach ($similar as $s) {?>
							<tr>
								<td width="30">
									<br />
								</td>
							</tr>
							<tr>
								<td width="30">
									<input type="radio" name="data[Business][select_similar]" value="<?=$s['Business']['id']?>">
								</td>
								<td>
									<?=$s['Business']['business_name']?>
									<br />
									<div class="form_note">
										<?=$s['Business']['address1']?> <?=$s['Business']['address2']?>, <?=$s['Business']['zip']?> - <?=$s['Business']['phone']?>
									</div>
								</td>
							</tr>
							<?}?>
						</table>
					</div>
					<div class="rounded_box_bottom">
					</div>
					
					<div class="form_note">If your establishment is not listed you will have an opportunity to fill in your information next.</div>
					<?}?>

					<br clear="both" />
					<h4 class="blue">Merchant Category</h4>
					<div class="form_label">Category</div>
					<br clear="both" />
					<div class="form_field">
						<?=$form->select('BusinessCategory.base_category', $base_categories);?>
					</div>
					<div class="form_field" id="subcat_div">
						<?=$this->renderElement('subcats')?>
					</div>
<?
	$options = array('url' => 'update_subcats','update' => 'subcat_div');
	echo $ajax->observeField('BusinessCategoryBaseCategory',$options);
?>

					<br clear="both" />
					<br clear="both" />
					<br clear="both" />
				</div>
				</form>
			</div>
	    </div>

