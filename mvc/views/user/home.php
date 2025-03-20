 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Home usuario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		<script src="/js/BigPicture.js"></script>
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Home usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Home'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		
		
    		<h1><?= APP_NAME ?></h1>
    		
    		<a class="button" href="/User/edit/<?= $user->id?>">Editar</a>
    		<a class="button" href="/User/delete/<?= $user->id?>">Darme de baja</a>
    		
    		<section id="detalles" class="flex-container gap2">
    			<div class="flex2">
    			<h2><?=$user->displayname?></h2>
    			
    			
    			
    			<p><b>Nombre:</b>				<?=$user->displayname?></p>
    			
    			<p><b>Email:</b>				<?=$user->email?></p>
    			<p><b>Teléfono:</b>				<?=$user->phone?></p>
    			<p><b>Fecha de alta:</b>		<?=$user->created_at?><p>
    			<p><b>Última modificación:</b>	<?=$user->updated_at ?? '--'?><p>    			
    			
    			<p><b>Roles:</b> 				<?= implode(', ', $user->roles) ?></p>  			
    			
    			</div>
    			<figure class="flex1 centrado p2">
        			<img src="<?=USERS_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USERS_IMAGE)?>"
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
    									
    			 <h2>Productos de <?= $user->displayname?></h2>
    							
    				<a class="button" href="/Producto/create/<?=$producto->idusers?>">
    					Nuevo producto
    				</a>
    				
    				<?php 
    			 	if (!$productos){
    				    echo "<div class='warning p2'><p>No tienes productos a la venta.</p></div>";
    				}else{ ?>    				
        				<table class="table w100 centered-block">
        					<tr>    					
        						<th>Imagen</th><th>Título</th><th>Precio</th><th>Estado</th><?php  if(lOGIN::user()->id ==  $user->id ){?><th>Operaciones</th><?php }?>
        					</tr>        					
        				<?php foreach($productos as $producto){ ?>			     			     	
            				<tr>
            					<td>
            						<figure>
    									<img src="<?=PRO_IMAGE_FOLDER.'/'.($producto->foto ?? DEFAULT_PRO_IMAGE)?>"
    									class="small" id="preview-image" alt="Previsualización de la imagen">    				
    								</figure>
    							</td>
            					<td><a href='/Producto/show/<?= $producto->id ?>'><?=$producto->titulo?></td>
            					<td><?=$producto->precio?></td>
            					<td><?=$producto->estado?></td>
            					<?php  if(Login::user()->id ==  $user->id ){?>
            					<td class="centered">  
            							<a class="button" href="/Producto/edit/<?= $producto->id?>">Editar</a> 
            							                                 
                                        <a class="button" href="/Producto/delete/<?= $producto->id ?>">Borrar</a>           
                                   
                                </td>
                                <?php } ?>                                
            				</tr>            			
            			<?php } ?>
            			<?php } ?>
            			</table>
            		
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
