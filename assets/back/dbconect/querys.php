<?php

	include "conect.php";

	if (isset($_GET['query'])) {

		$query = $_GET['query'];

		if ($query == "1") {
			// ------------------------- aqui se insertan los productos del stock ------------------------

			$codigo = $_POST['code'];
			$producto = $_POST['prod'];
			$precio = $_POST['price'];
			$cantidad = $_POST['units'];

			$add = "INSERT INTO `stock`(`Codigo`, `nombre`, `precio unitario`, `disponibles`) VALUES ('$codigo', '$producto', '$precio', '$cantidad');";
			$exe_add = $con->query($add);

			echo json_encode(array('msg' => "add"));
		}elseif ($query == "2") {
			// ------------------------- aqui se eliminan los productos del stock ------------------------

			$codigo = $_GET['cd'];
			$del = "DELETE FROM `stock` WHERE codigo = '$codigo';";
			$exe_del = $con->query($del);

			header("location: ../../../?page=stock");
		}elseif($query == "3"){
			// ------------------------- aqui se crea la vista del mes ------------------------

			$year = $_POST['año'];
			$mes = $_POST['mes'];

			$add = "INSERT INTO `meses`(`id`, `año`, `mes`) VALUES (NULL, '$year', '$mes');";

			$exe_add = $con->query($add);

			$crear_mes = "CREATE TABLE `contabilidad_local`.`Ventas $year - $mes` ( `prod` VARCHAR(30) NOT NULL , `cantidad` INT(5) NOT NULL , `precio_unitario` FLOAT NOT NULL , `fecha` TIMESTAMP NOT NULL , `neto` FLOAT NOT NULL , `id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

			$exe_crear_mes = $con->query($crear_mes);

			$crear_mes = "CREATE TABLE `contabilidad_local`.`Gastos $year - $mes` ( `prod` VARCHAR(30) NOT NULL , `cantidad` INT(5) NOT NULL , `fecha` TIMESTAMP NOT NULL , `neto` FLOAT NOT NULL , `id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

			$exe_crear_mes = $con->query($crear_mes);

			echo json_encode(array('msg' => "add"));
		}elseif($query == "4"){
			// ------------------------- aqui se insertan los datos de las ventas en la base de datos ------------------------
			$prod = $_POST['prod'];
			$cant = $_POST['cant'];
			$year = $_GET['year'];
			$month =$_GET['month'];

			$reg = "SELECT * FROM `stock` WHERE `Codigo` = '$prod';";

			$exe_reg =$con->query($reg);

			while ($prods=$exe_reg->fetch_assoc()){
				$dis = $prods['disponibles'];

				if ($dis < $cant ) {
					header("location: ../../../?page=meses&mes=".$month."&year=".$year."&error=noDis");
					$error = "True";
				}else{
					$error = "False";
					$name = $prods['nombre'];
					$unit = $prods['precio unitario'];
				}
			}

			if ($error == "False") {
				
				$tot = $unit * $cant;

				$dispo = $dis - $cant;

				$update = "UPDATE `stock` SET `disponibles` = '$dispo' WHERE `stock`.`Codigo` = '$prod';";

				$exe_update = $con->query($update);

				$venta = "INSERT INTO `ventas $year - $month`(`prod`, `cantidad`, `precio_unitario`, `fecha`, `neto`, `id`) VALUES ('$name','$cant','$unit',current_timestamp(),'$tot', NULL);";

				$exe_venta = $con->query($venta);

				echo json_encode(array('msg' => "add"));

				header("location: ../../../?page=meses&mes=".$month."&year=".$year);			
			}

		}elseif($query == "5"){
			// ------------------------- aqui se eliminan las ventas ------------------------
			$year = $_GET['year'];
			$month =$_GET['month'];
			if (isset($_GET['cd'])) {
				$cd = $_GET['cd'];

				$get = "SELECT * FROM `ventas $year - $month` WHERE `ventas $year - $month`.`id` = '$cd';";
				$exe_get = $con->query($get);

				while ($data=$exe_get->fetch_assoc()){
					$dis = $data['cantidad'];
					$name = $data['prod'];
				}

				$get = "SELECT * FROM `stock` WHERE `stock`.`nombre` = '$name';";
				$exe_get = $con->query($get);

				while ($data=$exe_get->fetch_assoc()){
					$dispo = $data['disponibles'];
					$code = $data['Codigo'];
				}

				$disp = $dispo + $dis;

				$update = "UPDATE `stock` SET `disponibles` = '$disp' WHERE `stock`.`Codigo` = '$code';";

				$exe_update = $con->query($update);

				$del = "DELETE FROM `ventas $year - $month` WHERE `ventas $year - $month`.`id` = '$cd';";
				$exe_del = $con->query($del);

				$ai = "ALTER TABLE `ventas $year - $month` auto_increment = 1;";
				$exe_ai = $con->query($ai);

				header("location: ../../../?page=meses&mes=".$month."&year=".$year);
			}else{
				header("location: ../../../?page=meses&mes=".$month."&year=".$year);
			}
		}elseif($query == "6"){
			// ------------------------- aqui se eliminan las vistas de los meses ------------------------
			$cd = $_GET['cd'];
			$year = $_GET['year'];
			$month =$_GET['mes'];

			$del = "DELETE FROM `meses` WHERE `id` = '$cd';";
			$exe_del = $con->query($del);

			$drop1 = "DROP TABLE `contabilidad_local`.`ventas $year - $month`";
			$exe_drop1 = $con->query($drop1);

			$drop2 = "DROP TABLE `contabilidad_local`.`Gastos $year - $month`";
			$exe_drop1 = $con->query($drop2);

			$ai = "ALTER TABLE `meses` auto_increment = 1;";
			$exe_ai = $con->query($ai);

			header("location: ../../../?page=meses");
		}elseif($query == "7"){
			// ------------------------- aqui se insertan los gastos ------------------------
			
			$year = $_GET['year'];
			$month =$_GET['month'];
			$producto = $_POST['prod'];
			if ($_POST['cant'] == 0) {
				$cant = 1;
			}else{
				$cant = $_POST['cant'];
			}
			$precio = $_POST['price'];
			$total = $cant * $precio;

			$add = "INSERT INTO `gastos $year - $month`(`prod`, `cantidad`, `fecha`, `neto`, `id`) VALUES ('$producto', '$cant', current_timestamp(), '$total', NULL);";
			$exe_add = $con->query($add);

			header("location: ../../../?page=meses&mes=".$month."&year=".$year);
		}elseif($query == "8"){
			// ------------------------- aqui se eliminan los gastos ------------------------
			$year = $_GET['year'];
			$month =$_GET['month'];
			if (isset($_GET['cd'])) {
				$cd = $_GET['cd'];

				$del = "DELETE FROM `gastos $year - $month` WHERE `gastos $year - $month`.`id` = '$cd';";
				$exe_del = $con->query($del);

				$ai = "ALTER TABLE `gastos $year - $month` auto_increment = 1;";
				$exe_ai = $con->query($ai);

				header("location: ../../../?page=meses&mes=".$month."&year=".$year);
			}else{
				header("location: ../../../?page=meses&mes=".$month."&year=".$year);
			}
		}elseif($query == "9"){
			// ------------------------- aqui se eliminan los gastos ------------------------
			$year = $_GET['year'];
			$month =$_GET['month'];

			$query = "SELECT * FROM `ventas $year - $month`;";
			$exe_query = $con->query($query);

			$query2 = "SELECT * FROM `gastos $year - $month`;";
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

			$query3 = "SELECT * FROM `totales` WHERE `año` = '$year' AND `mes` = '$month';";
			$exe_query3 = $con->query($query3);

			$i = 0;

			while ($gastos=$exe_query3->fetch_assoc()){
				$i = $i + 1;
			}
			
			$total = $ventas_total + (-$gastos_total);

			if ($i == 0) {

				$add = "INSERT INTO `totales`(`id`, `año`, `mes`, `total_ventas`, `total_gastos`, `total_neto`) VALUES (NULL, '$year', '$month', '$ventas_total', '$gastos_total', '$total');";
				$exe_add = $con->query($add);

				header("location: ../../../?page=meses&mes=".$month."&year=".$year);
			}else{
				$update = "UPDATE `totales` SET `total_ventas` = '$ventas_total', `total_gastos` = '$gastos_total', `total_neto` = '$total' WHERE `año` = '$year' AND `mes` = '$month';";
				$exe_update = $con->query($update);
				header("location: ../../../?page=inicio");
			}
		}
	}else{
		echo json_encode(array('msg' => "No ha especificado la consulta"));
	}

?>