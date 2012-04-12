<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
header('Content-type: text/html');


$xslt = new XSLTProcessor();
$xslt_string = new SimpleXMLElement(file_get_contents('xslt.xslt'));
$xslt->importStylesheet($xslt_string);

$xml = new DOMDocument;
$xml->load('xml.xml');

//echo $xslt->transformToDoc($xml)->firstChild->wholeText;
echo $xslt->transformToXml($xml);


#tree??????
#xsl highlighting
#recursion
