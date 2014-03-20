					<?
					echo $ajax->form(array('type' => 'post',
					    'options' => array(
						'model'=>'BusinessOffer',
						'update'=>'listings',
						'url' => array(
						    'controller' => 'deals',
						    'action' => 'mobile'
						),
						'autocomplete' => 'off'
					    )
					));
					?>
					<table class="search_table"><tr><td><?=$form->text('Business.zip', array('value' => 'Please enter a zipcode', 'class' => 'search_box', 'onClick' => 'javascript:this.value = \'\';'))?></td><td><?php echo $form->submit('widget/search_button.png', array("width" => "45", "height" => "35", "class" => "search_button", 'id' => 'search_button')); ?></td></tr></table>
						<br clear="both" />
						<div align="center"><?=$form->select('BusinessCategory.id', $categories, null, array('class' => 'search_categories', 'onChange' => 'document.getElementById(\'search_button\').click();'), false)?></div>
					</form>
					<br clear="both" />
					<div id="widget">
								<?=$this->renderElement('widget_listings')?>
					</div>

