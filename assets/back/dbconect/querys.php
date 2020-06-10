<?php

	include "conect.php";

	if (isset($_GET['query'])) {

		$query = $_GET['query'];

		if ($query == "1") {

			$codigo = $_POST['code'];
			$producto = $_POST['prod'];
			$precio = $_POST['price'];
			$cantidad = $_POST['units'];

			$add = "INSERT INTO `stock`(`Codigo`, `nombre`, `precio unitario`, `disponibles`) VALUES ('$codigo', '$producto', '$precio', '$cantidad');";
			$exe_add = $con->query($add);

			echo json_encode(array('msg' => "add"));
		}elseif ($query == "2") {

			$codigo = $_GET['cd'];
			$del = "DELETE FROM `stock` WHERE codigo = '$codigo';";
			$exe_del = $con->query($del);

			header("location: ../../../?page=stock");
		}elseif($query == "3"){

			$year = $_POST['año'];
			$mes = $_POST['mes'];

			$add = "INSERT INTO `meses`(`id`, `año`, `mes`) VALUES (NULL, '$year', '$mes');";

			$exe_add = $con->query($add);

			$crear_mes = "CREATE TABLE `contabilidad_local`.`Ventas $year - $mes` ( `prod` VARCHAR(30) NOT NULL , `cantidad` INT(5) NOT NULL , `precio_unitario` FLOAT NOT NULL , `fecha` TIMESTAMP NOT NULL , `neto` FLOAT NOT NULL , `id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

			$exe_crear_mes = $con->query($crear_mes);

			$crear_mes = "CREATE TABLE `contabilidad_local`.`Gastos $year - $mes` ( `prod` VARCHAR(30) NOT NULL , `cantidad` INT(5) NOT NULL , `precio_unitario` FLOAT NOT NULL , `fecha` TIMESTAMP NOT NULL , `neto` FLOAT NOT NULL , `id` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

			$exe_crear_mes = $con->query($crear_mes);

			echo json_encode(array('msg' => "add"));
		}elseif($query == "4"){

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
		}
	}else{
		echo json_encode(array('msg' => "No ha especificado la consulta"));
	}

?>