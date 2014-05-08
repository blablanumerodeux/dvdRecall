<?php
class EnvoiMail{

	public $destinataire;
	public $mdp;

	public function __construct($tab){
	
		if(array_key_exists('mel', $tab)) {
			$this->destinataire = $tab['mel'];
		}
		else if(array_key_exists('email', $tab)) {		
			$this->destinataire = $tab['email'];
		}
		else if(array_key_exists('login', $tab)) {		
			$this->destinataire = $tab['login'];
		}
		
		if(array_key_exists('password', $tab)) {
			$this->mdp = $tab['password'];
		}
	}
	
	public function mailInscription(){
		$headers ='From: "Equipe de DVD Recall"<no-reply@dvdrecall.fr>'."\n";
		$headers .='Content-Type: text/html; charset="UTF-8"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';

		$message =
		'<html>
			<head>
				<title>
					Inscription à DVD Recall
				</title>
			</head>
			<body>
				Toute l\'équipe de DVD Recall vous souhaite la bienvenue !<br/>
				Grâce à cette inscription vous pouvez désormais être averti(e) de la sortie en DVD de vos <br/>
				films préférés !!<br/>
				Pour vous connectez vous avez uniquement besoin de : <br/>
				&nbsp; - votre adresse mail : '.$this->destinataire.'<br/>
				&nbsp; - votre mot de passe : '.$this->mdp.'<br/>
				<br/>
				En espérant vous revoir bientôt parmi nous,
				
				L\'équipe de DVD Recall.
			</body>
		</html>';
		
		if(mail($this->destinataire, 'Inscription à DVD Recall', $message, $headers)){
			require './Vues/success.tpl';
			echo 'Pour terminer votre inscription veuillez consulter votre boîte mail !<br/>';
			echo '<br/>';
			require './Vues/boutonVersGoogle.tpl';
			require './Vues/finDiv.tpl';
		}
		else{
			require './Vues/error/debutChampErreur.tpl';
			echo 'Erreur lors de l\'envoi du mail de confirmation !';
			require './Vues/finDiv.tpl';
		}
	}
	
	public function mailSortieDVD($idFilm){
		
		$film = new Film($idFilm);
		$nomFilm = $film->getNom();
		
		$headers ='From: "Equipe de DVD Recall"<no-reply@dvdrecall.fr>'."\n";
		$headers .='Content-Type: text/html; charset="UTF-8"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';

		$message =
		'<html>
			<head>
				<title>'.
					$nomFilm.' est maintenant disponible en DVD !'.
				'</title>
			</head>
			<body>
				Bonjour<br/>
				Suite à l\'ajout à votre liste de : '.$nomFilm.' ; nous vous informons que celui-ci est sorti en DVD !<br/>
				Vous pouvez donc vous dirigez vers votre revendeur habituel pour vous le procurer ou bien visiter les sites :<br/>
					- <a href="http://www.amazon.fr/dvd-blu-ray-films/b?ie=UTF8&node=405322">Amazon</a><br/>
					- <a href="http://www.cdiscount.com/dvd/v-104-0.html">CDiscount</a><br/>
				<br/>
				En espérant vous revoir bientôt parmi nous,<br/><br/>
				L\'équipe de DVD Recall.
			</body>
		</html>';
		
		if(mail($this->destinataire, $nomFilm.' est maintenant disponible en DVD !', $message, $headers)){
			echo 'Mail bien envoyé à '.$this->destinataire.' !<br/>';
		}
		else{
			echo 'Erreur lors de l\'envoi du mail de sortie de DVD ! Destinataire : '.$this->destinataire.'.<br/>';
		}
	}
	
