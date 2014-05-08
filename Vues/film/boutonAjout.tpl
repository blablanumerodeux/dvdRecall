		<form class="form-horizontal" action="index.php?controle=abonnement&action=ajouter" method="post">
			<input type="hidden" name="codeFilm" value="<?php echo $film->getCode()?>">
			<button class="btn btn-success" type="submit">Ajouter à ma liste !</button>
		</form>
