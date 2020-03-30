<?php 

class cgoogleBooksApi {
	
	/**
	* @name cgoogleBooksApi.class.php
	* @author Asad Genx <asadgx88@gmail.com>
	* @version 1.01
	* @license MIT https://opensource.org/licenses/MIT
	* 
	* Requires PHP 5+
	* Requires curl extension optional
	* 
	*       
	*/

	private $m_boolUsePHPCurl;
	private $m_boolIsFromAjax;
	
	private $m_arrmixSearchData;
	private $m_arrmixErrorMsg;
	private $m_arrmixGoogleData;
	
	private $m_strFinalGoogleUrl;
		
	/**
	*
	*	Class Constants
	*/
	
	const GOOGLE_API_BASE_URL = 'https://www.googleapis.com/books/v1/volumes?q=';
	const START_INDEX 		  = 0;
	const MAX_RESULT		  = 40;
	
	/**
	*
	*	Setter Functions
	*/
	
	public function setUsePHPCurl( $boolUsePHPCurl ) {
		$this->m_boolUsePHPCurl = ( bool ) $boolUsePHPCurl;
	}
	public function setIsFromAjax( $boolIsFromAjax ) {
		$this->m_boolIsFromAjax = ( bool ) $boolIsFromAjax;
	}
	public function setSearchData( $arrmixSearchData = array() ) {
		$this->m_arrmixSearchData = $arrmixSearchData;
	}
	
	private function initializeDefaults() {
		$this->m_boolUsePHPCurl 	= ( true == isset( $this->m_boolUsePHPCurl ) ) ? $this->m_boolUsePHPCurl : false;
	}
	
	/**
    * Validates the given data, returns false on invalid data
    * 
    * @return boolean
    */
	
	private function validateData( $boolIsPostedData = true ) {
		
		$this->m_arrmixSearchData = array_filter( $this->m_arrmixSearchData );
		$arrmixData = ( true == $boolIsPostedData ) ? $this->m_arrmixSearchData : $this->m_arrmixGoogleData;
		$strErrorMsg = '';
		switch(NULL) {
			
			default:
				 if( false == is_array( $arrmixData ) ) {
					 $strErrorMsg = 'Invalid Data.';
					 break;
				 }
				 if( 0 == count( $arrmixData ) ) {
					 $strErrorMsg = 'Empty Data.';
					 break;
				 }
				return true;
		}
		$this->m_arrmixErrorMsg['type']='error';
		$this->m_arrmixErrorMsg['message'] = $strErrorMsg;
		return false;
	}
		
	/**
    * Validates the initializing the missing values in the search data
	* As Google defaults start index to 0 and ax results to 40.
    * 
    * @return boolean
    */
	
	private function initializeSearchData() {
		
		if( false == isset( $this->m_arrmixSearchData['start_index'] ) ) $this->m_arrmixSearchData['start_index'] = self::START_INDEX;
		
		if( false == isset( $this->m_arrmixSearchData['max_result'] ) ) $this->m_arrmixSearchData['max_result'] = self::MAX_RESULT;		
		else if( self::MAX_RESULT < $this->m_arrmixSearchData['max_result'] ) $this->m_arrmixSearchData['max_result'] = self::MAX_RESULT;
	}
			
	/**
    * prepares the final google base url to be fetched the data
	* Once the data is fetched it will be set in m_strFinalGoogleUrl variable
    * 
    * @return NULL
    */
	
	private function prepareFinalUrl() {
		
		$strBaseGoogleUrl 	= SELF::GOOGLE_API_BASE_URL;
		$strGoogleUrlParams = '';
		$intStartIndex = $this->m_arrmixSearchData['start_index'];		
		unset( $this->m_arrmixSearchData['start_index'] );
		
		$intMaxResult  = $this->m_arrmixSearchData['max_result'];		
		unset( $this->m_arrmixSearchData['max_result'] );
		
		foreach( $this->m_arrmixSearchData  as $strSearchIndex => $strSearchTerm ) {
			$strGoogleUrlParams.= $strSearchIndex . ':' . urlencode( $strSearchTerm ) . '+';
		}
		$strGoogleUrlParams = rtrim( $strGoogleUrlParams, '+' );
		$strGoogleUrlParams.= '&startIndex=' . $intStartIndex.'&maxResults=' . $intMaxResult;
		$this->m_strFinalGoogleUrl = $strBaseGoogleUrl . $strGoogleUrlParams;
	}
				
	/**
    * fetches the google api data via PHP CURL
	* As PHP CURL has lot of advantages I have used it in here, it can also be used to post data and so on
    * Updated the $this->m_arrmixGoogleData with the fetched data
	*
    * @return NULL
    */
	
