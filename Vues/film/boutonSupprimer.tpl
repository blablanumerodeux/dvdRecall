<form class="form-horizontal pull-right" action="index.php?controle=abonnement&action=supprimer" method="post">
	<br/>
	<br/>
	<input type="hidden" name="codeFilm" value="<?php echo $film->getCode()?>">
	<button class="btn btn-warning" type="submit">Supprimer de ma liste !</button>
	<br/>
</form>
