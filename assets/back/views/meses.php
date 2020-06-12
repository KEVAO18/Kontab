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
		<!------------------------------------- ventas --------------------------------->
		<h2 class="mes">Ventas</h2>
		<table class="table">
		  <thead class="th-stock">
		    <tr>
		      <th>#</th>
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
				<h2 class="subtit">Añadir Venta</h2>
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
		<!------------------------------------- Gastos --------------------------------->
		<h2 class="mes">Gastos</h2>
		<table class="table">
		  <thead class="th-stock">
		    <tr>
		      <th>#</th>
		      <th>Producto</th>
		      <th>Cantidad</th>
		      <th>Fecha</th>
		      <th>Total</th>
		      <th>Acciones</th>
		    </tr>
		  </thead>
		  <tbody>
	<?php
	$query = "SELECT * FROM `gastos $año - $mes` ORDER BY `gastos $año - $mes`.`id` ASC;";
	$exe_query = $con->query($query);
	$i = 0;
	while ($row=$exe_query->fetch_assoc()) {
		?>
		    <tr class="fila<?=$i?>">
		      <th><?=$row['id']?></th>
		      <td><?=$row['prod']?></td>
		      <td><?=$row['cantidad']?></td>
		      <td><?=$row['fecha']?></td>
		      <td><?=$row['neto']?></td>
		      <td><a href="assets/back/dbconect/querys.php?query=8&cd=<?=$row['id']?>&year=<?=$año?>&month=<?=$mes?>" class="btn-delete" id="del">Eliminar</a></td>
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
				<h2 class="subtit">Añadir gasto</h2>
		<div class="res">
			<p class="p-res"></p>
		</div>
		<?php

		?>
		<form id="form-gastos" method="post" action="assets/back/dbconect/querys.php?query=7&year=<?=$año?>&month=<?=$mes?>" role="form">
			<div class="form-div">
			  <div class="label">
			    <span>producto</span>
			  </div>
			  <input type="text" class="form-input" name="prod" required>
			</div>
			<div class="form-div">
			  <div class="label">
			    <span>Cantidad</span>
			  </div>
			  <input type="number" min="0" max="1000" class="form-input" name="cant" required>
			</div>
			<div class="form-div">
			  <div class="label">
			    <span>Precio</span>
			  </div>
			  <input type="number" min="0" class="form-input" name="price" required>
			</div>
			<input type='submit' class="btn-delete2" id="gastos" value="Registrar Gasto">
		</form>
		<!------------------------------------- total --------------------------------->
		<h2 class="mes">Total</h2>
		<table class="table">
		  <thead class="th-stock">
		    <tr>
		      <th># de Ventas</th>
		      <th>Total de Ventas</th>
		      <th># de Gastos</th>
		      <th>Total de Gastos</th>
		      <th>Fecha</th>
		      <th>Ganancia Neta</th>
		      <th>Acciones</th>
		    </tr>
		  </thead>
		  <tbody>
	<?php
	$query = "SELECT * FROM `ventas $año - $mes`;";
	$exe_query = $con->query($query);

	$query2 = "SELECT * FROM `gastos $año - $mes`;";
	$exe_query2 = $con->query($query2);
	$ventas_cant = 0;
	$ventas_total = 0;
	$gastos_cant = 0;
	$gastos_total = 0;
	while ($ventas=$exe_query->fetch_assoc()){
		$ventas_cant = $ventas_cant + 1;
		$ventas_total = $ventas_total + $ventas['neto'];
	}
	while ($gastos=$exe_query2->fetch_assoc()){
		$gastos_cant = $gastos_cant + 1;
		$gastos_total = $gastos_total + $gastos['neto'];
	}

	$total = $ventas_total + (-$gastos_total);

	$i = 0;
	if ($total > 0) {
		$i = 3;
	}elseif ($total == 0) {
		$i = 1;
	}else{
		$i = 2;
	}
		?>
		    <tr class="fila<?=$i?>">
		      <th><?=$ventas_cant?></th>
		      <td><?=$ventas_total?></td>
		      <td><?=$gastos_cant?></td>
		      <td><?=$gastos_total?></td>
		      <td><?=date('d/m/Y')?></td>
		      <td><?=$total?></td>
		      <td><a class="btn-send" style="margin: auto; text-decoration: none;" href="assets/back/dbconect/querys.php?query=9&year=<?=$año?>&month=<?=$mes?>">añadir al libro</a></td>
		    </tr>
		  </tbody>
		</table>
	</div>
	<?php
}