	private function fetchViaCurl() {
		
		if (!function_exists('curl_init')){
			$this->m_arrmixErrorMsg['type']='error';
			$this->m_arrmixErrorMsg['message'] = 'Curl is not installed.';
			$this->displayAsError();
		}
	 
		$objCurl = curl_init();	 
		curl_setopt($objCurl, CURLOPT_URL, $this->m_strFinalGoogleUrl);	
		curl_setopt($objCurl, CURLOPT_REFERER, "http://www.phpclasses.org/contribute.html");
		curl_setopt($objCurl, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($objCurl, CURLOPT_HEADER, 0);
		curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($objCurl, CURLOPT_SSL_VERIFYHOST, 2);		
		curl_setopt($objCurl,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($objCurl, CURLOPT_TIMEOUT, 10);
		$strObtainedFromGoogle = curl_exec($objCurl);
		curl_close($objCurl);
		
		$this->m_arrmixGoogleData = json_decode( $strObtainedFromGoogle, true );
	}
					
	/**
    * fetches the google api data via file_get_contents()
	* In case if PHP_CURL is not installed, or not working as expected, file_get_contents can come handy
    * Updated the $this->m_arrmixGoogleData with the fetched data
	*
    * @return NULL
    */	
	private function fetchViaFGC() {
		
		$strObtainedFromGoogle = file_get_contents( $this->m_strFinalGoogleUrl );		
		$this->m_arrmixGoogleData = json_decode( $strObtainedFromGoogle, true );
	}
	
	/**
    * parses the obtained json into a usable format
	* Currently, I fetch title, authors,publisher, description, categories, isbn, thumbnail_url 
    * If you need more data you are free to add and use it,
	*
	* More parameter details can be found here. //https://developers.google.com/books/docs/v1/reference/volumes
	*
	* Outputs the JSON string
	*
    * @return JSON string
    */	
	private function parseGoogleData() {
		
		$arrfilteredData = array();
		$strFetchedRow ='';
		foreach( $this->m_arrmixGoogleData as $strIndex => $arrstrValue1 ) {
			if( "totalItems" == $strIndex ) {
				$arrfilteredData['totalCount'] = $arrstrValue1;
			}
			if( "items" == $strIndex ) {
				foreach( $arrstrValue1 as $strIndex2 => $arrstrValue2 ) {
					$strTitle = strtolower(trim(isset($arrstrValue2['volumeInfo']['title'])?$arrstrValue2['volumeInfo']['title']:''));
					$arrstrBooks = array('title' => $strTitle,
														'authors' =>(isset($arrstrValue2['volumeInfo']['authors'])?rtrim(implode( ",", $arrstrValue2['volumeInfo']['authors'] ),","):''),
														'publisher' =>(isset($arrstrValue2['volumeInfo']['publisher'])?$arrstrValue2['volumeInfo']['publisher']:''),
														'description'=>(isset($arrstrValue2['volumeInfo']['description'])?str_replace('"','',$arrstrValue2['volumeInfo']['description']):''),
														'categories'=>(isset($arrstrValue2['volumeInfo']['categories'])?rtrim(implode( ",", $arrstrValue2['volumeInfo']['categories'] ),","):''),
														'isbn'=>(isset($arrstrValue2['volumeInfo']['industryIdentifiers'][0]['identifier'])?$arrstrValue2['volumeInfo']['industryIdentifiers'][0]['identifier']:''),
														'thumbnail_url'=>(isset($arrstrValue2['volumeInfo']['imageLinks']['thumbnail'])?$arrstrValue2['volumeInfo']['imageLinks']['thumbnail']:'')
														);
					
					$strFetchedRow.=json_encode( $arrstrBooks).",";
				}
				
			}	
		}
		$strFetchedRow=rtrim($strFetchedRow,",");
		$arrfilteredData['books']= "[".$strFetchedRow."]";
		$strfilteredData = json_encode( $arrfilteredData );
		if( true == $this->m_boolIsFromAjax ) {
			echo $strfilteredData;
			exit;
		} else {
			return 	$strfilteredData;
		}
		
	}
	
	/**
    * Displays the error as json string
	*
    * @return NULL
    */		
	private function displayAsError() {
		$strErrorMsg = json_encode( $this->m_arrmixErrorMsg );
	
		if( true == $this->m_boolIsFromAjax ) {
			echo $strErrorMsg;
			exit;
		} else {
			return 	$strErrorMsg;
		}
	}
	
	/**
    * This is the binder function which is accessible
	*
    * @return NULL
    */	
	public function fetchGoogleBooks() {
	
		$this->initializeDefaults();
		
		if( false == $this->validateData( ) ) $this->displayAsError();
		
		$this->initializeSearchData();
		
		$this->prepareFinalUrl();
		
		( true == $this->m_boolUsePHPCurl ) ? $this->fetchViaCurl() : $this->fetchViaFGC();
		
		if( false == $this->validateData( $boolIsPostedData = false ) ) $this->displayAsError();
		
		return $this->parseGoogleData();
	}	
}

?>