<?php
/*************************************************************************
php easy :: seo report script
==========================================================================
Author:      php easy code, www.phpeasycode.com
Web Site:    http://www.phpeasycode.com
Contact:     webmaster@phpeasycode.com
*************************************************************************/

function getGooglePages($host) {
	$request = "http://www.google.com/search?q=" . urlencode("site:" . $host) . "&amp;hl=en";
	$data = getPageData($request);
	preg_match('/<div id=resultStats>(About )?([\d,]+) result/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "n/a";
	$string = "<a href=\"" . $request . "\">" . $value . "</a>";
	return $string;
}

function getGoogleLinks($host) {
	$request = "http://www.google.com/search?q=" . urlencode("link:" . $host) . "&amp;hl=en";
	$data = getPageData($request);
	preg_match('/<div id=resultStats>(About )?([\d,]+) result/si', $data, $l);
	$value = ($l[2]) ? $l[2] : "n/a";
	$string = "<a href=\"" . $request . "\">" . $value . "</a>";
	return $string;
}

function getYahooPages($host) {
	$request = "http://siteexplorer.search.yahoo.com/search?p=" . urlencode($host);
	$data = getPageData($request);
	preg_match('/Pages \(([\d,]+)/si', $data, $p);
	$value = ($p[1]) ? $p[1] : "n/a";
	$string = "<a href=\"" . $request . "\">" . $value . "</a>";
	return $string;
}

function getYahooLinks($host) {
	$request = "http://siteexplorer.search.yahoo.com/search?p=" . urlencode($host);
	$data = getPageData($request);
	preg_match('/Inlinks \(([\d,]+)/si', $data, $l);
	$value = ($l[1]) ? $l[1] : "n/a";
	$string.= "<a href=\"" . $request . "&amp;bwm=i\">" . $value . "</a>";
	return $string;
}

function getBingPages($host) {
	$request = "http://www.bing.com/search?q=" . urlencode("site:" . $host) . "&amp;mkt=en-US";
	$data = getPageData($request);
	preg_match('/1-([\d]+) of ([\d,]+)/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "n/a";
	$string = "<a href=\"" . $request . "\">" . $value . "</a>";
	return $string;
}

function getBingLinks($host) {
	$request = "http://www.bing.com/search?q=" . urlencode("inbody:" . $host) . "&amp;mkt=en-US";
	$data = getPageData($request);
	preg_match('/1-([\d]+) of ([\d,]+)/si', $data, $p);
	$value = ($p[2]) ? $p[2] : "n/a";
	$string = "<a href=\"" . $request . "\">" . $value . "</a>";
	return $string;
}

function getAlexaRank($domain) {
	$request = "http://data.alexa.com/data?cli=10&amp;dat=s&amp;url=" . $domain;
	$data = getPageData($request);
	preg_match('/<POPULARITY URL="(.*?)" TEXT="([\d]+)"\/>/si', $data, $p);
	$value = ($p[2]) ? number_format($p[2]) : "n/a";
	$string = "<a href=\"http://www.alexa.com/siteinfo/" . $domain . "\">" . $value . "</a>";
	return $string;
}

function getAlexaLinks($domain) {
	$request = "http://data.alexa.com/data?cli=10&amp;dat=s&amp;url=" . $domain;
	$data = getPageData($request);
	preg_match('/<LINKSIN NUM="([\d]+)"\/>/si', $data, $l);
	$value = ($l[1]) ? number_format($l[1]) : "n/a";
	$string = "<a href=\"http://www.alexa.com/site/linksin/" . $domain . "\">" . $value . "</a>";
	return $string;
}

function getDMOZListings($domain) {
	$request = "http://data.alexa.com/data?cli=10&amp;url=" . $domain;
	$data = getPageData($request);
	preg_match('/<SITE BASE="(.*?)" TITLE="(.*?)" DESC="(.*?)">/si', $data, $s);
	$value1 = ($s[1]) ? $s[1] : "";
	$value2 = ($s[2]) ? $s[2] : "";
	$value3 = ($s[3]) ? $s[3] : "";
	preg_match('/<CAT ID="(.*?)" TITLE="(.*?)" CID="(.*?)"\/>/si', $data, $c);
	$value4 = ($c[1]) ? $c[1] : "";
	$value5 = ($c[2]) ? $c[2] : "";
	$value6 = ($c[3]) ? $c[3] : "";
	$string = "";
	if($value4) {
		$string = "<a href=\"http://www.dmoz.org/" . str_replace("Top/","", $value4) . "\" title=\"" . $value2 . " - " . $value3 . "\">" . $value5 . "</a>";
	}
	else $string = "n/a";
	return $string;
}

function getSiteAdvisorRating($domain) {
	$request = "http://www.siteadvisor.com/sites/" . $domain . "?ref=safe&amp;locale=en-US";
	$data = getPageData($request);
	preg_match('/(green|yellow|red)-xbg2\.gif/si', $data, $r);
	$value = ($r[1]) ? $r[1] : "grey";
	$string = "<a href=\"" . $request . "\">" . $value . "</a>";
	return $string;
}

function getWOTRating($domain) {
	$request = "http://api.mywot.com/0.4/public_query2?target=" . $domain;
	$data = getPageData($request);
	preg_match_all('/<application name="(\d+)" r="(\d+)" c="(\d+)"\/>/si', $data, $regs);
	$trustworthiness = ($regs[2][0]) ? $regs[2][0] : -1;
	$values = array("trustworthy","mostly","suspicious","untrustworthy","dangerous","unknown");
	if($trustworthiness>=80) $value = $values[0];
	elseif($trustworthiness>=60) $value = $values[1];
	elseif($trustworthiness>=40) $value = $values[2];
	elseif($trustworthiness>=20) $value = $values[3];
	elseif($trustworthiness>=0) $value = $values[4];
	else $value = $values[5];
	$string = "<a href=\"http://www.mywot.com/en/scorecard/" . $domain . "\">" . $value . "</a>";
	return $string;
}

function getDomainAge($domain) {
	$request = "http://reports.internic.net/cgi/whois?whois_nic=" . $domain . "&type=domain";
	$data = getPageData($request);
	preg_match('/Creation Date: ([a-z0-9-]+)/si', $data, $p);
	if(!$p[1]) {
		$value = "Unknown";
	}
	else {
		$time = time() - strtotime($p[1]);
		$years = floor($time / 31556926);
		$days = floor(($time % 31556926) / 86400);
		if($years == "1") {
			$y= "1 year";
		}
		else {
			$y = $years . " years";
		}
		if($days == "1") {
			$d = "1 day";
		}
		else {
			$d = $days . " days";
		}
		$value = "$y, $d";
	}
	$string = "<a href=\"" . $request . "\">" . $value . "</a>";
	return $string;
}

function getPageData($url) {
	if(function_exists('curl_init')) {
		$ch = curl_init($url); // initialize curl with given url
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // add useragent
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
		if((ini_get('open_basedir') == '') && (ini_get('safe_mode') == 'Off')) {
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
		}
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // max. seconds to execute
		curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
		return @curl_exec($ch);
	}
	else {
		return @file_get_contents($url);
	}
}

function getDomainFromHost($host) {
	$hostparts = explode('.', $host); // split host name to parts
	$num = count($hostparts); // get parts number
	if(preg_match('/^(ac|arpa|biz|co|com|edu|gov|info|int|me|mil|mobi|museum|name|net|org|pp|tv)$/i', $hostparts[$num-2])) { // for ccTLDs like .co.uk etc.
		$domain = $hostparts[$num-3] . '.' . $hostparts[$num-2] . '.' . $hostparts[$num-1];
	}
	else {
		$domain = $hostparts[$num-2] . '.' . $hostparts[$num-1];
	}
	return $domain;
}

$sitehost = $_SERVER['HTTP_HOST'];
$sitedomain = getDomainFromHost($sitehost);

?>
<html>
<head>
<title>SEO Report for <?=$sitedomain;?></title>
</head>
<body>
<?php echo $sitehost; ?>
<br /><?php echo $sitedomain; ?>
<ul>
<li>Google indexed pages: <?=getGooglePages($sitehost);?></li>
<li>Google inbound links: <?=getGoogleLinks($sitehost);?></li>
<li>Yahoo indexed pages: <?=getYahooPages($sitehost);?></li>
<li>Yahoo inbound links: <?=getYahooLinks($sitehost);?></li>
<li>Bing indexed pages: <?=getBingPages($sitehost);?></li>
<li>Bing inbound links: <?=getBingLinks($sitehost);?></li>
<li>Alexa Rank: <?=getAlexaRank($sitedomain);?></li>
<li>Alexa inbound links: <?=getAlexaLinks($sitedomain);?></li>
<li>DMOZ listing: <?=getDMOZListings($sitedomain);?></li>
<li>SiteAdvisor rating: <?=getSiteAdvisorRating($sitedomain);?></li>
<li>WOT rating: <?=getWOTRating($sitedomain);?></li>
<li>Domain age: <?=getDomainAge($sitedomain);?></li>
</ul>
</body>
</html>
