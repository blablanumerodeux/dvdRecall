<?php
class Controller_Utilisateur extends Controller_Template {

	// constructeur de la classe Controller_Utilisateur
	function Controller_Utilisateur(){
		parent::__construct();
		require_once './Modele/Modele_Utilisateur.php';
		$this->selfModel = new Utilisateur(); // appel du modèle correspondant à la classe Controller_Utilisateur
	}
	
	// connexion ou inscription
	function index(){
		$title = "Connexion - Inscription";
		$session=session_start();
		// si la personnne est déjà connectée il ne peut accéder à cette page
		if (isset($_SESSION) && !empty($_SESSION)){
			Controller_Error::documentNotFound("Vous êtes deja connecté(e)");
			header("Refresh: 2 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php'");
		}
		// sinon on lui affiche les champs de saisies
		else{
			header('Content-Type: text/html; charset=utf-8');
			require './Vues/header.tpl';
			require './Vues/utilisateur/inscription-connexion.tpl';
			require './Vues/footer.tpl';
		}
	}
	
	// connexion	
	function seConnecter(){
		$title = 'Connexion';
		if (isset($_POST) && !empty($_POST)){
			$clean=array();
			$error=array();
			$occError=0;
			foreach($_POST as $cle => $valeur){
				//Si les variables du formulaire sont definies
				//Et qu'elles ne sont pas vides

				if (isset($valeur) && !empty($valeur)){
					$clean[$cle]=$valeur;
				}else{
					$error[$cle]=$i;
					$occError++;
				}
			}
			require './Vues/header.tpl';
			// s'il y a des champs non remplis
			if ($occError!=0){
				require './Vues/error/debutChampErreur.tpl';
				foreach ($error as $cle => $val){
					echo 'Le champ <strong>'.$cle.'</strong> n\'est pas correctement saisi !<br/>';
				}
				require './Vues/finDiv.tpl';
				require './Vues/utilisateur/inscription-connexion.tpl';
			}
			// tous les champs sont remplis
			else {
				// les formats des champs sont valides
				if (validEmail($clean['login']) && validMDP($clean['password'])){
					$id=$this->selfModel->exist($clean); // requête de recherche de l'adresse mail
					// si l'adresse saisie existe dans la BDD
					if ($id>=1){
							$session=session_start();
							$_SESSION=array('id' => $id, 'mel' => $clean['login'], 'login' =>$clean['login']); // on met l'id et le login en session
							require './Vues/success.tpl';
							echo 'Vous êtes connecté(e) avec l\'adresse : '.$_SESSION['mel'].'<br/>Vous allez être redirigé vers l\'accueil.';
							require './Vues/progress-bar-success.tpl';
							require './Vues/finDiv.tpl';
							header("Refresh: 2 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=accueil'");
					}
					// inexistant sur la BDD
					else{
							require './Vues/error/debutChampErreur.tpl';
							echo 'Vous n\'avez pas été reconnu(e) dans notre Base de Données ...';
							require './Vues/progress-bar-error.tpl';
							require './Vues/finDiv.tpl';
							header("Refresh: 4 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=inscription&action=index'");
					}
				}else{
					require './Vues/error/debutChampErreur.tpl';
					if (!validEmail($clean['login'])){
						echo 'Format d\' <strong>adresse mail</strong> non reconnu !<br/>';
					}
					if (!validMDP($clean['password'])){
						echo 'Le <strong>mot de passe</strong> ne respecte pas le format imposé !<br/>';
					}
					require './Vues/finDiv.tpl';
					require './Vues/utilisateur/inscription-connexion.tpl';
					
				}
			}
			require './Vues/footer.tpl';
		}else{
			Controller_Error::documentNotFound("Champs non remplis ...");
			header("Refresh: 2 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=connexion&action=index'");
		}
	}
	
	// déconnexion
	function deco(){
		$title = "Deconnexion";
		session_start();
		unset($_SESSION);
		session_destroy();
		require './Vues/header.tpl';
		header('Content-Type: text/html; charset=utf-8');
		require './Vues/success.tpl';
		echo 'Deconnexion effecutée !<br/>Vous allez être redirigé vers l\'accueil.';
		require './Vues/progress-bar-success.tpl';
		require './Vues/finDiv.tpl';
		require './Vues/footer.tpl';
		header("Refresh: 2 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=accueil'");
	}
	
	// inscription
	function inscrire(){
		$title = 'inscription';
		// déjà connecté
		if (isset($_SESSION) && !empty($_SESSION)){
			Controller_Error::documentNotFound("Vous êtes deja connecté(e).");
			header("Refresh: 2 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php'");
		}
		else{
			
			// on s'assure que la session ne contient rien
			$_SESSION = null;
		
			// nouveau membre
			require './Vues/header.tpl';
			$mail = $_POST['login'];
			$mdpNewUsr = $_POST['password'];	
	
			$clean2 = array();
			$error = array();
			foreach ($_POST as $key => $value) {
				if(estRempli($value)){
					if($key == 'login' && validEmail($value)){
						$clean2[$key] = $value;
					}
					elseif($key == 'password' && validMDP($value)){
						$clean2[$key] = $value;
					}
					else{
						$error[$key] = $value;
					}
				}
				else{
					$error[$key] = $value;
				}
			}
	
			if(count($error) > 0){
		
				require './Vues/error/debutChampErreur.tpl';
				foreach ($error as $cle => $val){
					echo 'Le champ <strong>'.$cle.'</strong> n\'est pas correctement saisi !<br/>';
				}
				require './Vues/finDiv.tpl';
				require './Vues/utilisateur/inscription-connexion.tpl';
			}
			else{
				if($this->selfModel->inscrire($clean2) == 1){
				
					// on met l'adresse mail dans $_SESSION
					$_SESSION['login'] = $clean2['login'];
					
					require './Vues/success.tpl';
					require './Vues/utilisateur/inscriptionReussite.tpl';
					require './Vues/finDiv.tpl';
					
					header("Refresh: 8 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=accueil'");
				}
				else{
					require './Vues/error/debutChampErreur.tpl';
					require './Vues/utilisateur/inscriptionFail.tpl';
					require './Vues/progress-bar-error.tpl';
					require './Vues/finDiv.tpl';
					
					// on s'assure que la session ne contient rien
					$_SESSION = null;
					header("Refresh: 5 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=connexion&action=index'");
				}
			}
			require './Vues/footer.tpl';
		}
	}
	
