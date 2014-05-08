<?php
class Accueil {

	var $json_outputSPD; // Sorties triées Par Date
	var $json_outputPA; // Plus Attendues
	protected $selectTOPTEN; // Top 10 des Abonnements

    function Accueil(){
		$jsonurlSortieParDate=('http://api.allocine.fr/rest/v3/movielist?partner=YW5kcm9pZC12M3M&count=25&filter=nowshowing&page=1&order=datedesc&format=json');
		$jsonurlPlusAttendus=('http://api.allocine.fr/rest/v3/movielist?partner=YW5kcm9pZC12M3M&count=25&filter=comingsoon&page=1&order=toprank&format=json');
		$jsonSortieParDate = file_get_contents($jsonurlSortieParDate,0,null,null);
		$jsonPlusAttendus = file_get_contents($jsonurlPlusAttendus,0,null,null);
		$this->json_outputSPD = json_decode($jsonSortieParDate);
		$this->json_outputPA = json_decode($jsonPlusAttendus);
		
		$sql='SELECT codeFilm, COUNT(codeFilm) AS nbFilm FROM AbonnementFilm GROUP BY codeFilm ORDER BY nbFilm DESC LIMIT 10;';
		$this->selectTOPTEN = Controller_Template::$db->prepare($sql);
    }
	
	function getDateUpdate($mode){
		if($mode = 1){
			$output = $this->json_outputSPD->feed->updated;
		}
		else{
			$output = $this->json_outputPA->feed->updated;
		}
		if(!empty($output)){
			$date = $output;
			$d = explode("-", $date);
			return $dateFr = $d[2].'-'.$d[1].'-'.$d[0];
		}
		else{
			return $dateFr = 'NC';
		}
	}
	
	function getNbResult($mode){
		if($mode = 1){
			return $this->json_outputSPD->feed->totalResults;
		}
		else{
			return $this->json_outputPA->feed->totalResults;
		}
	}
	
    function getFilms($mode) {
		$i = 0;
		if($mode == 1){
			$output = $this->json_outputSPD->feed->movie;
			if ($this->getNbResult(1)>0){
				$films = array();
				foreach($output as $key => $valCode){ // met tous les films dans un tableau
					if($i < 10){ // on récupère les 10 premiers
						$films[$key] = $valCode;
						$i++;
					}
				}
				return $films;
			}else{
				return 0;
			}
		}
		else{
			$output = $this->json_outputPA->feed->movie;
			if ($this->getNbResult(2)>0){
				$films = array();
				foreach($output as $key => $valCode){ // met tous les films dans un tableau
					if($i < 10){ // on récupère les 10 premiers
						$films[$key] = $valCode;
						$i++;
					}
				}
				return $films;
			}else{
				return 0;
			}
		}
	}
	
	function recupTopTen(){
		$this->selectTOPTEN->execute();	
		return $this->selectTOPTEN;
	}
}
?>
