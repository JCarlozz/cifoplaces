<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Crear un nuevo lugar - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Crear un nuevo lugar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'place'=> '/place/list',
		    'Nuevo lugar'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Nuevo Lugar</h2>
			
			<form method="POST" class="flex-container gap2" enctype="multipart/form-data" action="/Place/store">
				
				<div class="flex2">
				
					<input type="hidden" name="iduser" value=<?=user()->id?>>
					<label>Título</label>
					<input type="text" name="name" value="<?=old('name')?>">
					<br>
					<label>Tipo</label>
					<input type="text" name="type" value="<?=old('type')?>">
					<br>					
					<label>Imagen</label>
					<input type="file" name="mainpicture" accept="image/*" id="file-with-preview">
					<br>					
					<label>Localización</label>
					<input type="text" name="location" class="w50" value="<?=old('location')?>">
					<br>
					<label>Latitud</label>
					<input type="number" name="latitude" class="w50" value="<?=old('latitude')?>">
					<br>
					<label>Longitud</label>
					<input type="number" name="longitude" class="w50" value="<?=old('longitude')?>">
					<br>
					
					<label>Descripción</label>
					<textarea name="description" placeholder="Escribe aquí" class="w50"><?=old('text')?></textarea>
					<br>
					<div class="centrado my2">
						<input type="submit" class="button" name="guardar" value="Guardar">
						<input type="reset" class="button" value="Reset">
					</div>    
				</div>
				<figure class="flex1 centrado p2">
    				<img src="<?=FOTO_IMAGE_FOLDER.'/'.($place->name ?? DEFAULT_FOTO_IMAGE)?>"
    					class="cover" id="preview-image" alt="Previsualización de la portada">
    				<figcaption>Previsualización de la portada</figcaption>
    			</figure>		
			</form>
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Producto/list">Lista de productos</a>
			</div>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>	
	</body>
</html>
