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
		$query = "SELECT * FROM `stock` ORDER BY `stock`.`Codigo` ASC;";
		$exe_query = $con->query($query);
		$i = 0;
		while ($row=$exe_query->fetch_assoc()) {
			?>
				<tr class="fila<?=$i?>">
				<th><?=$row['Codigo']?></th>
				<td><?=$row['Nombre']?></td>
				<td><?=$row['Precio']?></td>
				<td><?=$row['Disponibles']?></td>
				<td><a href="assets/back/dbconect/querys.php?query=2&cd=<?=$row['Codigo']?>" class="btn-delete" id="del">Eliminar</a></td>
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
			<form id="form-add" role="form">
				<div class="form-div">
					<div class="label">
						<span>Codigo</span>
					</div>
					<input type="text" class="form-input" name="code">
				</div>
				<div class="form-div">
					<div class="label">
						<span>Producto</span>
					</div>
					<input type="text" class="form-input" name="prod">
				</div>
				<div class="form-div">
					<div class="label">
						<span>Precio Unitario</span>
					</div>
					<input type="number" class="form-input" name="price">
				</div>
				<div class="form-div">
					<div class="label">
						<span>Unidades Disponibles</span>
					</div>
					<input type="number" class="form-input" name="units">
				</div>
				<div class="btn-send" id="add">
					<p>Enviar</p>
				</div>
			</form>
		</div>
	<?php
	}