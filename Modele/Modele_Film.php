<?php
class Film {

    var $json_output;
	var $numFilm;
	protected $nbAbonnement;

    function Film($codeFilm){
		$this->numFilm = $codeFilm;
		$jsonurl=('http://api.allocine.fr/rest/v3/movie?partner=YW5kcm9pZC12M3M&code='.urlencode($codeFilm).'&profile=small&format=json');
		$json = file_get_contents($jsonurl,0,null,null);
		$this->json_output = json_decode($json);
		
		$sql='SELECT COUNT(codeFilm) AS nbFilm FROM AbonnementFilm where codeFilm = ? LIMIT 1;';
		$this->nbAbonnement = Controller_Template::$db->prepare($sql);
    }
    
    function getNom() {
        return ($this->json_output->movie->title);
    }
    
    function getTypeFilm(){
		$dollar = '$';
        return $this->json_output->movie->movieType->$dollar;
    }
    
    function getNomOriginal() {
        return ($this->json_output->movie->originalTitle);
    }
    
    function getImage() {
    	if($this->json_output->movie->poster->href == ""){
    		return "./Vues/no-pre.png";
    	}
    	else{
        	return ($this->json_output->movie->poster->href);
        }
    }
    
    function getCode() {
        return ($this->json_output->movie->code);
    }
    
    function getLienAllocine() {
        return ($this->json_output->movie->link[0]->href);
    }
    
    function getActeurs() {
        return ($this->json_output->movie->castingShort->actors);
    }
    
    function getJson() {
        return ($this->json_output);
    }

    function getYearProd() {
        return ($this->json_output->movie->productionYear);
    }

    function getNationality(){
		$dollar = '$';
        return $this->json_output->movie->nationality->$dollar;
    }
    
    function getGenres(){
		$genresFilm = array();
		$dollar = '$';
		foreach($this->json_output->movie->genre as $key => $value){
			$genresFilm[$key] = $value->$dollar;
		}
		return $genresFilm;
    }
    
    function getRelease() {
		if(!empty($this->json_output->movie->release->releaseDate)){
			$date = $this->json_output->movie->release->releaseDate;
			$d = explode("-", $date);
			return $dateFr = $d[2].'-'.$d[1].'-'.$d[0];
		}
		else{
			return $dateFr = 'NC';
		}
    }
    
    function getReleaseDVD() {
		if(!empty($this->json_output->movie->release->releaseDate)){
			$date = $this->getRelease();
			$d = explode("-", $date);
			$moisSortieDVD = $d[1]+4;
			if($moisSortieDVD > 12){
				$moisSortieDVD = 12 - $moisSortieDVD;
				$d[2]++;
				$moisSortieDVD = sprintf("%03d", $moisSortieDVD);
				return $d[0].$moisSortieDVD.'-'.$d[2];
			}
			if($moisSortieDVD < 10){
				$moisSortieDVD = sprintf("%02d", $moisSortieDVD);
				return $dateFrSortieDVD = $d[0].'-'.$moisSortieDVD.'-'.$d[2];
			}
			return $dateFrSortieDVD = $d[0].'-'.$moisSortieDVD.'-'.$d[2];
		}
		else{
			return $dateFr = 'NC';
		}
    }
    
	function getSynopsis(){
		return htmlspecialchars($this->json_output->movie->synopsisShort);
	}
    
    function getDirecteur() {
        return ($this->json_output->movie->castingShort->directors);
    }
    
    
    function getRoleActeur(){
		$roleActeur = array();
		foreach($this->json_output->movie->castMember as $key => $value){
			if(isSet($value->role)){
				$key = $value->person->name;
				$roleActeur[$key] = $value->role;
			}
		}
		return $roleActeur;
    }
	
    function getActeursPrincipaux($acteur){
	$i = 0;
	$mainActors = array();
	$mainActors = array_chunk($acteur, 5, $preserve_keys = true); // divise le tableau en plusieurs tableaux de taille 5 et garde les clés
	return $mainActors[0]; // retourne les 5 premiers acteurs -donc la première partittion-
    }

    
    function getLienTrailer(){
		return ($this->json_output->movie->trailer->href);
	}
    
    function getUserRating(){
		return ($this->json_output->movie->statistics->userRating);
	}
	
	function getUserReviewCount(){
		return ($this->json_output->movie->statistics->userReviewCount);
	}
       
    function getUserRatingCount(){
		return ($this->json_output->movie->statistics->userRatingCount);
	}
	
	function getNbAbonnement(){
		$this->nbAbonnement->execute(array($this->numFilm));	
		return $this->nbAbonnement;
	}
}
?>
