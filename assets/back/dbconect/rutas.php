<?php
function routes(){
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	}else{
		$page = "inicio";
	}
	include "assets/back/views/".$page.".php";

	if ($page == "inicio") {
		inicio();
	}elseif ($page == "stock") {
		stock();
	}
}