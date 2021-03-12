<?	
	set_time_limit(1200);
	function getstockxml($symbol)
	{
	 $url="http://www.webservicex.net/stockquote.asmx/GetQuote?symbol=" . $symbol;
	  $curlHandle = curl_init(); // init curl
   $apiCallUrl = $url;
   
   curl_setopt($curlHandle, CURLOPT_URL, $apiCallUrl); // set the url to fetch
   curl_setopt($curlHandle, CURLOPT_HEADER, 0);
   curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curlHandle, CURLOPT_TIMEOUT,120);
   $content = curl_exec($curlHandle);
   curl_close($curlHandle);
   return $content;

	}

	function parsestockxml($xmlstr)
	{
		$dom = new domDocument;
$dom->loadXML($xmlstr);
if (!$dom) {
     echo 'Error while parsing the document';
     exit;
	}
		$s = simplexml_import_dom($dom);
	//$xml = new SimpleXMLElement($s);
		echo "<table border=1>";
		echo "<tr><td>No</td><td>Stock Code</td><td>Stock Code</td><td>Last</td><td>Change</td><td>Date</td><td>Time</td></tr>";
		$count = 0;
		echo $xml;
		foreach ($s->StockQuotes->Stock as $stockdata) 
		{
			$count++;
			
			echo "<tr><td>" . $count . "</td><td>". $stockdata->Symbol . "</td><td>" . $stockdata->Name . "</td><td>". $stockdata->Last ."</td><td>". $stockdata->Change . "</td><td>". $stockdata->Date . "</td><td>". $stockdata->Time ."</td></tr>";
		}
		echo "</table>";


	}
	
	$symbol = $_POST["symbol"];
	$symbol = str_replace(" ","%20",$symbol);
	$xmlstr = getstockxml($symbol);
	$xmlstr = ltrim($xmlstr);
	$xmlstr = str_replace("&lt;","<",$xmlstr);
	$xmlstr = str_replace("&gt;",">",$xmlstr);
	parsestockxml($xmlstr);
	
		
		
?>
