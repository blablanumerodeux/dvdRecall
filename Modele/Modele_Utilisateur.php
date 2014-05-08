<?php
class Utilisateur {

	protected $count;
	protected $select;
	protected $existDansBDD;
	protected $insert;
	protected $recupMail;
	protected $update;
	protected $updateMDP;

	public function Utilisateur(){
		// recuperations du nombre de lignes correspondantes
		$sql="SELECT count(*) FROM User WHERE email=? AND mdp=?";
		$this->count = Controller_Template::$db->prepare($sql);
		
		// recuperations de l'id correspondant a l'email
		$sql2="SELECT id FROM User WHERE email=? AND mdp=?";
		$this->select = Controller_Template::$db->prepare($sql2);
		
		// existence du mail dans la base de données
		$sql3='SELECT COUNT(*) FROM User WHERE email = ?';
		$this->existDansBDD = Controller_Template::$db->prepare($sql3);
		
		// ajout nouveau membre
		$sql4 = 'INSERT INTO User (email, mdp) VALUES (?, ?)';
		$this->insert = Controller_Template::$db->prepare($sql4);
		
		// récupération mail par id
		$sql5='SELECT email FROM User WHERE id=?';
		$this->recupMail = Controller_Template::$db->prepare($sql5);
		
		// mise à jour du mail
		$sql6='UPDATE User SET email=? WHERE id=?';
		$this->update = Controller_Template::$db->prepare($sql6);
		
		// mise à jour du mdp
		$sql7='UPDATE User SET mdp=? WHERE id=?';
		$this->updateMDP = Controller_Template::$db->prepare($sql7);
	}
    
    
	function exist($clean){
		require_once './functions.php';

		array_walk($clean, 'sgbd');

		$sttmnt=$this->count;
		try {
			$sttmnt->execute(array($clean['login'],md5($clean['password'])));
			$row = $sttmnt->fetchColumn();
			if ($row[0]>=1){
				$this->select->execute(array($clean['login'],md5($clean['password'])));
				$row = $this->select->fetch();
				$exist=$row['id'];
			}else {
				$exist=0;
			}
			// fermeture connexion BDD
			$res = null;
			$dbh = null;
		}
		catch (PDOException $e) {
			print $e->getMessage();
		}
		return $exist;
	}
    
	function inscrire($clean){
    	require_once './Modele/Modele_EnvoiMail.php';
    		
    	session_start();
    	$testExistence = $this->existDansBDD;
		
		try{
			// existe déjà dans la BDD
			/* Récupère le nombre de lignes qui correspond à la requête SELECT */
			$testExistence->execute(array($clean['login']));
			if($testExistence->fetchColumn() > 0){
			
			}
			else{	/* Aucune ligne ne correspond donc ajout dans BDD */
				$ajoutBDD = $this->insert;
				try{
					$ajoutBDD->execute(array(sgbd($clean['login']), md5(sgbd($clean['password']))));
					
					// Envoi du mail pour indiquer les informations du compte
					$mailRecap = new EnvoiMail($clean);
					$mailRecap->mailInscription();
					
					// récupération de l'identifiant de connexion
					$recupIDConnexion = $this->select;
					try{
						$recupIDConnexion->execute(array($clean['login'], md5($clean['password'])));
						$_SESSION['id'] = $recupIDConnexion->fetchColumn();
						return 1;
					}
					catch(PDOException $e){
						print $e->getMessage();
					}
				}
				catch(PDOException $e){
					print $e->getMessage();
				}
			}
			// fermeture connexion BDD
			$testExistence = null;
			$dbh = null;
		}
		catch(PDOException $e){
			print $e->getMessage();
		}
	}
	
	function modifierEmail($clean){
		require_once './Modele/Modele_EnvoiMail.php';
		//on cree des valeurs pour la fonction exist()
	    $clean['login']=$clean['email'];
		if($this->update->execute(array($clean['email'], $clean['id']))){
			// Envoi du mail pour indiquer les informations du compte
			$mailRecap = new EnvoiMail($clean);
			$mailRecap->mailModifMail();
			return $this->update->execute(array($clean['email'], $clean['id']));
		}
		else{
			return 0;
		}
	}
	
	function mailCorrespondant($id){
		$this->recupMail->execute(array($id['idUser']));
		return $this->recupMail->fetch();
	}
	
	function modifierMdp($clean){
		require_once './Modele/Modele_EnvoiMail.php';
		//on cree des valeurs pour la fonction exist()
	    $clean['login']=$clean['email'];
	    $clean['password']=$clean['oldMdp'];
	    	
	    //si son ancien mot de passe est bon, alors on le change par le nouveau
		if ($this->exist($clean)){
			if($this->updateMDP->execute(array(md5($clean['newMdp']), $clean['id']))){
				// Envoi du mail pour indiquer les informations du compte
				$mailRecap = new EnvoiMail($clean);
				$mailRecap->mailModifMDP($clean);
				return $this->updateMDP->execute(array(md5($clean['newMdp']), $clean['id']));
			}
		}
		//sinon, il a mal saisi son ancien mdp
		else{
			return 0;
		}
	}
}
?>
