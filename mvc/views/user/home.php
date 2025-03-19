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
    		<h2>Home usuario</h2>    		
    		
    		<section class="flex-container" id="user-data">
    			<div class="flex2">
    				<h2><?="Home de $user->displayname"?></h2>
    				
    				<p><b>Nombre:</b>				<?=$user->nombreyapellido?><p>
    				<p><b>Email:</b>				<?=$user->email?><p>
    				<p><b>Teléfono:</b>				<?=$user->phone?><p>
    				<p><b>Fecha de alta:</b>		<?=$user->created_at?><p>
    				<p><b>Última modificación:</b>	<?=$user->updated_at ?? '--'?><p>
    				
    			</div>
    			<!-- Esta parte solamente si creáis la carpeta para las fotos de perfil-->
    			<figure class="flex1 centrado">
    				<img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
    					class="cover enlarge-image" alt="Imagen de perfil de <?= $user->nombreyapellido ?>">
    				<figcaption>Imagen de perfil de <?=$user->nombreyapellido?></figcaption>    						
    			</figure>    		
    		</section>
    		
		  
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>
