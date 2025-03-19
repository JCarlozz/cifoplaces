<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Crear un nuevo producto - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Crear un nuevo producto') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Productos'=> '/producto',
		    'Nuevo producto'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Nuevo Producto</h2>
			
			<form method="POST" class="flex-container gap2" enctype="multipart/form-data" action="/Producto/store">
				
				<div class="flex2">
				
					<input type="hidden" name="idusers" value=<?=user()->id?>>
					<label>Título</label>
					<input type="text" name="titulo" value="<?=old('titulo')?>">
					<br>
					<label>Precio</label>
					<input type="number" name="precio" value="<?=old('precio')?>">
					<br>					
					<label>Imagen</label>
					<input type="file" name="foto" accept="image/*" id="file-with-preview">
					<br>
					<label>Estado</label>
					<select name="estado">
						<option value="Como nuevo" <?=oldSelected('estado','Como nuevo')?>>
							Como nuevo</option>
						<option value="Nuevo" <?=oldSelected('estado','Nuevo')?>>
							Nuevo</option>
						<option value="Usado" <?=oldSelected('estado','Usado')?>>
							Usado</option>
					</select>
					<br>							
					<label>Descripción</label>
					<textarea name="descripcion" class="w50"><?=old('descripcion')?></textarea>
					<br>
					<div class="centrado my2">
						<input type="submit" class="button" name="guardar" value="Guardar">
						<input type="reset" class="button" value="Reset">
					</div>    
				</div>
				<figure class="flex1 centrado p2">
    				<img src="<?=PRO_IMAGE_FOLDER.'/'.($producto->titulo ?? DEFAULT_PRO_IMAGE)?>"
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
