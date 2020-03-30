<?php
	/**
    *  A simple example to use the class
	* Currently, I fetch title, authors,publisher, description, categories, isbn, thumbnail_url 
    * If you need more data you are free to add and use it,
	*
	* More parameter details can be found here. //https://developers.google.com/books/docs/v1/reference/volumes
	*
    */	
require '../src/cgoogleBooksApi.class.php';

$objgoogleBooksApi = new cgoogleBooksApi();
$objgoogleBooksApi->setSearchData(array('title'=>'Inferno','categories'=>'Comics','start_index'=>0,'max_result'=>'2'));
$objgoogleBooksApi->setUsePHPCurl(true);
$arrmixStrBooksData = json_decode( $objgoogleBooksApi->fetchGoogleBooks(), true );

print_r( $arrmixStrBooksData );

?>