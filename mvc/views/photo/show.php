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
		    'Lugar'=> '/Place/show/$id',
		    $photo->name =>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		
		
    		<h1><?= APP_NAME ?></h1>    		
    		
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
        			<?php  if(Login::user()->id ==  $comment->iduser){?>
        			<form method="POST" action="/Photo/dropcover" class="no-border">
        				<input type="hidden" name="id" value="<?=$photo->id?>">
        				<input type="hidden" name="id" value="<?=$photo->id?>">
        				<input type="submit" class="button-danger" name="borrar" value="Eliminar foto">
        			</form>
        			<?php } ?>
        			<?php } ?>	
        		</figure>    			
    		</section>	
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
                                    <p class="comment-author"><?= $comment->username ?></p>
                                    <p class="comment-text"><?= $comment->text ?></p>
                                    <p class="comment-text"><?= $comment->created_at ?></p>
                                    
                                </div>
                                <?php  if(Login::user()->id ==  $comment->iduser || Login::isAdmin() ){?>
                                <div class="comment-actions">
                                    <form method="POST" action="/Comment/destroy">
                                    	<input type="hidden" name="iduser" value="<?= user()->id ?>">
                                        <input type="hidden" name="id" value="<?= $comment->id ?>">
                                        <button type="submit" class="button small" name="borrar" >Eliminar</button>
                                    </form>
                                </div>
                                <?php }?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <p class="no-comments">No hay comentarios aún. ¡Sé el primero en comentar!</p>
                <?php } ?>
            
                <form method="POST" action="/Comment/storephoto" class="comment-form">
                    <textarea name="text" placeholder="Escribe aquí tu comentario"></textarea>
                    <input type="hidden" name="iduser" value="<?= user()->id ?>">
                    <input type="hidden" name="idphoto" value="<?= $photo->id ?>">
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