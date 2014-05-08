<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr-FR" lang="fr-FR">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="icon" type="image/png" href="./Vues/favicon-dvdrecall.png" />
	<link rel="stylesheet" type="text/css" href="./Vues/bootstrap/css/bootstrap.css" media="all"/>
	<link href="./Vues/bootstrap/js/lightbox/css/lightbox.css" rel="stylesheet" />
	<script type="text/javascript" src="./Vues/bootstrap/js/jquery.js"></script>
	<script type="text/javascript" src="./Vues/bootstrap/js/lightbox/js/lightbox.js"></script>
	<script type="text/javascript" src="./Vues/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.carousel').carousel({
				"interval": 2000,
				"pause":"false"
			});
		});
	</script>
	<title><?php echo $title;?></title>
</head>
<body>
	<div class="navbar navbar-inverse">
		<div class="navbar-inner">
			<a class="brand" href="./index.php?controle=accueil" title="Accueil"><i class="icon-home icon-white"></i> DVD Recall</a>
			
			<ul class="nav">
				<li class="divider-vertical"><a href="./index.php?controle=search" title="Search"><i class="icon-search icon-white"></i> Recherche</a></li>
				
				<?php
					$session=session_start();
					if (isset($_SESSION) && !empty($_SESSION)){
				?>
				
				<li class="divider-vertical"><a href="./index.php?controle=deconnexion" title="Deconnexion"><i class="icon-off icon-white"></i> Deconnexion</a></li>
				<li class="divider-vertical"><a href="./index.php?controle=abonnement&action=afficher" title="listeFilms"><i class="icon-film icon-white"></i> Votre Liste de Films</a></li>
				<li class="divider-vertical"><a href="./index.php?controle=inscription&action=affichageMonCompte" title="monProfil"><i class="icon-user icon-white"></i> Mon profil</a></li>
				
				<?php
					}else{
				?>
				
				<li class="divider-vertical"><a href="./index.php?controle=connexion&action=index" title="Connexion"><i class="icon-share-alt icon-white"></i> Connexion/Inscription</a></li>
				
				<?php
					}
				?>
			</ul>
			
			<div class="navbar pull-right">
			    <?php 
					if ($_SESSION['login'] != NULL){
						echo '<a href="./index.php?controle=inscription&action=affichageMonCompte">Connecté(e) en tant que '.$_SESSION['login'].'</a>';
					}
					else{
				?>
				<a href='./index.php?controle=connexion&action=index'>Vous n'êtes pas connecté(e)</a>
				<?php }?>
			</div>
		</div>
	</div>
