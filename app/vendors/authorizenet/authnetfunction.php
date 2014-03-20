<?

/*
D I S C L A I M E R                                                                                          
WARNING: ANY USE BY YOU OF THE SAMPLE CODE PROVIDED IS AT YOUR OWN RISK.                                                                                   
Authorize.Net provides this code "as is" without warranty of any kind, either express or implied, including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.   
Authorize.Net owns and retains all right, title and interest in and to the Automated Recurring Billing intellectual property.
*/

//function to send xml request via fsockopen
function send_request_via_fsockopen($host,$path,$content)
{
	$posturl = "ssl://" . $host;
	$header = "Host: $host\r\n";
	$header .= "User-Agent: PHP Script\r\n";
	$header .= "Content-Type: text/xml\r\n";
	$header .= "Content-Length: ".strlen($content)."\r\n";
	$header .= "Connection: close\r\n\r\n";
	$fp = fsockopen($posturl, 443, $errno, $errstr, 30);
	if (!$fp)
	{
		$response = false;
	}
	else
	{
		error_reporting(E_ERROR);
		fputs($fp, "POST $path  HTTP/1.1\r\n");
		fputs($fp, $header.$content);
		fwrite($fp, $out);
		$response = "";
		while (!feof($fp))
		{
			$response = $response . fgets($fp, 128);
		}
		fclose($fp);
		error_reporting(E_ALL ^ E_NOTICE);
	}
	return $response;
}

//function to send xml request via curl
function send_request_via_curl($host,$path,$content)
{
	$posturl = "https://" . $host . $path;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $posturl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	return $response;
}


//function to parse Authorize.net response
function parse_return($content)
{
	$refId = substring_between($content,'<refId>','</refId>');
	$resultCode = substring_between($content,'<resultCode>','</resultCode>');
	$code = substring_between($content,'<code>','</code>');
	$text = substring_between($content,'<text>','</text>');
	$subscriptionId = substring_between($content,'<subscriptionId>','</subscriptionId>');
	return array ($refId, $resultCode, $code, $text, $subscriptionId);
}

//helper function for parsing response
function substring_between($haystack,$start,$end) 
{
	if (strpos($haystack,$start) === false || strpos($haystack,$end) === false) 
	{
		return false;
	} 
	else 
	{
		$start_position = strpos($haystack,$start)+strlen($start);
		$end_position = strpos($haystack,$end);
		return substr($haystack,$start_position,$end_position-$start_position);
	}
}

function an_format_xml_create($loginname, $transactionkey, $refId, $name, $length, $unit, $startDate, $totalOccurrences, $trialOccurrences, $amount, $trialAmount, $cardNumber, $expirationDate, $firstName, $lastName) {

	$content =
        "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
        "<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
        "<merchantAuthentication>".
        "<name>" . $loginname . "</name>".
        "<transactionKey>" . $transactionkey . "</transactionKey>".
        "</merchantAuthentication>".
		"<refId>" . $refId . "</refId>".
        "<subscription>".
        "<name>" . $name . "</name>".
        "<paymentSchedule>".
        "<interval>".
        "<length>". $length ."</length>".
        "<unit>". $unit ."</unit>".
        "</interval>".
        "<startDate>" . $startDate . "</startDate>".
        "<totalOccurrences>". $totalOccurrences . "</totalOccurrences>".
        "<trialOccurrences>". $trialOccurrences . "</trialOccurrences>".
        "</paymentSchedule>".
        "<amount>". $amount ."</amount>".
        "<trialAmount>" . $trialAmount . "</trialAmount>".
        "<payment>".
        "<creditCard>".
        "<cardNumber>" . $cardNumber . "</cardNumber>".
        "<expirationDate>" . $expirationDate . "</expirationDate>".
        "</creditCard>".
        "</payment>".
        "<billTo>".
        "<firstName>". $firstName . "</firstName>".
        "<lastName>" . $lastName . "</lastName>".
        "</billTo>".
        "</subscription>".
        "</ARBCreateSubscriptionRequest>";

	return $content;
}

function an_format_xml_update($loginname, $transactionkey, $subscriptionId, $cardNumber, $expirationDate, $amount = null) {

	$content =
        "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
        "<ARBUpdateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
        "<merchantAuthentication>".
        "<name>" . $loginname . "</name>".
        "<transactionKey>" . $transactionkey . "</transactionKey>".
        "</merchantAuthentication>".
        "<subscriptionId>" . $subscriptionId . "</subscriptionId>".
        "<subscription>".
        "<amount>". $amount ."</amount>".
        "<payment>".
        "<creditCard>".
        "<cardNumber>" . $cardNumber ."</cardNumber>".
        "<expirationDate>" . $expirationDate . "</expirationDate>".
        "</creditCard>".
        "</payment>".
        "</subscription>".
        "</ARBUpdateSubscriptionRequest>";

	return $content;
}

function an_format_xml_cancel($loginname, $transactionkey, $subscriptionId) {

	$content =
        "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
        "<ARBCancelSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
        "<merchantAuthentication>".
        "<name>" . $loginname . "</name>".
        "<transactionKey>" . $transactionkey . "</transactionKey>".
        "</merchantAuthentication>" .
        "<subscriptionId>" . $subscriptionId . "</subscriptionId>".
        "</ARBCancelSubscriptionRequest>";

	return $content;
}
?>
