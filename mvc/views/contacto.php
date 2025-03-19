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
		<link rel="shortcut icon" href="/logo.png" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Contacto') ?>
		<?= $template->menu() ?>		
		<?= $template->breadCrumbs([
		    'Contacto'=> NULL
		]) ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<div class="flex-container gap2">
    			<section class="flex1">
    				<h2>Contacto</h2>
    				<p>Utiliza el formulario de contacto para enviar un mensaje
    				al administrador de <?= APP_NAME?>.</p>
    				
    				<form method="POST" action="/Contacto/send">
    					<label>Email</label>
    					<input type="email" name="email" requiered value="<?= old('email')?>">
    					<br>
    					<label>Nombre</label>
    					<input type="text" name="nombre" requiered value="<?= old('nombre')?>">
    					<br>
    					<label>Asunto</label>
    					<input type="text" name="asunto" requiered value="<?= old('asunto')?>">
    					<br>
    					<label>Mensaje</label>
    					<textarea name="mensaje" requiered><?= old('mensaje')?></textarea>
    					<div class="centered mt2">
    						<input class="button" type="submit" name="enviar" value="Enviar">
    					</div>
    				</form>    			
    			</section>
    			<section class="flex1">
    				<h2>Ubicación y mapa</h2>
    				<div class="centrado big-card">
    				<iframe class="centrado" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2985.
    				6611261392572!2d2.058092!3d41.554934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.
    				1!3m3!1m2!1s0x12a493650ae03931%3A0xee4ac6c8e8372532!2sCentre%20d&#39;
    				Innovaci%C3%B3%20i%20Formaci%C3%B3%20Ocupacional%20(CIFO)%20de%20Sabadell!
    				5e0!3m2!1ses!2ses!4v1741106854028!5m2!1ses!2ses" style="border:0;" 
    				loading="lazy" referrerpolicy="no-referrer-when-downgrade">
    				</iframe>
    				</div>
    				
    				<h3>Datos</h3>
    				<p><b>Centre d'Innovació i Formació Ocupacional (CIFO) de Sabadell</b>
    					<p><b>N-150, km.15, 08227 Terrassa, Barcelona</b></p>
    					<p><b>937362910</b></p>
    				</p>    			
    			</section>
    		</div>        		
          </main>            
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>


