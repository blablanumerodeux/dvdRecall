<?php
class Abonnement {
	protected $insert;
	protected $select;
	protected $exist;
	protected $remove;
	protected $selectAll;
	protected $selectId;

	public function Abonnement(){
	
		// création d'un abonnement
		$sql='INSERT INTO AbonnementFilm (idUser, codeFilm) VALUES (?,?);';
		$this->insert = Controller_Template::$db->prepare($sql);
		
		// récupération d'un abonnement
		$sql2='SELECT codeFilm FROM AbonnementFilm WHERE idUser=?;';
		$this->select = Controller_Template::$db->prepare($sql2);
		
		// existence de l'abonnement
		$sql3='SELECT COUNT(*) FROM AbonnementFilm WHERE idUser=? AND codeFilm=?';
		$this->exist = Controller_Template::$db->prepare($sql3);
		
		// suppression de l'abonnement
		$sql4='DELETE FROM AbonnementFilm WHERE idUser=? AND codeFilm=?';
		$this->remove = Controller_Template::$db->prepare($sql4);
		
		// récupération de tous les films présents dans la table
		$sql5='SELECT DISTINCT codeFilm FROM AbonnementFilm;';
		$this->selectAll = Controller_Template::$db->prepare($sql5);
		
		$sql6='SELECT idUser FROM AbonnementFilm WHERE codeFilm=?;';
		$this->selectId = Controller_Template::$db->prepare($sql6);
	}

	public function insert($id,$code){
		require './Modele/Modele_EnvoiMail.php';
		require './Modele/Modele_Utilisateur.php';
		$mailRecapAbonnement = new EnvoiMail($_SESSION);
		$mailRecapAbonnement->mailAjoutFilmAListe($code);
		return  $this->insert->execute(array($id,$code));
	}
	
	function exist($id, $code){
	    	require_once './functions.php';
	
		$sttmnt=$this->exist;
		try {
			$sttmnt->execute(array($id, $code));
			$row = $sttmnt->fetchColumn();
			$exist= $row;
			// fermeture connexion BDD
			$res = null;
			$dbh = null;
		}
		catch (PDOException $e) {
			print $e->getMessage();
		}
		return $exist;
    	}
    
	public function mesAbonnements($id){
		$this->select->execute(array($id));	
		return $this->select;
	}
	
	public function supprimer($id, $code){
		$this->remove->execute(array($id, $code));	
		return $this->remove;
	}
	
	public function selectAll(){
		$this->selectAll->execute();
		return $this->selectAll;
	}
	
	public function selectId($code){
		$this->selectId->execute(array($code));
		return $this->selectId;
	}
}
?>
