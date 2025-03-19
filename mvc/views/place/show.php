 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de productos - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Lista de productos') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Productos'=>'/producto',
		    $producto->titulo=>NULL 
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<section id="detalles" class="flex-container gap2">
    			<div class="flex2">
        			<h2><?= $producto->titulo?></h2>
        			<td><?= $producto->titulo ?></td>
                                    			        			
        			<p><b>Título:</b>			<?=$producto->titulo?></p>        			
        			<p><b>Precio:</b>			<?=$producto->precio?> €</p>
        			<p><b>Estado:</b>			<?=$producto->estado?></p>
        			<p><b>Fecha de anuncio:</b>	<?=$producto->created_at?></p>
        			
        			<h2>Contacto</h2>    				   			
    				<a class="button" href="/User/show/<?=$producto->idusers?>">
    					Contacto
    				</a>        			
        			   		
    			</div>
    			<figure class="flex1 centrado p2">
    				<img src="<?=PRO_IMAGE_FOLDER.'/'.($producto->foto ?? DEFAULT_PRO_IMAGE)?>"
    					class="cover enlarge-image"
    					alt="Portada del producto: <?=$producto->titulo?>">
    				<figcaption>Portada de <?="$producto->titulo"?></figcaption>
    			</figure>   			
    		</section>
    		
    		<section>
    			<h2>Descripción</h2>
    			<p><?=$producto->descripcion ? paragraph($producto->descripcion) : 'SIN DETALLES'?>   		
    		</section>    		
    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>    			 		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>