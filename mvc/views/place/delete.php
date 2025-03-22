 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Eliminar lugar - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Eliminar lugar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugar'=>'/place',
		    $place->name=>"/Place/show/".$place->id,
		    'Borrar'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		
			<?php if(Login::user()->id == $user->id) {?>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Borrar lugar</h2>
    		    		
    		<form method="POST" class="centered m2" action="/Place/destroy">
				<p>Confirmar el borrado del lugar <b><?=$place->name?></b>.</p>
    			    			
    			<input type="hidden" name="id" value="<?=$place->id?>">
    			<input class="button-danger" type="submit" name="borrar" value="Borrar">
    		</form> 
    		
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Place/list">Lista de productos</a>
				<a class="button" href="/Place/show/<?=$place->id?>">Detalles</a>
				<a class="button" href="/Place/edit/<?=$place->id?>">Edición</a>
			</div>
			<?php }?>    		
		</main>
			
		<?= $template->footer() ?>
		<?= $template->version() ?>	
	</body>
</html>
