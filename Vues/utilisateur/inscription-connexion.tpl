<div class="container" style="margin-top:10%; border-radius: 10px; background-color:#A9F4EA;">
	<div class="row-fluid-center">
		<div class="span12">
			<div class="row-fluid-center">
				<br/>
				<div class="span5">
					<form action="index.php?controle=connexion&action=valide" method="post">
										<b><u>Déjà inscrit ?</u></b>
										<br/>
										<br/>
										<div class="input-prepend">
											<label for="login">E-mail :</label>
											<span class="add-on">@</span>
											<input class="input-xlarge" name="login" id="login" <?php
												if(isset($clean['login']) && !empty($clean['login'])){
													echo 'value="'.html($clean['login']).'"';
												}
												else{
													echo 'value=""';
												}
											?>type="text" />
											<br/>
											<br/>
											<label for="password">Mot de Passe :</label>
											<span class="add-on"><i class="icon-lock"></i></span> 
											<input class="input-xlarge" name="password" id="password" value="" type="password" />
										</div>
										<br/>
										<input id="reset" type="reset" class="btn btn-primary btn-warning"/>
										<input id="validate" type="submit" class="btn btn-primary btn-success"/>

					</form>
				</div>
				<div class="span5">
					<form action="index.php?controle=inscription&action=valide" method="post">
								<b><u>Formulaire d'inscription</u></b>
								<br/>
								<br/>
									<div class="input-prepend">
										<label for="login">E-mail :</label>
										<span class="add-on">@</span>
										<input class="input-xlarge" name="login" id="login" <input name="login" id="login" <?php
											if(isset($mail) && !empty($mail)){
												echo 'value="'.html($mail).'"';
											}
											else{
												echo 'value=""';
											}
										?>type="text" />
										<br/>
										<br/>
										<label for="password">Mot de Passe :</label>
										<span class="add-on"><i class="icon-lock"></i></span> 
										<input class="input-xlarge" name="password" id="password" value="" type="password" />
									</div>
									<br/>
									<input id="reset" type="reset" class="btn btn-primary btn-warning"/>
									<input id="validate" type="submit" class="btn btn-primary btn-success"/>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<br/>
<br/>
<div class="container">
	<div class="row-fluid-center">
		<div class="span12">
			<div class="row-fluid-center">
				<div class="span9">
					<div class="alert">
						<strong>Attention!</strong> L'adresse mail indiquée doit être au format : <strong>adresse@fai.fr</strong>,<br/>
						Le mot de passe, de 6 à 20 caractères, doit contenir <u>au moins 1 chiffre et 1 lettre</u>.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>