 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar foto <?=$photo->name?> - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Editar foto') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugar'=> 'Place/list',
		    "$photo->name" => "Photo/show/$photo->id",
		    'Editar foto'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<?php  if(Login::user()->id == $user->id && $user->active || Login::isAdmin() ){?>
			<?php } else {
                    echo "<script>alert('No tienes permisos para acceder a esta página.'); window.location.href='/';</script>";
                    exit();}?>	
						
    		<h1><?= APP_NAME ?></h1>
    		<h2>Editar foto <?= $photo->name?></h2>
    		<section class="flex-container gap2">
    		
    		<form method="POST" action="/Photo/update" class="flex2 no-border" enctype="multipart/form-data">
			
    			<!-- input oculto que contiene ID -->
    			<input type="hidden" name="id" value="<?=$photo->id?>">
    			<input type="hidden" name="iduser" value="<?=$photo->iduser?>">	
    			<input type="hidden" name="idplace" value="<?=$photo->idplace?>">
    			
    			<label>Nombre</label>
    			<input type="text" name="name" value="<?=old('name', $photo->name)?>">
    			<br>
    			<label>Lugar</label>
    			<input type="text" name="description" value="<?=old('description', $photo->description)?>">
    			<br>
    			<label>Descripcíon</label>
    			<input type="text" name="alt" value="<?=old('alt', $photo->alt)?>">
    			<br>
    			<label>Fecha</label>
    			<input type="date" name="date" value="<?= old('date', $photo->date)?>">
    			<br>
    			<label>Hora</label>
    			<input type="time" name="time" value="<?= old('time', $photo->time)?>"> 		
    			<br>    			   			
    			<label>Imagen de perfil</label>
    			<input type="file" name="file" accept="image/*" id="file-with-preview">
    			<br>    			
    			
    			<div class="centrado my2">
    				<input type="submit" class="button" name="actualizar" value="Actualizar">
    				<input type="reset" class="button" value="Reset">
    			</div>
    		</form>
    		
    		<figure class="flex1 centrado p2">
    			<img src="<?=FOTO_IMAGE_FOLDER.'/'.($photo->file ?? DEFAULT_FOTO_IMAGE)?>"
    				class="cover" id="preview-image" alt="Previsualización de la foto">
    			<figcaption>Foto <?="$photo->name"?></figcaption>
    			<?php if($photo->file) {?>
    			<form method="POST" action="/Photo/dropcover" class="no-border">
    				<input type="hidden" name="id" value="<?=$user->id?>">
    				<input type="submit" class="button-danger" name="borrar" value="Eliminar portada">
    			</form>
    			<?php } ?>	
    		</figure>
    		</section> 		
    				
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Place/list">Lista de lugares</a>
			</div>  
			
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>	
	</body>
</html>

