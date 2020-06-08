<?php
	include "assets/back/dbconect/rutas.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Contabilidad</title>

	<link rel="stylesheet" href="assets/css/st1.css">
</head>
<body>
	<div class="nav-slide bg-slide">
		<div class="title-slide">
			Kontab
		</div>
		<ul class="ul-slide">
			<li class="li-slide"><a href="index.php?page=inicio" title="inicio">Inicio</a></li>
			<li class="li-slide"><a href="index.php?page=stock" title="Stock">Stock</a></li>
			<?php /*for para los meses*/?>
		</ul>
	</div>

	<?php routes(); ?>
</body>
</html>