<?
$this->pageTitle = ''; 
?>
		<div id='main'>
			<div id='merchant_logos'>
				<?=$this->renderElement('merchant_logos')?>
			</div>
			<div id='maincontent'>
				<div id="left">
					<?
						echo $this->renderElement('widget');
					?>
				</div>
				<div id="right">
					<div id="right_title">How it works.</div>
					<div class="right_subtitle">Get the best deals from your favorite local merchants</div>
					<br clear="both" />
					<br clear="both" />
					<div class="left_pic">
						<?=$html->image("home/big_pin.png", array("width" => "378", "height" => "210", "title" => "big pin"))?>
					</div>
					<div class="right_text">
						<strong>Find the deals you want, when you want them.</strong>  DuckDuck Deal is designed to connect consumers with time sensitive offers from local merchants.  Unlike traditonal coupons, DuckDuck lets merchants easily post limited-time offers each day, giving you easy access to more variety and even better deals.
					</div>
					<br clear="both" />
					<div class="left_text">
						<strong>Local merchants create and send out offers</strong> using DuckDuck's easy to use web interface (e.g. $3 draft beers from 4 to 7 pm).  These offers are immediately broadcast out to the DuckDuck website and free iPhone app.  Each specal offer has a countdown clock showing how much time is left to take advantage of the discount.
					</div>
					<div class="right_pic">
						<?=$html->image("home/pear_street.png", array("width" => "400", "height" => "221", "title" => "pear street"))?>
					</div>
					<br clear="both" />
					<div class="left_pic">
						<?=$html->image("home/west_end.png", array("width" => "354", "height" => "177", "title" => "west end"))?>
					</div>
					<div class="right_text">
						<strong>Find the current offers that you like.</strong>  Browse by category on your mobile device or laptop to find exactly what you're looking for, from drink specials to food discounts.  Adjust the settings in the iPhone app to receive an immediate popup text message when a new offer from a prefered merchant goes live. With DuckDuck you will never miss another opportunity to save at your favorite shopping spots or restaurants!. 
					</div>
					<br clear="both" />
					<div class="left_text">
						<strong>Enjoy and share the great deals you find.</strong> DuckDuck is location sensitive, so it will only display deals happening within a convenient radius. And the iPhone application makes is easy to share deals with your friends on Facebook and Twitter with one click of a button. 
					</div>
					<div class="right_pic">
						<?=$html->image("home/beers.png", array("width" => "395", "height" => "213", "title" => "beers"))?>
					</div>
					<br clear="both" />
					<br clear="both" />
					<div id="bottom_text"><strong>Next steps?</strong> <a href="">Tour the iPhone app</a> or see <a href="">Pricing Plans</a> for merchants.</div>
					<br clear="both" />
					<br clear="both" />
				</div>
			</div>
			</div>
	    </div>
