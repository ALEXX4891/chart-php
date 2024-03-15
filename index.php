<?php
//сохраним файл в формате html

$doc = new DOMDocument();
//methods to load HTML
// $html_string = "<html><body>Test<br></body></html>";
// $doc->loadHTML($html_string);
$doc->loadHTMLFile("statement1.html");

// $documentElement = $dom->documentElement; 

// echo $doc->saveHTML();
echo '<pre>';
$doc->saveHTML();
echo '</pre>';



