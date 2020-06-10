<?php

function meses(){
	
	include "assets/back/dbconect/conect.php";

	?>

	<div class="body">
		<h1>meses</h1>
	<?php
	$query = "SELECT * FROM `meses` ORDER BY `meses`.`año` ASC;";
	$exe_query = $con->query($query);
	$i = '';
	$j =1;
	while ($mes=$exe_query->fetch_assoc()) {
		?>
		<h2 class="mes"><a class="mes" href="index.php?page=meses&mes=<?=$mes['mes']?>&year=<?=$mes['año']?>"><?=$mes['año']?> - <?=$mes['mes']?></a> | <a href="assets/back/dbconect/querys.php?query=6&cd=<?=$mes['id']?>&mes=<?=$mes['mes']?>&year=<?=$mes['año']?>" class="del-mes" title="">Eliminar</a></h2>
		<?php
	}

	?>
		<h2 class="subtit">Añadir Mes</h2>
		<div class="res">
			<p class="p-res"></p>
		</div>
		<form id="form-mes" role="form">
			<div class="form-div">
			  <div class="label">
			    <span>Año</span>
			  </div>
			  <input type="text" class="form-input" name="año">
			</div>
			<div class="form-div">
			  <div class="label">
			    <span>Mes</span>
			  </div>
			  <input type="text" class="form-input" name="mes">
			</div>
			<div class="btn-send" id="addMes">
				<p>Enviar</p>
			</div>
		</form>
	</div>
	<?php
}

function tabla_mes(){

	$mes = $_GET['mes'];
	$año = $_GET['year'];

	if (isset($_GET['error'])) {
		if ($_GET['error'] == "noDis") {
		?>
	<script>
		alert('Cantidad no disponible');
	</script>
		<?php
		}
	}
	
	include "assets/back/dbconect/conect.php";

	?>

	<div class="body">
		<h1><a class="mes" href="?page=meses"><i class="fas fa-arrow-circle-left"></i></a> <?=$año?> <?=$mes?></h1>
		<h2 class="mes">Ventas</h2>
		<table class="table">
		  <thead class="th-stock">
		    <tr>
		      <th>id</th>
		      <th>Producto</th>
		      <th>Cantidad</th>
		      <th>Precio Unitario</th>
		      <th>Fecha</th>
		      <th>Total</th>
		      <th>Acciones</th>
		    </tr>
		  </thead>
		  <tbody>
	<?php
	$query = "SELECT * FROM `Ventas $año - $mes` ORDER BY `Ventas $año - $mes`.`id` ASC;";
	$exe_query = $con->query($query);
	$i = 0;
	while ($row=$exe_query->fetch_assoc()) {
		?>
		    <tr class="fila<?=$i?>">
		      <th><?=$row['id']?></th>
		      <td><?=$row['prod']?></td>
		      <td><?=$row['cantidad']?></td>
		      <td><?=$row['precio_unitario']?></td>
		      <td><?=$row['fecha']?></td>
		      <td><?=$row['neto']?></td>
		      <td><a href="assets/back/dbconect/querys.php?query=5&cd=<?=$row['id']?>&year=<?=$año?>&month=<?=$mes?>" class="btn-delete" id="del">Eliminar</a></td>
		    </tr>
		<?php
		if ($i == 0) {
			$i = 1;
		}else{
			$i = 0;
		}
	}
	?>
		  </tbody>
		</table>
				<h2 class="subtit">Nuevo Producto</h2>
		<div class="res">
			<p class="p-res"></p>
		</div>
		<?php

		?>
		<form id="form-venta" method="post" action="assets/back/dbconect/querys.php?query=4&year=<?=$año?>&month=<?=$mes?>" role="form">
			<div class="form-div">
			  <div class="label">
			    <span>producto</span>
			  </div>
			  <select class="form-input" name="prod" required>
					<option value=""> --- </option>
				<?php
					$prod = "SELECT * FROM `stock`;";

					$exe_prod = $con->query($prod);

					while($prod = $exe_prod->fetch_assoc()){
						if ($prod['disponibles'] > 0) {
							?>
						<option value="<?=$prod['Codigo']?>" onclick=""><?=$prod['Codigo']." - ".$prod['nombre']." - ".$prod['disponibles']?></option>
							<?php
						}
					}
				?>
			  </select>
			</div>
			<div class="form-div">
			  <div class="label">
			    <span>Cantidad</span>
			  </div>
			  <input type="number" min="0" max="1000" class="form-input" name="cant" required>
			</div>
			<input type='submit' class="btn-send2" id="venta" value="Registrar Venta">
		</form>
		<h2 class="mes">Gastos</h2>
		<h2 class="mes">Total</h2>
	</div>
	<?php
}

/*INSERT INTO `ventas 2020 - junio`(`id`, `prod`, `cantidad`, `precio_unitario`, `fecha`, `neto`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])*/