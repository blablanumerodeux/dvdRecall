<?php
	require_once 'functions.php';
	spl_autoload_register('generic_autoload');
	


	switch($_GET['controle']){
	 	case 'search':
			$controller = Controller_Recherche::getInstance('Recherche');
			$controller->index();
			break;
	 	case 'results':
			$controller = Controller_Recherche::getInstance('Recherche');
			switch($_GET['action']){
			 	case 'calcule':
					$controller->CalculeResultats();
					break;
				default:
					Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
			
			}
			break;
	 	case 'film':
			$controller = Controller_Film::getInstance('Film');
			$controller->index();
			break;
	 	case 'abonnement':
			$controller = Controller_Abonnement::getInstance('Abonnement');
			switch($_GET['action']){
			 	case 'ajouter':
			 		$controller->insert();
					break;
			 	case 'afficher':
			 		$controller->afficher();
					break;
			 	case 'supprimer':
			 		$controller->supprimer();
					break;
			 	case 'script'://Seulement pour le crontab (restriction par ip?)
			 		$controller->script();
					break;
				default:
					Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
			
			}
			break;
	 	case 'connexion':
			$controller = Controller_Utilisateur::getInstance('Utilisateur');
			switch($_GET['action']){
			 	case 'index':
			 		$controller->index();
					break;
			 	case 'valide':
			 		$controller->seConnecter();
					break;

				default:
					Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
			
			}
			break;
		case 'inscription':
			$controller = Controller_Utilisateur::getInstance('Utilisateur');
			switch($_GET['action']){
			 	case 'index':
			 		$controller->index();
					break;
			 	case 'valide':
			 		$controller->inscrire();
					break;
			 	case 'affichageMonCompte':
			 		$controller->affichageMonCompte();
					break;
			 	case 'modificationCompte':
			 		$controller->modificationCompte();
					break;
					
				default:
					Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
			
			}
			break;
			
	 	case 'deconnexion':
			$controller = Controller_Utilisateur::getInstance('Utilisateur');
			$controller->deco();
			break;
			
		default: // Accueil
			//Controller_Error::documentNotFound("Page introuvable : URL incorrecte");
			$controller = Controller_Recherche::getInstance('Accueil');
			$controller->index();
	}
?>
