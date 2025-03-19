 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Eliminar producto - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Eliminar producto') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Productos'=>'/producto',
		    $producto->titulo=>'titulo',
		    'Borrar'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Borrar producto</h2>
    		    		
    		<form method="POST" class="centered m2" action="/Producto/destroy">
				<p>Confirmar el borrado del producto <b><?=$producto->titulo?></b>.</p>
    			    			
    			<input type="hidden" name="id" value="<?=$producto->id?>">
    			<input class="button-danger" type="submit" name="borrar" value="Borrar">
    		</form> 
    		
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Producto/list">Lista de productos</a>
				<a class="button" href="/Producto/show/<?=$producto->id?>">Detalles</a>
				<a class="button" href="/Producto/edit/<?=$producto->id?>">Edición</a>
			</div>    		
		</main>
			
		<?= $template->footer() ?>
		<?= $template->version() ?>	
	</body>
</html>
