<div class="alert alert-info" style="margin-left: 15%; margin-right: 15%; margin-top: 10px;">
	<table>
		<caption><h1><?php echo $film->getNom() ?></h1></caption>
		<tbody>
			<tr>
				<?php echo '<td><a rel="lightbox" href="'.$film->getImage().'"><img src="'.$film->getImage(); ?>" alt="no-image" height="250" width="250"></a></td>
				<td>
					<!--Code Film : <?php echo $film->getCode() ?><br/>-->
					Titre Original : <?php echo $film->getNom() ?>
					<br/>
					Date de sortie : <?php echo $film->getRelease() ?>
					<br/>
					<font color="#FF0000">Date de sortie DVD : <?php echo $film->getReleaseDVD();?> </font>
					<br/>							
					Directeurs du Film : <?php echo $film->getDirecteur()?>
					<br/>
					Acteurs : <?php echo $film->getActeurs()?>
					<br/>
					Nombre d'Abonnements : <?php echo $nbAbonnementFilm;?>
					<br/>
					<br/>
					<img src="./Vues/allocine.jpg" height="30" width="200">
					<?php echo '<a href="'.$film->getLienAllocine().'">'.$film->getNom().' sur Allociné'.'</a><br/>';?>
					<br/>
					<div class="accordion" id="accordion2">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
									<strong><u>Afficher le Synopsis du film</u></strong>
								</a>
							</div>
							<div id="collapseOne" class="accordion-body collapse out">
							<div class="accordion-inner">
								<?php echo $film->getSynopsis()?>
								<br/>
							</div>
						</div>
					</div>
				</div>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
				<?php 			
				//Si il n'est pas deja abonnee 
				$abonnement = new Abonnement();
				//if ($film->getRelease()!='NC'){//Si la date est connue

					//Si il est connecte
					/*$session=session_start();
					if (isset($_SESSION) && !empty($_SESSION)){*/
	
						//Si il n'est pas deja abonne
						if($abonnement->exist($_SESSION['id'],$film->getCode()) == 0){
		
							if ($film->getRelease() == 'NC'){
								$dateDvd ='NC';
							}else{
								$dateDvd = explode ('-', $film->getReleaseDVD());
							}
							//Si le film n'est pas deja sorti
							if ((compareDate($dateDvd))==-1){
								require './Vues/film/boutonAjout.tpl';
							}else {
								echo 'Abonnement impossible : Le film est deja sorti en DVD';
							}
						}else{
							require './Vues/film/boutonSupprimer.tpl';
						}
					/*}else{
						echo 'Abonnement impossible : Vous n\'etes pas connecte';
					}*/
				/*}else{
					echo 'Abonnement impossible : date inconnue';
				}*/

				?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
