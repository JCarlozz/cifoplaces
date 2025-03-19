 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de productos - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		<script src="/js/Preview.js"></script>
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header("Edicion del $producto->titulo") ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'productos'=>'/producto',
		    $producto->titulo=>"/Producto/show/$producto->id",
		    'Edición'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Edición de producto <?= $producto->titulo?></h2>
    		<section class="flex-container gap2">
    		
    		<form method="POST" action="/Producto/update" class="flex2 no-border" enctype="multipart/form-data">
			
    			<!-- input oculto que contiene ID -->
    			<input type="hidden" name="id" value="<?=$producto->id?>">    					
    			
    			
    			<label>Título</label>
    			<input type="text" name="titulo" value="<?=old('titulo', $producto->titulo)?>">
    			<br>
    			<label>Precio</label>
    			<input type="text" name="precio" value="<?=old('precio', $producto->precio)?>">
    			<br>
    			<label>Estado</label>
    			<input type="text" name="estado" value="<?=old('estado', $producto->estado)?>">
    			<br>
    			<label>Imagen</label>
    			<input type="file" name="portada" accept="image/*" id="file-with-preview">
    			    			
    			<label>Descripción</label>
    			<textarea name="descripcion" class="w50"><?=old('descripcion', $producto->descripcion)?></textarea>
    			<br>
    			<div class="centrado my2">
    				<input type="submit" class="button" name="actualizar" value="Actualizar">
    				<input type="reset" class="button" value="Reset">
    			</div>
    		</form>
    		<figure class="flex1 centrado p2">
    			<img src="<?=PRO_IMAGE_FOLDER.'/'.($producto->fotO ?? DEFAULT_PRO_IMAGE)?>"
    				class="cover" id="preview-image" alt="Previsualización de la imagen">
    			<figcaption>Portada de <?="$producto->titulo"?></figcaption>
    			<?php if($producto->foto) {?>
    			<form method="POST" action="/Producto/dropcover" class="no-border">
    				<input type="hidden" name="id" value="<?=$producto->id?>">
    				<input type="submit" class="button-danger" name="borrar" value="Eliminar foto">
    			</form>
    			<?php } ?>	
    		</figure>
    		</section>  		
    		
    				
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Producto/list">Lista de productos</a>
			</div>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>

