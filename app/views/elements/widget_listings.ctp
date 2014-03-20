						<div id="listings">
							<div id="listings_inside">
						<?
						function remaining_time($sdate, $edate) {
							$phour = ($edate - $sdate) / 3600;
							$prehour = explode('.',$phour);
						       
							$premin = $phour-$prehour[0];
							$min = explode('.',$premin*60);
						       
							$presec = '0.'.$min[1];
							$sec = $presec*60;
					
							$timeshift = $prehour[0].'h '.$min[0].'m ';
							return $timeshift;
						}
						$count = 0;
						if (count($flash) == 0 && count($general) == 0) {
							echo "No current offers for your area";
						} else {
							$exploding_ids = array();
							foreach ($flash as $f) {
								$exploding_ids[] = $f['Business']['id'];
								?>
								<div class="listing_blue" onClick="javascript:document.location.href='<?=$html->url('/business/'.$f['Business']['id'])?>'">
									<div class="deal_title_exploding"><?=$f['Business']['business_name']?></div>
									<div class="deal_exploding"><?=$f['BusinessOffer']['dd_title']?></div>
									<div class="distance"><?=number_format($f[0]['distance'], 2)?> miles</div>
									<div class="time_left">
										<?
										$now = strtotime(date('Y-m-d H:i:s'));
										$end = date('F d, Y H:i:s', strtotime($f['BusinessOffer']['dd_end']));
										//echo remaining_time($now, $end);
										$container_name = 'container'.$count;
										?>
										<div id="<?=$container_name?>" class="time">
										</div>
										<script type="text/javascript">
										var futuredate=new cdtime("<?=$container_name?>", "<?=$end?>")
										futuredate.displaycountdown("hours", formatresults2)
										</script>
									</div>
								</div>
								<?
								$count++;
							}
							?>
							<?
							foreach ($general as $g) {
								if (!in_array($g['Business']['id'], $exploding_ids)) {
								?>
								<div class="listing" onClick="javascript:document.location.href='<?=$html->url('/business/'.$g['Business']['id'])?>'">
									<div class="deal_title"><?=$g['Business']['business_name']?></div>
									<div class="deal"><?=$g['BusinessOffer']['dd_title']?></div>
									<div class="distance"><?=number_format($g[0]['distance'], 2)?> miles</div>
								</div>
								<?
								}
							}
						}
						?>
							</div>
						</div>
						<div align="center">
						<div id="updown">
							<a href="javascript:void(0);" onclick="moveToPrevious(); return true;"><?=$html->image("widget/up.png", array("width" => "141", "height" => "31", "title" => ""))?></a>
							<a href="javascript:void(0);" onclick="moveToNext(); return true;"><?=$html->image("widget/down.png", array("width" => "124", "height" => "31", "title" => ""))?></a>
						</div>
						</div>

