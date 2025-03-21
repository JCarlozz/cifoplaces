 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo usuario - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		<script src="/js/Preview.js"></script>
		<!-- CSS -->
		<?= $template->css() ?>
		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Nuevo usuario'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		  	<h1>Nuevo usuario en <?= APP_NAME ?></h1>
    		   		
    		<section id="new-user">
    			<h2>Nuevo usuario</h2>
    			
    			<div class="flex-container">
    				<form method="post" action="/User/store" enctype="multipart/form-data"
    					class="flex2 no-border">
    					
    					<label>Nombre</label>
    					<input type="text" name="displayname" value="<?= old('displayname')?>">
    					<br>
    					<label>Email</label>
    					<input type="email" name="email" id="email" value="<?= old('email')?>">
    					<output id="comprobacion" class="mini"></output>
    					<br>
    					<label>Teléfono</label>
    					<input type="text" name="phone" id="phone" value="<?= old('phone')?>">
    					<output id="comprobacionphone" class="mini"></output>
    					<br>    					
    					<label>Password</label>
    					<input type="password" name="password" value="<?= old('password')?>">
    					<br>
    					<label>Repetir</label>
    					<input type="password" name="repeatpassword" value="<?= old('repeatpassword')?>">
    					<br>
    					<label>Imagen de perfil</label>
    					<input type="file" name="picture" accept="image/*" id="file-with-preview">
    					<br>
    					<?php if(Login::isAdmin()) {?>
    					<label>Rol</label>
    					
    					<select name="roles">
    						<?php foreach (USER_ROLES as $roleName =>$roleValue){ ?>
    							<option value="<?=$roleValue ?>"><?=$roleName?></option>
    						<?php } ?>
    					</select>
    					<?php } ?>
    						<div class="centered mt3">
    							<input type="submit" class="button" name="guardar" value="Guardar">
    							<input type="reset" class="button" value="Reset">
    						</div>
    					</form>
    				   
    							
    			<figure class="flex4 centrado">
    				<img src="<?=USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE)?>"
    				class="cover" id="preview-image" alt="Previsualización de la imagen de perfil">
    				<figcaption>Previsualización de la imagen de perfil</figcaption>    						
    			</figure>
    		 </div>
    		</section>
    		
    			   				
    					  
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>

