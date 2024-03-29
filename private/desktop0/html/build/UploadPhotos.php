<?php
	/**
		* --------------------------------------------- *
		* @author: Jerson A. Martínez M. (Side Master)  *
		* --------------------------------------------- *
	*/

	include ("../../../connect_server/connect_server.php");
	$CN = CDB("vip");

	@session_start();

	$ruta = "../../users/".@$_SESSION['usr']."/project_img/"; //Decalaramos una variable con la ruta en donde almacenaremos los archivos
	$path = "users/".@$_SESSION['usr']."/project_img/";
	$mensage = ''; //Declaramos una variable mensaje quue almacenara el resultado de las operaciones.

	foreach ($_FILES as $key) { //Iteramos el arreglo de archivos
		if ($key['error'] == UPLOAD_ERR_OK ) { //Si el archivo se paso correctamente Ccontinuamos 
			$NombreOriginal = $CN->CleanString($key['name']);//Obtenemos el nombre original del archivo
			$temporal = $key['tmp_name']; //Obtenemos la ruta Original del archivo
			$Destino = $ruta.$NombreOriginal;	//Creamos una ruta de destino con la variable ruta y el nombre original del archivo	
			
			if (move_uploaded_file($temporal, $Destino)){
				if (!$CN->addProjectImg(@$_SESSION['id_project_selected'], $path, $NombreOriginal))
					$mensage = "<br/>No se insertó la imagen: ".$NombreOriginal."</br>";
					
				@chmod($Destino, 0777);

			}
		}

		if ($key['error']=='') { //Si no existio ningun error, retornamos un mensaje por cada archivo subido
			//
		}
		
		if ($key['error']!='') { //Si existio algún error retornamos un el error por cada archivo.
			$mensage .= '-> No se pudo subir el archivo <b>'.$NombreOriginal.'</b> debido al siguiente error: \n'.$key['error']; 
		}
	}

	echo $mensage;
?>