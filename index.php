<?php
	include "assets/back/dbconect/rutas.php";
	$vistas = array('inicio', 'stock', 'meses');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Contabilidad</title>
	<!-- Font Awesome -->
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.2/css/all.css'>
	<link rel="stylesheet" href="assets/css/st1.css">
</head>
<body>
	<div class="nav-slide bg-slide">
		<div class="title-slide">
			Kontab
		</div>
		<ul class="ul-slide">
			<?php
				foreach ($vistas as $vistas) {
				?>
					<li class="li-slide"><a href="index.php?page=<?=$vistas?>" title="<?=$vistas?>"><?=$vistas?></a></li>
				<?php
				}
			?>
		</ul>
	</div>

	<?php routes(); ?>
	<!-- ajax -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <!-- JQuery -->
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
	<script src="assets/js/script.js" type="text/javascript"></script>
</body>
</html>