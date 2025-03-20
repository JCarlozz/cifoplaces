 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Foto - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		<script src="/js/BigPicture.js"></script>
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Foto') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Foto'=> '/photo',
		    $photo->name =>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		
		
    		<h1><?= APP_NAME ?></h1>
    		
    		<a class="button" href="/Photo/edit/<?= $photo->id?>">Editar</a>
    		
    		<section id="detalles" class="flex-container gap2">
    			<div class="flex2">
    			<h2><?=$photo->name?></h2>
    			
    			
    			
    			<p><b>Nombre:</b>		<?=$photo->name?></p>
    			
    			<p><b>Lugar:</b>		<?=$photo->alt?></p>
    			<p><b>Descripción:</b>	<?=$photo->description?></p>
    			<p><b>Data:</b>			<?=$photo->date?></p>
    			<p><b>Hora:</b>			<?=$photo->time?>
    			    			
    			
    			</div>
    			<figure class="flex1 centrado p2">
        			<img src="<?=FOTO_IMAGE_FOLDER.'/'.($photo->file ?? DEFAULT_FOTO_IMAGE)?>"
        				class="cover enlarge-image" alt="Foto del usuario <?=$photo->alt?>">    					
        			<figcaption>Foto <?="$photo->name"?></figcaption>
        			<?php if($photo->file) {?>
        			<form method="POST" action="/Photo/dropcover" class="no-border">
        				<input type="hidden" name="id" value="<?=$photo->id?>">
        				<input type="submit" class="button-danger" name="borrar" value="Eliminar foto">
        			</form>
        			<?php } ?>	
        		</figure>    			
    		</section>	   		
    		
    		    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>
    			<a class="button" href="/Producto/list/">Lista de productos</a>
    			<?php  if(Login::user()->id ==  $user->id ){?>
    			<a class="button" href="/User/edit/<?= $user->id?>">Editar</a>
    			<a class="button" href="/User/delete/<?= $user->id?>">Darme de baja</a>
    			<?php } ?>    		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>