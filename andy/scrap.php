<?php
/*
This is the class for google crawler
it only takes the keywords and pageNumbers as parameters of the constructor and
crawls in the google search results for links,titles and descriptions
you can use this crawler in your site as search engine(not real,but will search through google)
*/
$keywordsGot = "Cricket";//write the keywords here for search
include_once 'simple_html_dom.php';
$url = "http://www.google.com/search?q=" . $keywordsGot;
$html = file_get_html($url);
// Find all images
// Find all links
foreach ($html->find('.g') as $element)
    echo $element->plaintext . '<br>###############################################';