 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo foto - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Nuevo foto') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Nuevo foto'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		  	<h1>Nuevo usuario en <?= APP_NAME ?></h1>
    		   		
    		<section id="new-user">
    			<h2>Nuevo foto</h2>
    			
    			<div class="flex-container">
    				<form method="post" action="/Photo/store" enctype="multipart/form-data"
    					class="flex2 no-border">
    					
    					<input type="hidden" name="idplace" value="<?= $idplace ?>">
    					<input type="hidden" name="idusers" value=<?=user()->id?>>
    					<label>Nombre</label>
    					<input type="text" name="name" value="<?= old('name')?>">
    					<br>
    					<label>Lugar</label>
    					<input type="text" name="alt" value="<?= old('alt')?>">
    					<br>
    					<label>Descrpción</label>
    					<input type="text" name="description" value="<?= old('description')?>">
    					<br>
    					<label>Fecha</label>
    					<input type="date" name="date" value="<?= old('date')?>">
    					<br>
    					<label>Hora</label>
    					<input type="time" name="time" value="<?= old('time')?>">
    					<br>    					   					
    					<label>Imagen</label>
    					<input type="file" name="file" accept="image/*" id="file-with-preview">
    					<br>		
    					
    					
    						<div class="centered mt3">
    							<input type="submit" class="button" name="guardar" value="Guardar">
    						</div>
    						
    					</form>
    				</div>   
    		<div class="flex-container">					
    			<figure class="flex1 centrado">
    				<img src="<?=FOTO_IMAGE_FOLDER.'/'.($photo->file ?? DEFAULT_FOTO_IMAGE)?>"
    				class="cover" id="preview-image" alt="Previsualización de la imagen">
    				<figcaption>Previsualización de la imagen</figcaption>    						
    			</figure>
    		</div> 
    		</section>
    		
    			   				
    					  
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>

