 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición del lugar - <?= APP_NAME ?></title>
		
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
		<?= $template->header("Edición del lugar $place->name") ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugares'=>'/place/list',
		    $place->name=>"/Place/show/$place->id",
		    'Edición'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		<?php  if(Login::user()->id == $user->id && $user->active || Login::isAdmin() || Login::oneRole('[ROLE_MODERATOR]')){?>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Edición del lugar <?= $place->name?></h2>
    		<section class="flex-container gap2">
    		
    		<form method="POST" action="/Place/update" class="flex2 no-border" enctype="multipart/form-data">
			
    			<!-- input oculto que contiene ID -->
    			<input type="hidden" name="id" value="<?=$place->id?>">    					
    			
    			
    			<input type="hidden" name="iduser" value=<?=user()->id?>>
					<label>Título</label>
					<input type="text" name="name" value="<?=old('name',$place->name )?>">
					<br>
					<label>Tipo</label>
					<input type="text" name="type" value="<?=old('type',$place->type)?>">
					<br>					
					<label>Imagen</label>
					<input type="file" name="mainpicture" accept="image/*" id="file-with-preview">
					<br>					
					<label>Localización</label>
					<input type="text" name="location" class="w50" value="<?=old('location',$place->location)?>">
					<br>
					<label>Latitud</label>
					<input type="number" name="latitude" class="w50" value="<?=old('latitude',$place->latitude)?>">
					<br>
					<label>Longitud</label>
					<input type="number" name="longitude" class="w50" value="<?=old('longitude',$place->longitude)?>">
					<br>
					
					<label>Descripción</label>
					<textarea name="description" placeholder="Escribe aquí" class="w50"><?=old('text', $place->text)?></textarea>
					<br>
    			<div class="centrado my2">
    				<input type="submit" class="button" name="actualizar" value="Actualizar">
    				<input type="reset" class="button" value="Reset">
    			</div>
    		</form>
    		<figure class="flex1 centrado p2">
    			<img src="<?=FOTO_IMAGE_FOLDER.'/'.($place->mainpicture ?? DEFAULT_FOTO_IMAGE)?>"
    				class="cover" id="preview-image" alt="Previsualización de la imagen">
    			<figcaption>Portada de <?="$place->name"?></figcaption>
    			<?php if($place->mainpicture) {?>
    			<form method="POST" action="/Place/dropcover" class="no-border">
    				<input type="hidden" name="id" value="<?=$place->id?>">
    				<input type="submit" class="button-danger" name="borrar" value="Eliminar foto">
    			</form>
    			<?php } ?>	
    		</figure>
    		</section>  		
    		
    				
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Place/list">Lista de lugares</a>
			</div>
			<?php } ?>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>

