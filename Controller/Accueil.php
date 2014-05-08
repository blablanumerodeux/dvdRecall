<?php
class Controller_Accueil extends Controller_Template {

	function Controller_Accueil(){
		parent::__construct();
	}
	
	function index(){
		$title = "Accueil";
		require_once './Vues/header.tpl';
		require_once './Vues/recherche/index.tpl';
		require_once './Modele/Modele_Accueil.php';
		require_once './Modele/Modele_Film.php';
		require_once './Modele/Modele_Abonnement.php';
		
		$accueil= new Accueil();
		$dateActualisationSPD= $accueil->getDateUpdate(1);
		$dateActualisationPA= $accueil->getDateUpdate(2);
		$resultSPD = $accueil->getNbResult(1);
		$resultPA = $accueil->getNbResult(2);
		$filmsSPD=$accueil->getFilms(1);
		$filmsPA=$accueil->getFilms(2);
		
		$i = 1; // compteur pour afficher les films 5 par 5
			
		if ($resultSPD!=0){
			
			echo "<br/>";
			header('Content-Type: text/html; charset=utf-8');
			echo ("<h2><u>");
			echo html("Films actuellement au cinéma : ");
			echo ("</u></h2>");
			require './Vues/accueil/debutAffichageRowFluid.tpl';
			
			foreach($filmsSPD as $film1){
				require './Vues/accueil/films_Au_Cinema_Actuellement.tpl';
				if($i == 5){
					require './Vues/accueil/finAffichageRowFluid.tpl';
					require './Vues/accueil/debutAffichageRowFluid.tpl';
				}
				$i++;
			}
			$i = 1;
			require './Vues/accueil/finAffichageRowFluid.tpl';
		}else{
			Controller_Error::documentNotFound("Films au cinéma actuellement indisponibles pour le ".$dateActualisationSPD);
		}
		
		if ($resultPA!=0){
			echo "<br/>";
			header('Content-Type: text/html; charset=utf-8');
			echo ("<h2><u>");
			echo html("Films à paraître prochainement : ");
			echo ("</u></h2>");
			require './Vues/accueil/debutAffichageRowFluid.tpl';

			foreach($filmsPA as $film2){
				require './Vues/accueil/films_Les_Plus_Attendus.tpl';
				if($i == 5){
					require './Vues/accueil/finAffichageRowFluid.tpl';
					require './Vues/accueil/debutAffichageRowFluid.tpl';
				}
				$i++;
			}
			$i = 1;
			require './Vues/accueil/finAffichageRowFluid.tpl';
		}else{
			Controller_Error::documentNotFound("Films les plus attendus actuellement indisponibles pour le ".$dateActualisationPA);
		}
		/* ----------------------------------------------------------------------------------- */
		$topTen = $accueil->recupTopTen();
		$topFilm = $topTen->fetchAll();
		if ($topFilm!=0){
				echo "<br/>";
				header('Content-Type: text/html; charset=utf-8');
				echo ("<h2><u>");
				echo html("Top 10 des Films les + Attendus en DVD : ");
				echo ("</u></h2>");
				require './Vues/accueil/debutAffichageRowFluid.tpl';
				require './Vues/accueil/debutTableauTopTen.tpl';
				foreach($topFilm as $film){
					$filmClassement = new Film($film['codeFilm']);
					$nbAbonnementFilm = $film['nbFilm'];
					require './Vues/accueil/top10.tpl';
				}
				require './Vues/accueil/finTableauTopTen.tpl';
				require './Vues/accueil/finAffichageRowFluid.tpl';
		}else{
			Controller_Error::documentNotFound("Classement indisponible !");
			header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=search'");
		}
		/* ------------------------------------------------------------------------------------ */
		require './Vues/footer.tpl';
	}
	/*
	function topTen(){
		$accueil = new Accueil();
		$topTen = $accueil->recupTopTen();
		$topFilm = $topTen->fetchColumn();
		
		if ($topTen!=0){
				echo '<br/>Les 10 films les + Attendus : <br/>';
				foreach($topFilm as $film){
					$filmClassement = new Film($film);
					echo "<br/>";
					header('Content-Type: text/html; charset=utf-8');
					require './Vues/topTen.tpl';
					echo "<hr />";
				}
				require './Vues/footer.tpl';
		}else{
			Controller_Error::documentNotFound("Classement indisponible !");
			header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=search'");
		}
	}
	*/
}
?>
