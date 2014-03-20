<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" > 
	<head>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
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
		echo $html->css("mobile");

		if (isset($javascript)) {
			echo $javascript->link("prototype");
			echo $javascript->link("scriptaculous");
		}
		?>
					<style type="text/css">
					.lcdstyle{ /*Example CSS to create LCD countdown look*/
					background-color:black;
					color:yellow;
					font: bold 18px MS Sans Serif;
					padding: 3px;
					}
					
					.lcdstyle sup{ /*Example CSS to create LCD countdown look*/
					font-size: 80%
					}
					
					</style>
					
					<script type="text/javascript">
					function pad(n, len) {
					   
					    s = n.toString();
					    if (s.length < len) {
						s = ('0000000000' + s).slice(-len);
					    }
					
					    return s;
					   
					}
					
					
					function cdtime(container, targetdate){
					if (!document.getElementById || !document.getElementById(container)) return
					this.container=document.getElementById(container)
					this.currentTime=new Date()
					this.targetdate=new Date(targetdate)
					this.timesup=false
					this.updateTime()
					}
					
					cdtime.prototype.updateTime=function(){
					var thisobj=this
					this.currentTime.setSeconds(this.currentTime.getSeconds()+1)
					setTimeout(function(){thisobj.updateTime()}, 1000) //update time every second
					}
					
					cdtime.prototype.displaycountdown=function(baseunit, functionref){
					this.baseunit=baseunit
					this.formatresults=functionref
					this.showresults()
					}
					
					cdtime.prototype.showresults=function(){
					var thisobj=this
					
					
					var timediff=(this.targetdate-this.currentTime)/1000 //difference btw target date and current date, in seconds
					if (timediff<0){ //if time is up
					this.timesup=true
					this.container.innerHTML=this.formatresults()
					return
					}
					var oneMinute=60 //minute unit in seconds
					var oneHour=60*60 //hour unit in seconds
					var oneDay=60*60*24 //day unit in seconds
					var dayfield=Math.floor(timediff/oneDay)
					var hourfield=Math.floor((timediff-dayfield*oneDay)/oneHour)
					var minutefield=Math.floor((timediff-dayfield*oneDay-hourfield*oneHour)/oneMinute)
					var secondfield=Math.floor((timediff-dayfield*oneDay-hourfield*oneHour-minutefield*oneMinute))
					if (this.baseunit=="hours"){ //if base unit is hours, set "hourfield" to be topmost level
					hourfield=dayfield*24+hourfield
					dayfield="n/a"
					}
					else if (this.baseunit=="minutes"){ //if base unit is minutes, set "minutefield" to be topmost level
					minutefield=dayfield*24*60+hourfield*60+minutefield
					dayfield=hourfield="n/a"
					}
					else if (this.baseunit=="seconds"){ //if base unit is seconds, set "secondfield" to be topmost level
					var secondfield=timediff
					dayfield=hourfield=minutefield="n/a"
					}
					this.container.innerHTML=this.formatresults(dayfield, hourfield, minutefield, secondfield)
					setTimeout(function(){thisobj.showresults()}, 1000) //update results every second
					}
					
					/////CUSTOM FORMAT OUTPUT FUNCTIONS BELOW//////////////////////////////
					
					//Create your own custom format function to pass into cdtime.displaycountdown()
					//Use arguments[0] to access "Days" left
					//Use arguments[1] to access "Hours" left
					//Use arguments[2] to access "Minutes" left
					//Use arguments[3] to access "Seconds" left
					
					//The values of these arguments may change depending on the "baseunit" parameter of cdtime.displaycountdown()
					//For example, if "baseunit" is set to "hours", arguments[0] becomes meaningless and contains "n/a"
					//For example, if "baseunit" is set to "minutes", arguments[0] and arguments[1] become meaningless etc
					
					
					function formatresults(){
					if (this.timesup==false){//if target date/time not yet met
					var displaystring=arguments[0]+" days "+arguments[1]+" hours "+arguments[2]+" minutes "+arguments[3]+" seconds left until March 23, 2009 18:25:00"
					}
					else{ //else if target date/time met
					var displaystring="Future date is here!"
					}
					return displaystring
					}
					
					function formatresults2(){
					if (this.timesup==false){ //if target date/time not yet met
					var displaystring=""+pad(arguments[1], 2)+":"+pad(arguments[2], 2)+":"+pad(arguments[3], 2)+"<br /><div class=\"remain\">remain</div>"
					}
					else{ //else if target date/time met
					var displaystring="" //Don't display any text
					var displaystring="<div class=\"remain\">expired</div>"
					}
					return displaystring
					}
					
					</script>










					<script>
					var currentRecord = 0;
					var recordCount = <?=$flash_count + $general_count?>;
					var viewSize = 7;
					var wait = 0;
					function moveToPrevious()
					{
					  if(currentRecord > 0 && wait == 0)
					  {
					  	  wait = 1;
					  	  new Effect.Move('listings_inside', { x: 0, y: 70, transition: Effect.Transitions.spring });
					  	  currentRecord--;
					  	  wait = 0;
					  }
					}
					
					function moveToNext()
					{
						if((currentRecord < recordCount-viewSize) && wait == 0)
						{
							wait = 1;
							new Effect.Move('listings_inside', { x: 0, y: -70, transition: Effect.Transitions.spring });
							currentRecord++;
							wait = 0;
						}
					}
					</script>
	</head>
	<body id="home_mobile">
		<?=$content_for_layout?>
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
