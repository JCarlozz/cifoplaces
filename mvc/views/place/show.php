 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de lugares - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Lista de lugares') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugares'=>'/lugares',
		    $place->name=>NULL 
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<section id="detalles" class="flex-container gap2">
    			<div class="flex2">
        			<h2><?= $place->name?></h2>
        			<td><?= $place->titulo ?></td>
                                    			        			
        			<p><b>Título:</b>			<?=$place->name?></p>        			
        			<p><b>Tipo:</b>				<?=$place->type?></p>
        			<p><b>Localización:</b>		<?=$place->location?></p>
        			<p><b>Fecha de anuncio:</b>	<?=$place->created_at?></p>
        			<p><b>Latitud:</b>			<?=$place->latitude?></p>
        			<p><b>Longitud:</b>			<?=$place->longitude?></p>
        			<p><b>Descripción:</b>		<?=$place->description ? paragraph($place->description) : 'SIN DETALLES'?></p>
        			
        			    				   			
    				<a class="button" href="/Photo/create/<?=$place->iduser?>">
    					Añadir foto
    				</a>        			
        			   		
    			</div>
    			<figure class="flex2º centrado p2">
    				<img src="<?=FOTO_IMAGE_FOLDER.'/'.($place->mainpicture ?? DEFAULT_FOTO_IMAGE)?>"
    					class="large enlarge-image"
    					alt="Portada del producto: <?=$place->name?>">
    				<figcaption>Portada de <?="$place->name"?></figcaption>
    			</figure>   			
    		</section>
    		
    		<section>
    			 <h2>Comentarios:</h2>
    			 <?php foreach ($place as $p){?>
                    <tr> 
                        <h2><?= $p->text ?><h2>
                        <p><?= $p->username ?></p>
                        <td class="centrado">
                            <a href='/Comment/destroy/<?= $p->id ?>' title="Borrar">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php }?> 
    			
    			<form method="POST" action="/Comment/store">
    			
    			<textarea name="comment" rows="4" cols="50" placeholder="Escribe aquí tu comentario"></textarea>
    						
    			<input type="hidden" name="idplace" value="<?=$place->id?>">
    			<input type="hidden" name="iduser" value="<?=$place->iduser?>">
    						
    			<div class="centrado my2">    				
    				<input type="submit" class="button" name="guardar" value="Añadir comentario">
    				
    			</div>
    			</form> 		
    		</section>    		
    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>    			 		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>