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
                
                <section class="flex-container">
                	<div class="contenido">
                	<h1>Comparte</h1>
                	
                	<p>Compartir imágenes en CifoPlaces es una forma maravillosa de capturar y transmitir la 
                	esencia de los lugares que visitamos. A través de cada foto, los usuarios pueden mostrar 
                	rincones especiales, detalles únicos y momentos inolvidables que inspiran a otros a explorar 
                	y descubrir. Es una manera de conectar con la comunidad, revivir recuerdos y enriquecer la 
                	experiencia de quienes buscan nuevos destinos. Además, cada imagen contribuye a crear un mapa 
                	visual lleno de historias, colores y emociones, convirtiendo CifoPlaces en un espacio vivo 
                	donde la belleza de cada lugar cobra vida. 📸✨</p>
                	</div>
                    <div class="images centrado">
                    	<img class="flex-item"  src="/images/template/compartir.jpg" alt="Portada de compartir">
                   	</div>
                </section>
                
                <section class="flex-container">           	
                   	<div class="flex1 centrado">
                    	<img class="flex-item"  src="/images/template/amigos.jpg" alt="Portada de compartir">
                   	</div>
                   	
                	<div class="contenido">
                	<h1>Comunidad, ideas....</h1>
                	
                	<p>CifoPlaces nace con la intención de crear una comunidad vibrante donde los usuarios puedan 
                	compartir sus experiencias, ideas y viajes. Más que una simple plataforma, es un espacio para 
                	conectar con otros apasionados por la exploración, descubrir nuevos destinos y recomendar 
                	lugares únicos. Aquí, cada imagen, comentario y recomendación contribuye a enriquecer la 
                	experiencia de todos, fomentando el intercambio de conocimientos y aventuras. Ya sea para 
                	inspirar a otros, encontrar compañeros de viaje o simplemente compartir recuerdos, CifoPlaces 
                	es el punto de encuentro perfecto para quienes disfrutan descubriendo el mundo juntos. 🌍✨</p>
                	</div>
                	
                	
                    
                </section>
    		
        			    
		       
		</main>	
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

