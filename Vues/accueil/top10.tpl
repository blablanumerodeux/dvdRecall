<tr>
	<td>
		<div class="span5">
			<a href="http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=film&code=<?php echo $filmClassement->getCode();?>">
				<img src="<?php echo $filmClassement->getImage(); ?>" alt="No image" height="60" width="60">
			</a>
		</div>
	</td>
	<td>
		<div class="span5">
			<a href="http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=film&code=<?php echo $filmClassement->getCode();?>">
				<?php echo $filmClassement->getNom(); ?>
			</a>
		</div>
	</td>
	<td>
		<div class="span2">
			<?php echo $nbAbonnementFilm.' Abonnement(s)' ?>
		</div>
	</td>
</tr>