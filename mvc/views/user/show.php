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
		    'Usuarios'=> '/user',
		    $user->nombreyapellidos =>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		
		
    		<h1><?= APP_NAME ?></h1>
    		<?php  if(Login::user()->id ==  $user->id || Login::isAdmin() ){?>
    		<a class="button" href="/User/edit/<?= $user->id?>">Editar</a>
    		<?php }?>
    		<section id="detalles" class="flex-container gap2">
    			<div class="flex2">
    			<h2><?=$user->nombreyapellidos?></h2>
    			
    			
    			
    			<p><b>Nombre:</b>		<?=$user->nombreyapellidos?></p>
    			<?php if(Login::check()) { ?>
    			<p><b>Email:</b>		<?=$user->email?></p>
    			<p><b>Teléfono:</b>		<?=$user->phone?></p>
    			<p><b>Ciudad:</b>		<?=$user->poblacion?></p>
    			<p><b>Provincia:</b>	<?=$user->provincia?>
    			<p><b>Dirección:</b>	<?=$user->direccion?></p>
    			<?php } ?>
    			
    			<?php  if(Login::isAdmin()){?>
    			<p><b>Roles:</b> 		<?= implode(', ', $user->roles) ?></p>
    			<?php } ?>
    			
    			</div>
    			<figure class="flex1 centrado p2">
        			<img src="<?=USER_IMAGE_FOLDER.'/'.($user->foto ?? DEFAULT_USER_IMAGE)?>"
        				class="cover enlarge-image" alt="Foto del usuario <?=$user->nombreyapellidos?>">    					
        			<figcaption>Foto del usuario <?="$user->nombreyapellidos"?></figcaption>
        			<?php if($user->foto) {?>
        			<form method="POST" action="/User/dropcover" class="no-border">
        				<input type="hidden" name="id" value="<?=$user->id?>">
        				<input type="submit" class="button-danger" name="borrar" value="Eliminar foto">
        			</form>
        			<?php } ?>	
        		</figure>    			
    		</section>
    		
    		<section>
    									
    			 <h2>Productos de <?= $user->nombreyapellidos?></h2>
    				<?php  if(Login::user()->id ==  $user->id ){?>  			
    				<a class="button" href="/Producto/create/<?=$producto->idusers?>">
    					Nuevo producto
    				</a>
    				<?php } ?>
    				<?php 
    			 	if (!$productos){
    				    echo "<div class='warning p2'><p>No tienes productos a la venta.</p></div>";
    				}else{ ?>    				
        				<table class="table w100 centered-block">
        					<tr>    					
        						<th>Título</th><th>Precio</th><th>Estado</th><?php  if(lOGIN::user()->id ==  $user->id ){?><th>Operaciones</th><?php }?>
        					</tr>        					
        				<?php foreach($productos as $producto){ ?>			     			     	
            				<tr>
            					<td><a href='/Producto/show/<?= $producto->id ?>'><?=$producto->titulo?></td>
            					<td><?=$producto->precio?></td>
            					<td><?=$producto->estado?></td>
            					<?php  if(lOGIN::user()->id ==  $user->id ){?>
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