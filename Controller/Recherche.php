<?php
class Controller_Recherche extends Controller_Template {

	function Controller_Recherche(){
		parent::__construct();
	}
	
	public function index(){
		$title = "Recherche de Films";
		require_once './Modele/Modele_Accueil.php';
		header('Content-Type: text/html; charset=utf-8');
		require './Vues/header.tpl';
		require './Vues/recherche/debutCarousel.tpl';
		
		$accueil= new Accueil();
		$dateActualisationSPD= $accueil->getDateUpdate(1);
		$resultSPD = $accueil->getNbResult(1);
		$filmsSPD=$accueil->getFilms(1);
		
		$premier = 1;
			
		if ($resultSPD!=0){			
			foreach($filmsSPD as $film){
				if($premier == 1){
					require './Vues/recherche/item-active.tpl';
					$premier = 0;
				}
				else{
					require './Vues/recherche/item.tpl';
				}
				require './Vues/recherche/carousel-index-search.tpl';
			}
		}
		else{
			Controller_Error::documentNotFound("Films au cinéma actuellement indisponibles pour le ".$dateActualisationSPD);
		}
		require './Vues/recherche/finCarousel.tpl';
		require './Vues/recherche/index.tpl';
		require './Vues/footer.tpl';
			
	}
	
	function CalculeResultats(){
		require_once './Modele/Modele_Recherche.php';
		require_once './Modele/Modele_Film.php';
		require_once './Modele/Modele_Abonnement.php';
		
		if (isset($_POST['q']) && !empty($_POST['q'])){
			header('Content-Type: text/html; charset=utf-8');
			
			//$_POST['q']=str_replace ( ' ', '+', $_POST['q']); => Remplacer par urlencode()
			$recherche= new Recherche($_POST['q']);
			$title = $recherche->getNbResult()." résultats pour votre recherche";
			$films=$recherche->getFilms();
			
			if ($films!=0){
				require './Vues/header.tpl';
				echo 'Recherche : '.'<font color="red">'.$recherche->getNbResult().'</font> film(s) on été trouvés pour <font color="red">'.$_POST['q'].'</font> : <br/>';
				foreach($films as $film){
					echo "<br/>";
					header('Content-Type: text/html; charset=utf-8');
					require './Vues/recherche/display.tpl';
					echo "<hr />";
				}
				require './Vues/footer.tpl';
			}else{
				Controller_Error::documentNotFound("Pas de resultats");
				header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=search'");
			}
		}else{
			Controller_Error::documentNotFound("Vous n'avez rien saisi");
		}
	}
}
?>