	public function mailAjoutFilmAListe($idFilm){
		require './Modele/Modele_Film.php';
		
		$film = new Film($idFilm);
		$nomFilm = $film->getNom();
		$imgFilm = $film->getImage();
		
		$headers ='From: "Equipe de DVD Recall"<no-reply@dvdrecall.fr>'."\n";
		$headers .='Content-Type: text/html; charset="UTF-8"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';

		$message =
		'<html>
			<head>
				<title>'.
					$nomFilm.' a été ajouté à votre liste de films !'.
				'</title>
			</head>
			<body>
				Bonjour,<br/>
				Nous vous confirmons l\'ajout de : '.$nomFilm.' à votre liste de films !<br/><br/>
				<img src="'.$imgFilm.'" height="300" width="300">
				<br/>
				<br/>
				En espérant vous revoir bientôt parmi nous,<br/><br/>
				L\'équipe de DVD Recall.
			</body>
		</html>';
		
		if(mail($this->destinataire, 'Un nouveau film a été ajouté dans votre liste !', $message, $headers)){
			require './Vues/success.tpl';
			echo $nomFilm.' a bien été ajouté à votre liste.<br/>
			Un mail de confirmation vous a été envoyé à l\'adresse suivante : '.$this->destinataire.' !<br/>';
			echo '<br/>';
			require './Vues/boutonVersGoogle.tpl';
			echo '<br/>';
			echo '<br/>';
			echo '<img src="'.$imgFilm.'" height="300" width="300">';
			require './Vues/finDiv.tpl';
			
			header("Refresh: 5 ; url='http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=film&code=".$idFilm."'");
		}
		else{
			require './Vues/error/debutChampErreur.tpl';
			echo 'Erreur lors de l\'envoi de la confirmation d\'ajout à la liste vers : '.$this->destinataire.' !';
			require './Vues/finDiv.tpl';
		}
	}
	
	public function mailModifMail(){
		$headers ='From: "Equipe de DVD Recall"<no-reply@dvdrecall.fr>'."\n";
		$headers .='Content-Type: text/html; charset="UTF-8"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';

		$message =
		'<html>
			<head>
				<title>
					Modification de l\'adresse mail de votre compte DVD Recall
				</title>
			</head>
			<body>
				Suite à votre demande, nous vous confirmons la modification de l\'adresse mail<br/>
				vous permettant d\'accéder à votre compte.<br/>
				Désormais, vos nouveaux identifiants sont : <br/>
				&nbsp; - votre adresse mail : '.$this->destinataire.'<br/>
				&nbsp; - votre mot de passe : inchangé<br/>
				<br/>
				En espérant vous revoir bientôt parmi nous,
				
				L\'équipe de DVD Recall.
			</body>
		</html>';
		
		if(mail($this->destinataire, 'Modification du mot de passe de votre compte DVD Recall', $message, $headers)){
			require './Vues/success.tpl';
			echo 'Un mail vous a été envoyé pour finaliser la modification ; veuillez consulter votre boîte mail !<br/>';
			echo '<br/>';
			require './Vues/boutonVersGoogle.tpl';
			require './Vues/finDiv.tpl';
		}
		else{
			require './Vues/error/debutChampErreur.tpl';
			echo 'Erreur lors de l\'envoi du mail de confirmation vers : '.$this->destinataire.' !';
			require './Vues/finDiv.tpl';
		}
	}
	
	public function mailModifMDP($clean){
		$headers ='From: "Equipe de DVD Recall"<no-reply@dvdrecall.fr>'."\n";
		$headers .='Content-Type: text/html; charset="UTF-8"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';

		$message =
		'<html>
			<head>
				<title>
					Modification du mot de passe de votre compte DVD Recall
				</title>
			</head>
			<body>
				Suite à votre demande, nous vous confirmons la modification du mot de passe<br/>
				vous permettant d\'accéder à votre compte.<br/>
				Vos nouveaux identifiants sont : <br/>
				&nbsp; - votre adresse mail : '.$this->destinataire.'<br/>
				&nbsp; - votre mot de passe : '.$clean['newMdp'].'<br/>
				<br/>
				En espérant vous revoir bientôt parmi nous,
				
				L\'équipe de DVD Recall.
			</body>
		</html>';
		
		if(mail($this->destinataire, 'Modification du mot de passe de votre compte DVD Recall', $message, $headers)){
			require './Vues/success.tpl';
			echo 'Un mail vous a été envoyé pour finaliser la modification ; veuillez consulter votre boîte mail !<br/>';
			echo '<br/>';
			require './Vues/boutonVersGoogle.tpl';
			require './Vues/finDiv.tpl';
		}
		else{
			require './Vues/error/debutChampErreur.tpl';
			echo 'Erreur lors de l\'envoi du mail de confirmation vers : '.$this->destinataire.' !';
			require './Vues/finDiv.tpl';
		}
	}
}
?>
