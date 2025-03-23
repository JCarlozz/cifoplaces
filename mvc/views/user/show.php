 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de usuarios - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Perfil usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Home'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		
		
    		<h1><?= APP_NAME ?></h1>
    		<a class="button" href="/User/edit/<?= $user->id?>">Editar</a>
    		<?php if(Login::user()->id == $user->id) {?>
    		<a class="button" href="/User/delete/<?= $user->id?>">Darme de baja</a>
    		<?php }?>
    		<section id="detalles" class="flex-container gap2">
    			<div class="flex2">
    			<h2><?=$user->displayname?></h2>
    			
    			
    			
    			<p><b>Nombre:</b>		<?=$user->displayname?></p>
    			
    			<p><b>Email:</b>		<?=$user->email?></p>
    			<p><b>Teléfono:</b>		<?=$user->phone?></p>    			
    			
    			<?php if(Login::isAdmin()) {?>
    			<p><b>Roles:</b> 		<?= implode(', ', $user->roles) ?></p>
    			<?php }?>
    			
    			</div>
    			<figure class="flex1 centrado p2">
        			<img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
        				class="cover enlarge-image" alt="Foto del usuario <?=$user->displayname?>">    					
        			<figcaption>Foto del usuario <?="$user->displayname"?></figcaption>
        			<?php if($user->picture) {?>
        			<form method="POST" action="/User/dropcover" class="no-border">
        				<input type="hidden" name="id" value="<?=$user->id?>">
        				<input type="submit" class="button-danger" name="borrar" value="Eliminar foto">
        			</form>
        			<?php } ?>	
        		</figure>    			
    		</section>    		
        		<section>
        									
        			 <h2>Publicaciones de <?= $user->displayname?></h2>
        				<?php  if(Login::user()->id == $user->id) {?>  			
        				<a class="button" href="/Place/create/<?=user()->id?>">
        					Nuevo publicación
        				</a>
        				<?php } ?> 
        				<?php 
        			 	if (!$places){ 
        				    echo "<div class='post p2'><p>No tienes publicaciones.</p></div>";
        				}else{ ?>    				
            				<table class="table w100 centered-block">
            					<tr>    					
            						<th>Título</th><th>Tipo</th><th>Localización</th><th>Operaciones</th>
            					</tr>        					
            				<?php foreach($places as $place){ ?>			     			     	
                				<tr>
                					<td><a href='/Place/show/<?= $place->id ?>'><?=$place->name?></td>
                					<td><?=$place->type?></td>
                					<td><?=$place->location?></td>
                					
                					<td class="centered">
                							<a class="button" href="/Place/show/<?= $place->id?>">Ver</a> 
                					  
                							<a class="button" href="/Place/edit/<?= $place->id?>">Editar</a> 
                							                                 
                                            <a class="button" href="/Place/delete/<?= $place->id ?>">Borrar</a>           
                                       
                                    </td>
                                                                   
                				</tr>            			
                			<?php } ?>
                			</table>
                			<?php } ?>
                			
                		
                	</section>
    		
    		    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>
    			<a class="button" href="/Place/list/">Lista de productos</a>
    			<?php  if(Login::user()->id ==  $user->id ){?>
    			<a class="button" href="/User/edit/<?= $user->id?>">Editar</a>
    			
    			<?php } ?>    		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>