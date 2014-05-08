<div class="alert alert-info" style="margin-left: 15%; margin-right: 15%;">
	<div class="span2"></div><strong><?php echo html('Vous avez vu le dernier James Bond et vous voulez être averti de sa sortie en DVD !?'); ?><br/>
	<div class="span2"></div><?php echo html('Indiquez simplement le nom du film que vous recherchez et préparez vos billets !!! '); ?><br/></strong>
	<br/>	
	<div class="span3"></div><form class="form-search" action="index.php?controle=results&action=calcule" method="post">
	  <input type="text" class="input-medium search-query" name='q'/>
	  <button type="submit" class="btn">Lancer la Recherche</button>
	</form>
	<div class="span3"></div><i>Ex : Avatar, Men in Black, Skyfall, Parker, The Hobbit, ...</i>
</div>
