<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<?
	header("Expires: Mon, 14 Jul 1789 12:30:00 GMT");    // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");                          // HTTP/1.0
	?>
		<title><?= html_entity_decode(strip_tags($title_for_layout))?> - DuckDuckDeal.com</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="icon" href="<?php echo $html->url('/favicon.ico'); ?>" type="image/x-icon"/>
		<link rel="shortcut icon" href="<?php echo $html->url('/favicon.ico'); ?>" type="image/x-icon"/> 
		<?
		echo $html->css("main");
		echo $html->css("inside");
		echo $html->css("merchant_menu");
		echo $html->css("datepicker");

		if (isset($javascript)) {
			echo $javascript->link("prototype");
			echo $javascript->link("datepicker.js");
		}
		?>
	</head>
	<body id="home">
	    <div id="container">
			<div id='topheader'>
			  <div id='logo'>
				<a href="<?=$html->url('/')?>"><?=$html->image("logo.png", array("width" => "262", "height" => "32", "title" => "Duck Duck Deal Logo"))?></a>
			  </div>
			  <div id='nav'>
			  <?if ($logged_in) {?>
			  	<ul>
			  	<li><span class="orange"><?=$current_user['business_name']?></span><span class="light_blue"> is signed in.  <strong>Not you?</strong></span> <span class="orange"><?=$html->link('Sign out.', '/businesses/logout', array('style' => 'color: #E47112;'))?></span></li>
				</ul>
				<br clear="both" />
			  	<ul>
			  	<li><span class="orange"><?=$html->link('Access your account', '/manage/deals/index', array('style' => 'color: #E47112;'))?></span></li>
				</ul>
			  <?} else {?>
			  	<ul>
					<li <?=($this->params['controller'] == 'pages' && $page_name == 'home') ? 'class="current"' : ''?>><?=$html->link('HOME', '/')?></li>
					<li>|</li>
					<li <?=($this->params['controller'] == 'pages' && $page_name == 'tour') ? 'class="current"' : ''?>><?=$html->link('iPHONE <strong>TOUR</strong>', '/tour', null, null, false)?></li>
					<li>|</li>
					<li <?=($this->params['controller'] == 'pages' && $page_name == 'price') ? 'class="current"' : ''?>><?=$html->link('PRICING & <strong>SIGN UP</strong>', '/price', null, null, false)?></li>
					<li>|</li>
					<li><a href="<?=$html->url('/businesses/login')?>">SIGN IN</a></li>
				</ul>
			  <?}?>
			  </div>
			</div>
			<div id='header'>
				<?if (isset($header_name)) {?>
					<?=$this->renderElement('headers/'.$header_name);?>
				<?}?>
			</div>
			<?if ($session->check('Message.flash')) {?>
				<div align="center" style="margin: 15px auto;padding: 10px;color: #990100;border: 1px solid #B4CD9B;background: #FAFFA1;text-align: center;width: 80%">
					<?$session->flash();?>
				</div>
			<?}?>
			<?=$content_for_layout?>
		</div>
		<div id='footer'>
			<?=$this->renderElement('footer')?>
		</div>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16200716-1']);
  _gaq.push(['_setDomainName', '.duckduckdeal.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</body>
</html>
