<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Portada - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Portada') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs() ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>    		
    		
    			<section class="flex-container-galeria">                    
                   <?php foreach ($places as $place) { ?>
						<div class="flex-inicio medium">                        	
                            	<img src="<?= FOTO_IMAGE_FOLDER . '/' . ($place->mainpicture ?? DEFAULT_FOTO_IMAGE) ?>"
                                     class="centrado medium" alt="Portada de <?= $place->name ?>"
                                     title="Portada de <?= $place->name ?>">                              
                            
                        </div>
                    <?php } ?>
                </section>
    		
        			    
		       
		</main>	
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

