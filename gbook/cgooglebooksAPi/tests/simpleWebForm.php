<!DOCTYPE html>
<html>
<head>
<title>Simple Book Search</title>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<style>
/* #### Dark Matter #### */
.dark-matter {
    margin-left: auto;
    margin-right: auto;
    max-width: 500px;
    background: #555;
    padding: 20px 30px 20px 30px;
    font: 12px "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: #D3D3D3;
    text-shadow: 1px 1px 1px #444;
    border: none;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}
.dark-matter h1 {
    padding: 0px 0px 10px 40px;
    display: block;
    border-bottom: 1px solid #444;
    margin: -10px -30px 30px -30px;
}
.dark-matter h1>span {
    display: block;
    font-size: 11px;
}
.dark-matter label {
    display: block;
    margin: 0px 0px 5px;
}
.dark-matter label>span {
    float: left;
    width: 20%;
    text-align: right;
    padding-right: 10px;
    margin-top: 10px;
    font-weight: bold;
}
.dark-matter input[type="text"], .dark-matter input[type="email"], .dark-matter textarea, .dark-matter select {
    border: none;
    color: #525252;
    height: 25px;
    line-height:15px;
    margin-bottom: 16px;
    margin-right: 6px;
    margin-top: 2px;
    outline: 0 none;
    padding: 5px 0px 5px 5px;
    width: 70%;
    border-radius: 2px;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    background: #DFDFDF;
}
.dark-matter select {
    background: #DFDFDF url('down-arrow.png') no-repeat right;
    background: #DFDFDF url('down-arrow.png') no-repeat right;
    appearance:none;
    -webkit-appearance:none; 
    -moz-appearance: none;
    text-indent: 0.01px;
    text-overflow: '';
    width: 70%;
    height: 35px;
    color: #525252;
    line-height: 25px;
}
.dark-matter textarea{
    height:100px;
    padding: 5px 0px 0px 5px;
    width: 70%;
}
.dark-matter .button {
    background: #FFCC02;
    border: none;
    padding: 10px 25px 10px 25px;
    color: #585858;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    text-shadow: 1px 1px 1px #FFE477;
    font-weight: bold;
    box-shadow: 1px 1px 1px #3D3D3D;
    -webkit-box-shadow:1px 1px 1px #3D3D3D;
    -moz-box-shadow:1px 1px 1px #3D3D3D;
}

.dark-matter .button:hover {
    color: #333;
    background-color: #EBEBEB;
}
.dark-matter .error{
	color:red;
	font-size:16px;
	text-align:center;
}
table{
	width:50%;
	margin:auto;
}
table img{
	width:75%;
	height:40%;
}
</style>
<?php
	/**
    *  A simple web form example to use the class
	* Currently, I fetch title, authors,publisher, description, categories, isbn, thumbnail_url 
    * If you need more data you are free to add and use it,
	*
	* More parameter details can be found here. //https://developers.google.com/books/docs/v1/reference/volumes
	*
    */	
if( true == isset($_POST['get_books_details'])) {
	
	require '../src/cgoogleBooksApi.class.php';

	$objgoogleBooksApi = new cgoogleBooksApi();
	$objgoogleBooksApi->setSearchData($_POST['books']);
	$objgoogleBooksApi->setUsePHPCurl(true);
	$objgoogleBooksApi->setIsFromAjax(false);
	$strJSONData = $objgoogleBooksApi->fetchGoogleBooks();
	
	$arrstrGoogleData = json_decode( $strJSONData, true );
	$arrstrGoogleBooksData = (array ) json_decode( $arrstrGoogleData['books'], true );
	if( 0 == count( $arrstrGoogleBooksData ) ) {
		 
			$strWarning = 'No Books Found!';	
			
	}
}
?>
</head>
<body style="margin:auto;">
<form method="post" action="" class="dark-matter">
<h1>
	Simple Book Search Form<span>Please fill the texts in the fields(atleast one from the first three).</span><br/>
	<span class="error"><?php echo @$strWarning?></span>

</h1>
<p>Author:<br>
  <input type="text" name="books[authors]"  value="<?php echo @$_POST['books']['authors']?>"/>
  <br> 
   Title<br>
  <input type="text" name="books[title]" value="<?php echo @$_POST['books']['title']?>"/>
  <br>
   Category<br>
  <input type="text" name="books[categories]" value="<?php echo @$_POST['books']['categories']?>"/>
  <br>
     Start Index <br>
  <input type="text" name="books[start_index]" value="<?php echo @$_POST['books']['start_index']?>"/>
  <br>
    Max Results(0-40)<br>
  <input type="text" name="books[max_result]" value="<?php echo @$_POST['books']['max_result']?>"/>
  <br>

  <input type="submit" value="fetch books" class="button" name="get_books_details"/></p>
 
</form>
<?php
if( true == isset($_POST['get_books_details'])) {
	
	if( 0 < count( $arrstrGoogleBooksData ) ) {
		?>
	<br/>
	<br/>
	<table align="center" class="pure-table pure-table-bordered">
		<tr>	
			<td>Thumbnail</td>
			<td>Title</td>
			<td>Author</td>
			<td>Publisher</td>
			<td>Category</td>
			<td>ISBN</td>
		</tr>
	<?php
	foreach( $arrstrGoogleBooksData as $strIndex => $strGoogleData ) {
		?>
	<tr>		
		<td><img src="<?php echo $strGoogleData['thumbnail_url'];?>"/></td>
		<td><?php echo $strGoogleData['title'];?></td>
		<td><?php echo $strGoogleData['authors'];?></td>
		<td><?php echo $strGoogleData['publisher'];?></td>
		<td><?php echo $strGoogleData['categories'];?></td>
		<td><?php echo $strGoogleData['isbn'];?></td>
	</tr>
		<?php
	}
	?>
	</table>
	<?php
	
}	}
?>

</body>
</html>
