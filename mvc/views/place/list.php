 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de lugares - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		<script src="js/BigPicture.js"></script>
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de lugares') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Lugares'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		
            <div>
                <h1><?= APP_NAME ?></h1>
                <h2>Lista completa de lugares</h2>                	 
            </div>
        	<div>
            <?php if ($places) { ?>
                <div class="right">
                    <?= $paginator->stats() ?>
                </div>
        
                <?php
                if ($filtro) {
                    echo $template->removeFilterForm($filtro, '/Place/list');
                } else {
                    echo $template->filterForm(
                        [
                            'Nombre'        => 'name',
                            'Tipo'          => 'type',
                            'Localización'  => 'location'
                        ],
                        [
                            'Nombre'        => 'name',
                            'Tipo'          => 'type',
                            'Localización'  => 'location'
                        ],
                        'Nombre',
                        'Nombre'
                    );
                }?>
                </div>
                   <?php  if(Login::user()->id == $user->id || Login::isAdmin()){?>  			
        				<a class="button" href="/Place/create/<?=user()->id?>">
        					Nuevo publicación
        				</a>
        			<?php } ?>                 
                <section class="flex-container-galeria">                    
                   <?php foreach ($places as $place) { ?>
						<div class="flex-item">
                        	<a href='/Place/show/<?= $place->id ?>'>
                            	<img src="<?= FOTO_IMAGE_FOLDER . '/' . ($place->mainpicture ?? DEFAULT_FOTO_IMAGE) ?>"
                                     class="centrado medium" alt="Portada de <?= $place->name ?>"
                                     title="Portada de <?= $place->name ?>"> 
                             <div class="descrip centrado">
                                <h2><?=$place->name?></h2>                                                                
                                <p><?=$place->location?></p>
                                <p><?=$place->type?></p>
                            </div></a>
                            
                        </div>
                    <?php } ?>
                </section>
        
                <?= $paginator->ellipsisLinks() ?>
            <?php } else { ?>
                <div class="danger p2">
                    <p>No hay lugares que mostrar.</p>
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