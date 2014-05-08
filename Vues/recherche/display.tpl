<div class="alert alert-info" style="margin-left: 15%; margin-right: 15%; margin-top: 10px;">
<table>
	<tbody>
		<tr>
			<td>
				<a href="./index.php?controle=film&code= <?php echo $film->code ?>">
					<img src="<?php echo $film->poster->href ?>" alt="" height="100" width="100">
				</a>
			</td>
			<td>
				<a href="./index.php?controle=film&code=<?php echo $film->code ?>"><h4><?php echo $film->originalTitle ?></h4></a><br/>
				Date de sortie Cinema : <?php $date = $film->release->releaseDate;
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
				?><br/>
				Directeurs du Film : <?php echo $film->castingShort->directors ?><br/>
				Acteurs : <?php echo $film->castingShort->actors ?><br/>
			</td>
			<td> 
			<?php 	
					//$codeFilm=$film->code;
					//require './Vues/film/boutonAjout.tpl';
			?>
			</td> 
		</tr>
	</tbody>
</table>
</div>
<!-- ligne 12 : la mise en forme de la date est obligatoire dans ce fichier car les données récupérées sont en JSON donc format anglais ... -->
