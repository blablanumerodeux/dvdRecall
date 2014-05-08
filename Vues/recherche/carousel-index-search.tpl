	<a href="http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=film&code=<?php echo $film->code;?>">
		<div style="text-align:center">
			<img src="<?php echo $film->poster->href ?>" height="500" width="300">
		</div>
	</a>
	<div class="carousel-caption">
		<h4>
			<a href="http://webperso.iut.univ-paris8.fr/~dlambla/progWeb/projet/index.php?controle=film&code=<?php echo $film->code;?>">
				<?php echo $film->originalTitle ?>
			</a>
		</h4>
		<p>
			Sortie au <?php echo html('cinéma');?> le : <?php 
					$date = $film->release->releaseDate;
					if(!empty($date)){
						$d = explode("-", $date);
						$dateFr = $d[0].'-'.$d[1].'-'.$d[2];
						if($d[1] < 10){
							$moisSortieDVD = sprintf("%03d", $d[1]);
						}
						echo $dateFr = $d[2].'-'.$d[1].'-'.$d[0];
					}
					else{
						echo $dateFr = 'NC';
					}
				?>
			<br/>
		</p>
	</div>
</div>
