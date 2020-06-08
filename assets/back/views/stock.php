<?php

function stock(){
	
	include "assets/back/dbconect/conect.php";

	?>

	<div class="body">
		<h1>Stock</h1>
		<table class="table">
		  <thead class="th-stock">
		    <tr>
		      <th>Codigo</th>
		      <th>Producto</th>
		      <th>Precio por unid.</th>
		      <th>Unidades Disponibles</th>
		      <th>Acciones</th>
		    </tr>
		  </thead>
		  <tbody>
	<?php
	$query = "SELECT * FROM `stock`;";
	$exe_query = $con->query($query);
	$i = 0;
	while ($row=$exe_query->fetch_assoc()) {
		?>
		    <tr class="fila<?=$i?>">
		      <th><?=$row['Codigo']?></th>
		      <td><?=$row['nombre']?></td>
		      <td><?=$row['precio unitario']?></td>
		      <td><?=$row['disponibles']?></td>
		      <td><a class="btn-update">Actualizar</a> <a class="btn-delete">Eliminar</a></td>
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
		<form>
			<div class="form-div">
			  <div class="label">
			    <span>Codigo</span>
			  </div>
			  <input type="text" class="form-input">
			</div>
			<div class="form-div">
			  <div class="label">
			    <span>Producto</span>
			  </div>
			  <input type="text" class="form-input">
			</div>
			<div class="form-div">
			  <div class="label">
			    <span>Precio Unitario</span>
			  </div>
			  <input type="number" class="form-input">
			</div>
			<div class="form-div">
			  <div class="label">
			    <span>Unidades Disponibles</span>
			  </div>
			  <input type="number" class="form-input">
			</div>
			<div class="btn-send">
				<a class="">Enviar</a>
			</div>
		</form>
	</div>
	<?php
}