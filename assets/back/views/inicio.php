<?php

function inicio(){
	
	include "assets/back/dbconect/conect.php";

	$ventas = 0;
	$gastos = 0;
	$total = 0;

	?>

	<div class="body">
		<h1>Inicio</h1>
		<table class="table">
		  <thead class="th-stock">
		    <tr>
		      <th>Año</th>
		      <th>Mes</th>
		      <th>Ventas Totales</th>
		      <th>Gastos Totales</th>
		      <th>Ganancia Total</th>
		    </tr>
		  </thead>
		  <tbody>
	<?php
	$query = "SELECT * FROM `totales` ORDER BY `totales`.`año` ASC;";
	$exe_query = $con->query($query);
	$i = 0;
	while ($row=$exe_query->fetch_assoc()) {
		if ($row['total_neto'] < 0) {
			$i = 2;
		}elseif ($row['total_neto'] > 0){
			$i = 3;
		}else{
			$i = 1;
		}
		?>
		    <tr class="fila<?=$i?>">
		      <th><?=$row['año']?></th>
		      <td><?=$row['mes']?></td>
		      <td><?=$row['total_ventas']?></td>
		      <td><?=$row['total_gastos']?></td>
		      <td><?=$row['total_neto']?></td>
		    </tr>	
		<?php
		$ventas = $ventas + $row['total_ventas'];
		$gastos = $gastos + $row['total_gastos'];
		$total = $total + $row['total_neto'];
	}
		if ($total < 0) {
			$i = 2;
		}elseif ($total > 0){
			$i = 3;
		}else{
			$i = 1;
		}
	?>

			<tr class="">
		      <th></th>
		      <td></td>
		      <td><?=$ventas?></td>
		      <td><?=$gastos?></td>
		      <td><?=$total?></td>
		    </tr>	
		  </tbody>
		</table>
	</div>

	<?php
}

?>