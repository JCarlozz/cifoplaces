 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de productos - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Lista de productos') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Productos'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		
            <div>
                <h1><?= APP_NAME ?></h1>
                <h2>Lista completa de productos</h2>                	 
            </div>
        	<div>
            <?php if ($productos) { ?>
                <div class="right">
                    <?= $paginator->stats() ?>
                </div>
        
                <?php
                if ($filtro) {
                    echo $template->removeFilterForm($filtro, '/Producto/list');
                } else {
                    echo $template->filterForm(
                        [
                            'Titulo' => 'titulo',
                            'Descripción' => 'descripcion',
                            'Estado' => 'estado',
                            'Precio' => 'precio'
                        ],
                        [
                            'Titulo' => 'titulo',
                            'Descripción' => 'descripcion',
                            'Estado' => 'estado',
                            'Precio' => 'precio'
                        ],
                        'Titulo',
                        'Titulo'
                    );
                }?>
                </div>
                
                <!-- Tabla con los resultados -->
                                    
                    <section>                    
                    <?php foreach ($productos as $producto) { ?>
						<div class="centrado three-columns">
                        	<a href='/Producto/show/<?= $producto->id ?>'>
                            	<img src="<?= PRO_IMAGE_FOLDER . '/' . ($producto->foto ?? DEFAULT_PRO_IMAGE) ?>"
                                     class="table-image" alt="Portada de <?= $producto->titulo ?>"
                                     title="Portada de <?= $producto->titulo ?>"> </a>
                                <h2><?=$producto->titulo?></h2>
                                <p><?=$producto->estado?></p>
                                <p><?=$producto->precio?> €</p>
                           
                                                    
                
                                <!--<?php if (Login::oneRole(['ROLE_LIBRARIAN'])) { ?>
                                    <a class='button' href='/Producto/edit/<?= $producto->id ?>' title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a class='button' href='/Producto/delete/<?= $producto->id ?>' title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                <?php } ?>-->
                            
                        </div>
                    <?php } ?>
                </section>
        
                <?= $paginator->ellipsisLinks() ?>
            <?php } else { ?>
                <div class="danger p2">
                    <p>No hay productos que mostrar.</p>
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