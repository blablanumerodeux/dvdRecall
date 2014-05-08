<?php
class Controller_Film extends Controller_Template {

	function Controller_Film(){
		parent::__construct();
	}
	
	public function index(){
		require_once './Modele/Modele_Film.php';
		require_once './Modele/Modele_Abonnement.php';
		require_once './functions.php';
		
		if (isset($_GET['code']) && !empty($_GET['code'])){
			$film = new Film($_GET['code']);
			$title = $film->getNom();
			$abonnementFilm = $film->getNbAbonnement();
			$nbAbonnement = $abonnementFilm->fetchColumn();
			$nbAbonnementFilm = $nbAbonnement['nbFilm'];
			require_once './Vues/header.tpl';
			require_once './Vues/film/index.tpl';

			require './Vues/footer.tpl';
		}else{
			Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
		}
	}
}
?>