	// afficher mon compte
	function affichageMonCompte(){
		$title = 'Mon Compte';
		//Si je suis connecter
		$session=session_start();
		if (isset($_SESSION) && !empty($_SESSION)){
			require './Vues/header.tpl';
			include './Vues/utilisateur/modification.tpl';
			require './Vues/footer.tpl';
		}else {//Sinon
			Controller_Error::documentNotFound("Vous n'êtes pas connecté(e)");
			header("Refresh: 2 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=connexion&action=index'");
		}
	}
	
	// modifier mon compte
	function modificationCompte(){
		$title = 'Mise à jour du Compte';
		//Si je suis connecté
		$session=session_start();
		if (isset($_SESSION) && !empty($_SESSION)){
			if (isset($_POST) && !empty($_POST)){
				$clean=array();
				$error=array();
				$occError=0;	
				foreach($_POST as $cle => $valeur){
					//Si les variables du formulaire sont definies
					//Et qu'elles ne sont pas vides

					if (estRempli($valeur)){
						$clean[$cle]=$valeur;
					}
					else{
						$error[$cle]=$i;
						$occError++;
					}
				}
				$modeModification = 0;
				require './Vues/header.tpl';
				if(estRempli($clean['email'] && !estRempli($clean['newMdp']) && !estRempli($clean['newMdpConf']) && !estRempli($clean['oldMdp']))){
					$modeModification = 1; // modification pour l'e-mail
				}
				else if(estRempli($clean['email']) && estRempli($clean['newMdp']) && estRempli($clean['newMdpConf']) && estRempli($clean['oldMdp'])){
					$modeModification = 2; // modification du mot de passe
				}
				else{
					$erreur = 'Les champs renseignés ne permettent pas d\'effectuer une quelconque modification ...';
					require './Vues/error/debutChampErreur.tpl';
					require './Vues/utilisateur/modification.tpl';
					require './Vues/footer.tpl';
					exit;
				}
				// Modification du mot de passe
				if ($modeModification == 2){
			    	//si tous les mots de passes indiqués sont valides
			    	if (validMDP($clean['newMdp']) && validMDP($clean['newMdpConf']) && validMDP($clean['oldMdp'])){
						//on compare son nouveau mdp et l'ancien mdp
						if($clean['newMdp']==$clean['oldMdp']){
							$erreur = 'Ancien et nouveau mots de passe identiques ...<br/>';
							require './Vues/error/debutChampErreur.tpl';
							require './Vues/utilisateur/modification.tpl';
							require './Vues/footer.tpl';
							exit;
						}
						else{
							// le nouveau mot de passe et sa confirmation sont identiques et ancien mot de passe différent du nouveau
							if ($clean['newMdpConf']==$clean['newMdp']){
								if (!$this->selfModel->modifierMdp($clean)){
									$erreur= "Erreur lors de la modification du mot de passe ...<br/>";
								}else{
									header("Refresh: 8 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php'");
								}
							//sinon, il a fait une erreur de frappe lors de la saisie de la confirmation de son mdp
							}else {
								$erreur= 'Confirmation du mot de passe incorrecte ...';
							}
						}
					//sinon, User n'a pas tout rempli
					}else {
						$erreur= 'Un ou plusieurs des champs concernant le mot de passe non conforme(s) ...<br/>';
					}
				}
				// Modification du mail uniquement
				if ($modeModification == 1){
					// les formats des champs sont valides
					if (validEmail($clean['email'])){
						//on modifie l'email dans tous les cas
						if ($this->selfModel->modifierEmail($clean)==0){
							$erreur= 'Erreur lors de la modification de l\'adresse mail !!!';
						}
						else{
							require './Vues/success.tpl';
								echo 'Modification de l\'adresse mail effectuée ! Votre nouvelle adresse est : '.$clean['email'];
							require './Vues/finDiv.tpl';
							$_SESSION['login'] = $clean['email']; // le nouveau mail est mis en session
							$_SESSION['mel'] = $clean['email'];
							header("Refresh: 4 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php'");
						}
					}
					else {
						$erreur= 'L\'adresse mail : '.$clean['email'].' n\'est pas conforme !<br/>';
					}
				}
				if (estRempli($erreur)){
					require './Vues/error/debutChampErreur.tpl';
					require './Vues/utilisateur/modification.tpl';
				}
				require './Vues/footer.tpl';
			}
			else {//Sinon
				Controller_Error::documentNotFound("Champ(s) non rempli(s)");
				header("Refresh: 2 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=inscription&action=affichageMonCompte'");
			}
		}
		else {//Sinon
			Controller_Error::documentNotFound("Vous n'êtes pas connecté(e)");
			header("Refresh: 2 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=connexion&action=index'");
		}
	}
}
?>
