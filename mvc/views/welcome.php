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
    		<div>
    			<p>Cifo Place es una aplicación web desarrollada como parte del curso de profesionalidad en desarrollo de aplicaciones web, 
    			diseñada para ofrecer una plataforma interactiva donde los usuarios pueden descubrir, compartir y comentar sobre distintos 
    			lugares de interés. Utilizando tecnologías modernas como FastLight(freamwork creado por el profesor del curso Robert Sallent), 
    			CCS, HTML5, PHP, MySQL y JavaScript, la aplicación permite a los usuarios registrar	ubicaciones, subir imágenes, dejar reseñas y 
    			gestionar su perfil de manera intuitiva. Este proyecto pone en práctica conceptos clave	de programación, bases de datos y diseño 
    			responsivo, proporcionando una experiencia realista en el desarrollo de software web.</p>
    			    		
    		</div>
    			<section class="flex-container-galeria">                    
                   <?php foreach ($places as $place) { ?>
						<div class="flex-inicio medium">
						<a href="/Place/show/<?= $place->id?>">                        	
                            	<img src="<?= FOTO_IMAGE_FOLDER . '/' . ($place->mainpicture ?? DEFAULT_FOTO_IMAGE) ?>"
                                     class="centrado medium" alt="Portada de <?= $place->name ?>"
                                     title="Portada de <?= $place->name ?>"></a>                             
                            
                        </div>
                    <?php } ?>
                </section>
    		
        			    
		       
		</main>	
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

