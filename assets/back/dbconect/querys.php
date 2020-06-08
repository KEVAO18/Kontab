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

			echo json_encode(array('msg' => "Añadido"));
		}elseif ($query == "2") {

			$codigo = $_GET['cd'];
			$del = "DELETE FROM `stock` WHERE codigo = '$codigo';";
			$exe_del = $con->query($del);

			header("location: ../../../?page=stock");
		}
	}else{
		echo json_encode(array('msg' => "No ha especificado la consulta"));
	}

?>