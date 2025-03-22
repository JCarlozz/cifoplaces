 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de usuarios - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Carlos Carceller">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de usuarios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lista de Usuarios'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			
    		<?php if ($users) { ?>
    		
    		<div class="right">
    			<?= $paginator->stats() ?>
    		</div>
    		
    		<?php 
    		if($filtro){
    		    echo $template->removeFilterForm($filtro, '/User/list');
    		    
    		}else{
    		    echo $template->filterForm(
    		        [
    		            'Nombre'=>'displayname',
                        'Email'=>'email',
    		            'Teléfono'=>'phone'
    		        ],
    		        [
    		            'Nombre'=>'displayname',
    		            'Email'=>'email',
    		            'Teléfono'=>'phone'    		                		            
    		        ],
    		        'Nombre',
    		        'Nombre'    		        
    		        );   		
    		  } ?>
    		 			
    			<table class="table w100">
    				<tr>
    					<th>Imagen</th>
    					<th>Nombre</th>
    					<th>Email</th>
    					<th>Teléfono</th>
    					<th>Roles</th>
    					<th>Bloqueado</th>
    					<th class="centrado">Operaciones</th>
    				</tr>
    			<?php foreach ($users as $user){?>    			
    				<tr>
    					<td class="centrado">
    						<a href='/User/show/<?=$user->id?>'>
    							<img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
    								class="table-image" alt="Portada de <?= $user->displayname ?>"
    								title="Portada de <?= $user->displayname ?>">    						
    						</a>
    					</td>
    					<td><a href='/User/show/<?= $user->id ?>'><?=$user->displayname?></a></td>
    					<td><?= $user->email ?></td>
    					<td><?= $user->phone ?></td>
    					<td><?= implode(', ', $user->roles); ?></td>
    					<td><?= $user->blocked_at ?></td>
    					<td class="centrado">
    						<a class='button' href='/User/show/<?= $user->id ?>'title="Ver">
    							<i class="fas fa-eye"></i></a> -
    						<a class='button' href='/User/edit/<?= $user->id ?>'title="Editar">
    							<i class="fas fa-edit"></i></a>
    					</td>
    				</tr>
    			<?php } ?>    			
    			</table>
    			<?= $paginator->ellipsisLinks() ?>
    			<?php }else{?>
    				<div class="danger p2">
    					<p>No hay usuarios que mostrar.</p>
    				</div>
    			<?php } ?>
    			
    			<div class="centred">
    				<a class="button" onclick="history.back()">Atrás</a>
    			</div>
    		
    		
    		
		</main>
		
		<?= $template->footer() ?>
		<?= $template->version() ?>	
			
	</body>
</html>