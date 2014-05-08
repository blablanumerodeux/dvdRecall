<?php echo $erreur.'</div>' ?>
<div class="container" style="margin-left: 20%; margin-right: 15%;">
	<div class="row-fluid-center">
		<table>
			<tr>
				<td>
					<form action="index.php?controle=inscription&action=modificationCompte" method="post">
						<h2>Mon profil</h2><br/>				
						<label for="email">email :</label>
						<input name="email" id="email" value="<?php echo $_SESSION['login']; ?>" type="text" />					
						<input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
						<br/>
						____________________________
						<br/>
						<br/>						
						<label for="oldMdp">Ancien mot de passe :</label>
						<input name="oldMdp" id="oldMdp" value="" type="password" />
										
						<label for="newMdp">Nouveau mot de passe :</label>
						<input name="newMdp" id="newMdp" value="" type="password" />
						<br/>
								
						<label for="newMdpConf">Confirmation :</label>
						<input name="newMdpConf" id="newMdpConf" value="" type="password" />
						<br/>
								
						<input id="reset" type="reset" class="btn btn-large btn-warning"/>
						<input id="validate" type="submit" class="btn btn-large btn-success"/>
					</form>
				</td>
				<td style="width: 20px;">
				</td>
				<td>
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
					<div class="alert" style="padding-left: 40px;">
						<strong><u><?php echo html('Comment mettre à jour ses informations ?');?></u></strong>
						<br/>
						<br/>
						<li>
							Si vous souhaitez changer votre <strong>adresse mail</strong> indiquez-en une nouvelle tout en
							<br/>
							respectant le format : <strong>adresse@fai.fr</strong>.
							<br/>
						</li>
						<br/>
						<li>
							Si vous souhaitez changer votre <strong>mot de passe</strong> renseignez votre mail, l'ancien puis le nouveau <br/>
							mot de passe et enfin la confirmation de ce nouveau mot de passe, veillez <?php echo html('à');?> respecter les conditions suivantes :
							<br/>
							<br/>
							<ul> - 6 <?php echo html('à 20 caractères');?>,</ul>
							<ul> - au moins 1 chiffre,</ul>
							<ul> - au moins 1 lettre.</ul>
						</li>
						<br/>
					</div>
				</td>
			</tr>
		</table>	
	</div>
</div>