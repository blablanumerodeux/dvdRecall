<?php
class Recherche{

   	var $json_output;
   	var $feed;

	function Recherche($q){
		$jsonurl=('http://api.allocine.fr/rest/v3/search?partner=YW5kcm9pZC12M3M&count=2000&filter=movie&q='.urlencode($q).'&format=json');
		$json = file_get_contents($jsonurl, 0, null, null);
		$this->json_output = json_decode($json);
		$this->feed = $this->json_output->feed;
	}
	
	function getNbResult(){
		return $this->feed->totalResults;
	}
	
	function getFilms() {
		if ($this->getNbResult()>0){
			$films = array();
			foreach($this->feed->movie as $key => $valCode){ // met tous les films dans un tableau
				$films[$key] = $valCode;
			}
			return $films;
		}else{
			return 0;
		}
	}
}
?>
