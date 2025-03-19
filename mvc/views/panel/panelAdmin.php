<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Panel del administrador - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Panel del administrador') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Panel del administrador'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<?php if(Login::isAdmin()) {?>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Panel del administrador</h2>
    		
    		<p>Aquí encontrarás los enlaces a las distintas operaciones
    		para el administrador de la aplicación "CifoMarket".</p>
			
			<div class="flex-container gap2">
				<section class="flex1">
					<h2>Operaciones con usuarios</h2>
					<ul>
						<li><a href='/User'>Lista de usuarios</a></li>
						<li><a href='/User/create'>Nuevo usuarios</a></li>
					</ul>				
				</section>			
			</div>  
			<?php }?>  		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>
