<div class="alert alert-info" style="margin-left: 15%; margin-right: 15%; margin-top: 10px;">
   <div class="row-fluid">
	 <div class="span12">
	
		<div class="span2" >
			<?php echo '<td><a rel="lightbox" href="'.$film->getImage().'"><img src="'.$film->getImage(); ?>" alt="no-image" height="100" width="100"></a>
		</div>
		<div class="span7">
			<a href="./index.php?controle=film&code=<?php echo $film->getCode() ?>"> <h4><?php echo $film->getNom() //html(); ?></h4></a><br/> 
					 Date de sortie Cinema : <?php echo $film->getRelease() //html(); ?><br/> 
					 Directeurs du Film :  <?php echo $film->getDirecteur() //html(); ?><br/> 
					 Acteurs : <?php echo $film->getActeurs() //html();?><br/> 
		</div>
		<div class="span3" >
				<?php 	
						require './Vues/film/boutonSupprimer.tpl';
				?>
		</div>
	</div>
    </div>
 </div>
