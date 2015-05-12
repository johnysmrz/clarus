<?php

namespace clarus\response\wsdl;

use \clarus\response\Response as Response;

abstract class Wsdl extends Response {

	public function __construct() {
		$this->setHeader(sprintf('%s: %s', Response::CONTENT_TYPE, 'text/xml; charset=utf-8'));
	}

	public function getOutput() {
		ob_start();
		echo '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">';
		echo '<soap:Body>';

		echo '</soap:Body>';
		echo '</soap:Envelope>';
		return ob_get_clean();
	}
	
}

/*
 <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
   <soap:Body>
     <getProductDetailsResponse xmlns="http://warehouse.example.com/ws">
       <getProductDetailsResult>
         <productName>Čokoláda sada 3 chutí</productName>
         <productID>827635</productID>
         <popis>Čokoláda hořka, bílá a smetanová</popis>
         <cena>98,50</cena>
         <naSkladu>ano</naSkladu>
       </getProductDetailsResult>
     </getProductDetailsResponse>
   </soap:Body>
 </soap:Envelope>
 */