 <!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Borrar usuario <?$user->id?> - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Borrar usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Usuario'=> 'list',
		    $user->displayname =>'nombre',
		    'Borrar'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Borrar usuario <?=$user->displayname?></h2>
    		
    		<form method="POST" class="centered m2" action="/User/destroy">
				<p>Confirmar el borrado del usuario <b><?=$user->displayname?></b>.</p>
    			    			
    			<input type="hidden" name="id" value="<?=$user->id?>">
    			<input class="button-danger" type="submit" name="borrar" value="Borrar">
    		</form>    	
    				
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/User/list">Lista de socios</a>
				<a class="button" href="/User/show/<?=$user->id?>">Detalles</a>
				<a class="button" href="/User/edit/<?=$user->id?>">Edición</a>
			</div>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>	
	</body>
</html>
