<?php

class Controller_Abonnement extends Controller_Template {

	function Controller_Abonnement(){
		parent::__construct();
		require_once './Modele/Modele_Abonnement.php';
		$this->selfModel = new Abonnement();		
	}
	
	public function insert(){
		require_once './functions.php';
		$session=session_start();
		if (isset($_SESSION) && !empty($_SESSION)){
			if (estRempli($_POST)){
				// déjà abonné à ce film
				if($this->selfModel->exist($_SESSION['id'],$_POST['codeFilm']) > 0){
					Controller_Error::documentNotFound("Vous êtes déjà abonné à ce film !");
					header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=search'");
				}
				// abonnement possible
				else{
					header('Content-Type: text/html; charset=utf-8');
					require './Vues/header.tpl';
			
					$insert = $this->selfModel->insert($_SESSION['id'],$_POST['codeFilm']);
				
					if(!$insert){
						Controller_Error::documentNotFound('Impossible d\'ajouter ce film à votre liste ...');
					}
					else{
						//require './Vues/abonnement/insert.tpl';
					}
				}
				require './Vues/footer.tpl';
			}else {
				Controller_Error::documentNotFound("Pas de film spécifié...");
				header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=accueil'");
			}
		}else {
			Controller_Error::documentNotFound("Vous n'êtes pas connecté(e) ...");
			header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=connexion&action=index'");
		}
	}
	
	public function afficher(){
		$title = "Liste de Films";
		$session=session_start();
		if (isset($_SESSION) && !empty($_SESSION)){
			require './Vues/header.tpl';
			
			$select = $this->selfModel->mesAbonnements($_SESSION['id']);
			require './Modele/Modele_Film.php';
			$row=$select->fetch(PDO::FETCH_ASSOC);
			if(empty($row)){
				require './Vues/abonnement/aucuns-abonnements.tpl';
			}
			else{
				do{
					$film= new Film($row['codeFilm']);
					require './Vues/abonnement/mesAbonnements.tpl';
				}while ($row=$select->fetch(PDO::FETCH_ASSOC));
			}
			require './Vues/footer.tpl';
		}else {
			Controller_Error::documentNotFound("Vous n'êtes pas connecté(e)");
			header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=connexion&action=index'");
		}
	}
	
	public function supprimer(){
		$title = "Film supprimé";
		$session=session_start();
		if (isset($_SESSION) && !empty($_SESSION)){
			if($this->selfModel->exist($_SESSION['id'],$_POST['codeFilm']) > 0){
				$select = $this->selfModel->supprimer($_SESSION['id'],$_POST['codeFilm']);
				require './Vues/header.tpl';
				require './Vues/abonnement/supprimer.tpl';
				require './Vues/footer.tpl';		
				header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=accueil'");		
			}else {
				Controller_Error::documentNotFound("Vous n'êtes pas abonné(e) à ce film !");
				header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=accueil'");
			}
		}else {
			Controller_Error::documentNotFound("Vous n'êtes pas connecté(e)");
			header("Refresh: 3 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=connexion&action=index'");
		}
	}
	
	
	
	public function script(){
		require_once './Modele/Modele_Film.php';
		require_once './Modele/Modele_EnvoiMail.php';
		require_once './Modele/Modele_Utilisateur.php';	
		require './Vues/header.tpl';
		
		//On recupere tous les codeFilm
		$selectAll = $this->selfModel->selectAll();
		$compteur=0;
		$compteur2=0;
		
		$row=$selectAll->fetch(PDO::FETCH_ASSOC);
		do{
			$compteur++;
			
			$film= new Film($row['codeFilm']);
			echo 'Code Film : '.$film->getCode().'<br/>';
			echo 'Titre : '.$film->getNom().'<br/>';
			echo 'Date de sortie DVD : '.$film->getReleaseDVD().'<br/>';
			echo 'Date d\'aujourd\'hui : '.date('d-m-Y').'<br/>';
			
			
			//Si on a une date de sortie DVD
			if ($film->getReleaseDVD()!='NC'){
				//alors on la compare avec la date du serveur
				$dateDvd = explode ('-', $film->getReleaseDVD());
				$plusGrandOuPas = compareDate($dateDvd);
				
				//Si le film est deja sorti OU si le film sort aujourd'hui
				if ($plusGrandOuPas>=0){
				
					echo html("le film sort ou est déjà sorti en dvd : envoi de mail <br/>");
					
					//On selectione tous les id des users abonnes à ce film
					$selectId = $this->selfModel->selectId($row['codeFilm']);
					
					$idDestinataire = $selectId->fetch(PDO::FETCH_ASSOC);
					do {
						$compteur2++;
						//on cree un utilisateur afin de recuperer son email
						$user= new Utilisateur();
						
						//on recupere son email
						$mailDestinataire=$user->mailCorrespondant($idDestinataire);
						
						//on envoi l'email
						$mail = new EnvoiMail(array("mel" => $mailDestinataire['email']));
						$mail->mailSortieDVD($row['codeFilm']);
						
					}while ($idDestinataire=$selectId->fetch(PDO::FETCH_ASSOC));
					echo 'Nombre de users abonnes : '.$compteur2.'<br/>';
					$compteur2=0;
					
				//Si le film va sortir
				}else{
					echo "le film  va sortir : veuillez patienter <br/>";
				}
			}else {
				echo "le film  n'a pas de date de sortie ! <br/>";
			}
			echo "---------------------------------------";
			echo "<br/>";
			echo "<br/>";
			echo "<br/>";
		}while ($row=$selectAll->fetch(PDO::FETCH_ASSOC));
		echo 'Nombre de films scannés : '.$compteur.'<br/>';
		require_once './Vues/footer.tpl';
	}
}
?>
