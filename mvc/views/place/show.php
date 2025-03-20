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
		    'Lugares'=>'/Place/list/',
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
        			
        			    				   			
    				<a class="button" href="/Photo/create/<?=$place->id?>">
    					Añadir foto
    				</a>        			
        			   		
    			</div>
    			<figure class="flex2 centrado p2">
    				<img src="<?=FOTO_IMAGE_FOLDER.'/'.($place->mainpicture ?? DEFAULT_FOTO_IMAGE)?>"
    					class="large enlarge-image"
    					alt="Portada del lugar: <?=$place->name?>">
    				<figcaption>Portada de <?="$place->name"?></figcaption>
    			</figure>    			  			
    		</section>
    		
    		<?php if (!empty($photos)) { ?>
            <section>
                <h2>Otras fotos:</h2>
                <div class="galeria-lugares">
                    <?php foreach ($photos as $photo) { ?>
                        <?php if (!empty($photo->file)) { ?>
                            <figure class="galeria-lugares">
                                <a href="/Photo/show/<?= $photo->id ?>">
                                    <img src="<?= FOTO_IMAGE_FOLDER . '/' . $photo->file ?>" class="large enlarge-image">
                                </a>                 
                            </figure>
                        <?php } ?>
                    <?php } ?>
                </div>
            </section>
        	<?php } ?>
        	
        	<section>
                <h2>Comentarios:</h2>
            
                <?php if (!empty($comments)) { ?>
                    <div class="comments-container">
                        <?php foreach ($comments as $comment) { ?>
                            <div class="comment">
                                <figure class="comment-avatar">
                                    <img src="<?= USER_IMAGE_FOLDER . '/' . ($comment->userpicture ?? DEFAULT_USER_IMAGE) ?>" alt="Imagen de <?= $user->displayname ?>">
                                </figure>
                                <div class="comment-content">
                                    <p class="comment-author"><?= user()->displayname ?></p>
                                    <p class="comment-text"><?= $comment->text ?></p>
                                    <p class="comment-text"><?= $comment->created_at ?></p>
                                    
                                </div>
                                <div class="comment-actions">
                                    <form method="POST" action="/Comment/destroyplace">
                                    	<input type="hidden" name="iduser" value="<?= user()->id ?>">
                                        <input type="hidden" name="id" value="<?= $comment->id ?>">
                                        <button type="submit" class="button small" name="borrar">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <p class="no-comments">No hay comentarios aún. ¡Sé el primero en comentar!</p>
                <?php } ?>
            
                <form method="POST" action="/Comment/store" class="comment-form">
                    <textarea name="text" placeholder="Escribe aquí tu comentario"></textarea>
                    <input type="hidden" name="iduser" value="<?= user()->id ?>">
                    <input type="hidden" name="idplace" value="<?= $place->id ?>">
                    <button type="submit" class="button" name="guardar">Añadir comentario</button>
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