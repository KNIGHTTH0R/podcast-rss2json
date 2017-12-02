<?php

header('Content-Type: application/json');

$url = "YOUR_URL";

$feed = new DOMDocument();
$feed->load($url);

$json = array();

$ns = 'http://www.itunes.com/dtds/podcast-1.0.dtd';

$json['feed']['url'] = $url;
$json['feed']['title'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
$json['feed']['author'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagNameNS($ns, 'author')->item(0)->nodeValue;
$json['feed']['subtitle'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagNameNS($ns, 'subtitle')->item(0)->nodeValue;
$json['feed']['summary'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagNameNS($ns, 'summary')->item(0)->nodeValue;
$json['feed']['copyright'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('copyright')->item(0)->firstChild->nodeValue;
$json['feed']['description'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
$json['feed']['image'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagNameNS($ns, 'image')->item(0)->getAttribute('href');
$json['feed']['link'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('link')->item(0)->firstChild->nodeValue;

$items = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('item');

$json['item'] = array();

$i = 0;

foreach($items as $item) {
   $title = $item->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
   $description = $item->getElementsByTagNameNS($ns, 'summary')->item(0)->nodeValue;
   $duration = $item->getElementsByTagNameNS($ns, 'duration')->item(0)->nodeValue;
   $pubDate = $item->getElementsByTagName('pubDate')->item(0)->firstChild->nodeValue;
   $media = $item->getElementsByTagName('enclosure')->item(0)->getAttribute('url');
   $type = $item->getElementsByTagName('enclosure')->item(0)->getAttribute('type');
   
   $json['item'][$i]['title'] = $title;
   $json['item'][$i]['description'] = $description;
   $json['item'][$i]['duration'] = strtotime($duration) - strtotime('TODAY');
   $json['item'][$i]['pubdate'] = $pubDate;
   $json['item'][$i]['type'] = $type;
   $json['item'][$i]['media'] = $media;
   
   $i++;   
}

echo json_encode($json);

?>
