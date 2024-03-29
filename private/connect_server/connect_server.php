<?php
	/**
		* --------------------------------------------- *
		* @author: Jerson A. Martínez M. (Side Master)  *
		* --------------------------------------------- *
	*/

	#Estableciendo la entrada de texto a UTF-8 desde la cabecera.
	header("Content-Type: text/html;charset=utf-8");

	#Modelo principal de conexión y métodos de acción.
	class PostgreSQL {
		var $db; #Variable que representa la conexión a la DB.

		#Método constructor que crea la conexión al servidor de base de datos.
		#Gestor utilizado: PostgreSQL.
		
		/**
			*@param: $host, $post, $dbase, $user, $pass.
			*Se puede conectar con múltiples base de datos.
		*/

		function __construct($host, $port, $dbase, $user, $pass){
			#Escribir una cadena con formato de secuencia.
			#fprintf(): http://php.net/manual/es/function.fprintf.php

			$cn = sprintf("host=%s;port=%s;dbname=%s;user=%s;password=%s", 
				$host, $port, $dbase, $user, $pass);

			#Asignando la conexión a la variable local de este modelo: db.
			if ($this->db = new PDO("pgsql:".$cn)){
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				#Se establecen atributos a la conexión.
				#Más información: http://php.net/manual/es/pdo.setattribute.php	
				
				#Consulta que establece las entradas de texto a UTF-8.
				if (@$this->db->query("SET NAMES 'utf8'"))
					return true;
			}

			#Si algún paso ha sido fallido o incorrecto, se retorna un booleano falso.
			return false;
		}

		/*
			+-------+-----------------------------------------------------------+
			|       Lista de códigos que representan actividades o eventos.     |
			+-------+-----------------------------------------------------------+
			| Code 	|	Descripción	-> Usuarios									|
			+-------+-----------------------------------------------------------+
			|  -1 	|	Apertura de cuenta										|
			|   0 	|	Cierre de sesión										|
			|   1 	|	Inicio de sesión										|
			|   2 	|	Actualización del nombre de usuario						|
			|   3 	|	Actualización de la contraseña							|
			|   4 	|	Actualización del correo electrónico					|
			|   5 	|	Actualización de la imagen de perfil					|
			|   6 	|	Eliminación de un usuario								|
			|   7 	|	Creación de un usuario									|
			|   8 	|	Evento reservado, actualmente sin acción				|
			|   9 	|	Señalar una actividad como favorito						|
			|   10	|	Respuesta a una actividad								|
			+-------+-----------------------------------------------------------+
			| Code 	|	Descripción	-> Proyectos								|
			+-------+-----------------------------------------------------------+
			|   11	|	Creación de una instancia de aprobación					|
			|   12	|	Eliminación de una instancia de aprobación				|
			|   13	|	Creación de una Facultad | Cur | Escuela				|
			|   14	|	Eliminación de una Facultad | Cur | Escuela				|
			|   15	|	Creación de una Comunidad | Población					|
			|   16	|	Eliminación de una Comunidad | Población				|
			+-------+-----------------------------------------------------------+
			|   17	|	Creación de un Proyecto									|
			|   18	|	Eliminación de un Proyecto								|
			|   19	|	Creación Zonas geográficas de los beneficiarios			|
			|   20	|	Creación de la Temporalidad del proyecto				|
			|   21	|	Creación de la información financiera del proyecto		|
			|   22	|	Creación de la información de resultados del proyecto 	|
			|   23	|	Volcado de las imágenes almacenadas temporalmente 		|
			|   24	|	Actualización de un Proyecto 							|
			|   25	|	Actualización de Zona Geográfica de beneficiarios 		|
			|   26	|	Actualización de Temporalidad sobre un Proyecto			|
			|   27	|	Actualización de la información financiera				|
			|   28	|	Actualización de los resultados de un Proyecto			|
			|   29	|	Actualización del informe final de un Proyecto			|
			+-------+-----------------------------------------------------------+
			| Code 	|	Descripción	-> Equipos y miembros						|
			+-------+-----------------------------------------------------------+
			|   30	|	Creación de un equipo									|
			|   31	|	Actualización de la imagen de un equipo					|
			|   32	|	Actualización de la imagen de un miembro de equipo		|
			|   33	|	Creación de un miembro de equipo 						|
			|   34	|	Actualización de un miembro de equipo 					|
			|   35	|	Eliminación de un miembro de equipo 					|
			|   36	|	Eliminación de un equipo 			 					|
			+-------+-----------------------------------------------------------+
		*/

		/**
			* Método que agrega una actividad de usuario.
			*@param: $usr (Nombre de usuario), $code (Tipo de actividad o evento), $description.
		*/
	    public function addActivity($usr, $code, $description){
	    	#CleanString es un método perteneciente a esta clase.
	    	$usr = $this->CleanString($usr); #Se limpia la cadena recibida, atendiendo al nombre de usuario.
	    	
	    	#Consulta preparada que inserta una actividad.
	    	#Nombre de tabla: vip_user_activity
	    	#Atributos: username, code, description, date_log, date_log_unix, favorite.

	    	$Reason = $this->db->prepare("INSERT INTO vip_user_activity (username, code, description, date_log, date_log_unix, favorite) VALUES (:username,:code,:description,:date_log,:date_log_unix,:favorite)");

	    	#Se agregan los valores.
	    	$Reason->bindValue(":username", $usr);				#Nombre de usuario.
	    	$Reason->bindValue(":code", $code);					#Tipo de actividad o evento.
	    	$Reason->bindValue(":description", $description);	#Descripción.
	    	$Reason->bindValue(":date_log", date('Y-n-j'));		#Fecha.
	    	$Reason->bindValue(":date_log_unix", time());		#Tiempo en decimal UNIX.
	    	$Reason->bindValue(":favorite", 0);					#Valor por defecto de favorito.

	    	#Ejecución de la consulta. Espera retornar un valor booleano.
	    	if ($Reason->execute())
	    		return true;

	    	#Si algo ha fallado, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Obtener todas la última sesión de inicio que ha tenido un usuario
		*/
	    public function getActivityLastStartSession($username){
	    	#Statement: Consulta directa sin preparación. 
	    	#Tabla: vip_user_activity.
	    	#Atributos: id_activity y cláusula LIMIT afectada.

	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity WHERE username='".$username."' AND code='1' ORDER BY id_activity DESC LIMIT 1;");

	    	#Si tiene datos.
	    	if ($stmt->rowCount() > 0){
	    		$UsersData = []; #Definición de una array multidimensional.

	    		#Recorrido de las filas devueltas por la consulta anterior.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Agrega la información temporal de $row al array, dejando los índices como nombres de atributos.
	    			$UsersData[] = [
	    				'id_activity' 	=> $row['id_activity'], 
	    				'username' 		=> $row['username'], 
	    				'code' 			=> $row['code'], 
	    				'description' 	=> $row['description'], 
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix'],
	    				'favorite' 		=> $row['favorite']
	    			];
	    			#Se agregan toda la información devuelta, recordar el * de la consulta.
	    		}

	    		#Finalizado el recorrido, se devuelve el array que contiene toda la información.
	    		return $UsersData;
	    	}

	    	#Si algo ha fallado, se devuelve un booleano falso.
	    	return false;
	    }

	    /**
			* Obtener todas la última sesión de inicio que ha tenido un usuario
		*/
	    public function getActivityLastCloseSession($username){
	    	#Statement: Consulta directa sin preparación. 
	    	#Tabla: vip_user_activity.
	    	#Atributos: id_activity y cláusula LIMIT afectada.

	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity WHERE username='".$username."' AND code='0' ORDER BY id_activity DESC LIMIT 1;");

	    	#Si tiene datos.
	    	if ($stmt->rowCount() > 0){
	    		$UsersData = []; #Definición de una array multidimensional.

	    		#Recorrido de las filas devueltas por la consulta anterior.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Agrega la información temporal de $row al array, dejando los índices como nombres de atributos.
	    			$UsersData[] = [
	    				'id_activity' 	=> $row['id_activity'], 
	    				'username' 		=> $row['username'], 
	    				'code' 			=> $row['code'], 
	    				'description' 	=> $row['description'], 
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix'],
	    				'favorite' 		=> $row['favorite']
	    			];
	    			#Se agregan toda la información devuelta, recordar el * de la consulta.
	    		}

	    		#Finalizado el recorrido, se devuelve el array que contiene toda la información.
	    		return $UsersData;
	    	}

	    	#Si algo ha fallado, se devuelve un booleano falso.
	    	return false;
	    }

	    /**
			* Obtener todas las actividades de los usuarios
		*/
	    public function getAllActivity(){
	    	#Statement: Consulta directa sin preparación. 
	    	#Tabla: vip_user_activity.
	    	#Atributos: id_activity y cláusula LIMIT afectada.

	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity;");

	    	#Si tiene datos.
	    	if ($stmt->rowCount() > 0){
	    		$UsersData = []; #Definición de una array multidimensional.

	    		#Recorrido de las filas devueltas por la consulta anterior.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Agrega la información temporal de $row al array, dejando los índices como nombres de atributos.
	    			$UsersData[] = [
	    				'id_activity' 	=> $row['id_activity'], 
	    				'username' 		=> $row['username'], 
	    				'code' 			=> $row['code'], 
	    				'description' 	=> $row['description'], 
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix'],
	    				'favorite' 		=> $row['favorite']
	    			];
	    			#Se agregan toda la información devuelta, recordar el * de la consulta.
	    		}

	    		#Finalizado el recorrido, se devuelve el array que contiene toda la información.
	    		return $UsersData;
	    	}

	    	#Si algo ha fallado, se devuelve un booleano falso.
	    	return false;
	    }
		
	    /**
			* Método que obtiene una actividad de usuario.
			*@param: $id_activity (ID de una actividad), $Quantity (Límite de resultados).
		*/
	    public function getActivity($id_activity, $Quantity){
	    	#Statement: Consulta directa sin preparación. 
	    	#Tabla: vip_user_activity.
	    	#Atributos: id_activity y cláusula LIMIT afectada.

	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity WHERE id_activity='".$id_activity."' LIMIT ".$Quantity.";");

	    	#Si tiene datos.
	    	if ($stmt->rowCount() > 0){
	    		$UsersData = []; #Definición de una array multidimensional.

	    		#Recorrido de las filas devueltas por la consulta anterior.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Agrega la información temporal de $row al array, dejando los índices como nombres de atributos.
	    			$UsersData[] = [
	    				'id_activity' 	=> $row['id_activity'], 
	    				'username' 		=> $row['username'], 
	    				'code' 			=> $row['code'], 
	    				'description' 	=> $row['description'], 
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix'],
	    				'favorite' 		=> $row['favorite']
	    			];
	    			#Se agregan toda la información devuelta, recordar el * de la consulta.
	    		}

	    		#Finalizado el recorrido, se devuelve el array que contiene toda la información.
	    		return $UsersData;
	    	}

	    	#Si algo ha fallado, se devuelve un booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene una notificación o cambio ocurrido en una actividad.
			*@param: $usr (Nombre de usuario que realizó la actividad), $Quantity (Límite de resultados).
		*/
	    public function getActivityNotificationMessage($usr, $Quantity){
	    	#Statement: Consulta directa sin preparación. 
	    	#Tabla: vip_user_activity_message.
	    	#Atributos: username y cláusula LIMIT afectada.
	    	#Valores devueltos: id_activity (Este no debe tener redundancias), date_log_unix.

	    	$stmt = $this->db->query("SELECT distinct(id_activity), date_log_unix FROM vip_user_activity_message WHERE username!='".$usr."' ORDER BY date_log_unix DESC LIMIT ".$Quantity.";");

	    	#Si hay registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de array multidimensional.
	    		$UsersData = [];

	    		#Se recorren los resultados y se almacenan en el array.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Agrega la información temporal de $row al array, dejando los índices como nombres de atributos.
	    			$UsersData[] = [
	    				'id_activity' 	=> $row['id_activity'], 
	    				'date_log_unix' => $row['date_log_unix']
	    			];
	    		}

	    		#Se retorna el array con la información almacenada.
	    		return $UsersData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene una notificación de una actividad agregada a favoritos.
			*@param: $usr (Nombre de usuario que realizó la actividad), $Quantity (Límite de resultados).
		*/
	    public function getActivityNotificationFavorities($usr, $Quantity){
	    	#Statement: Consulta directa sin preparación. 
	    	#Tabla: vip_user_activity.
	    	#Atributos: username, favorite y cláusula LIMIT afectada.
	    	#Valores devueltos: todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity WHERE username='".$usr."' AND favorite=1 ORDER BY date_log_unix DESC LIMIT ".$Quantity.";");

	    	#Si hay registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de array multidimensional.
	    		$UsersData = [];

	    		#Se recorren los resultados y se almacenan en el array.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Agrega la información temporal de $row al array, dejando los índices como nombres de atributos.
	    			$UsersData[] = [
	    				'id_activity' 	=> $row['id_activity'], 
	    				'username' 		=> $row['username'], 
	    				'code' 			=> $row['code'], 
	    				'description' 	=> $row['description'], 
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix'], 
	    				'favorite' 		=> $row['favorite']
	    			];
	    		}

	    		#Se retorna el array con la información almacenada.
	    		return $UsersData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene mis actividades, referidas al usuario de sesión actual.
			*@param: $Quantity (Límite de resultados).
		*/
	    public function getMyActivity($Quantity){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta directa no preparada. 
	    	#Tabla: vip_user_activity.
	    	#Atributos: username y cláusula LIMIT afectada.
	    	#Valores devueltos: todos los posibles (*).

	    	#Se utiliza la variable de sesión $_SESSION['usr'] para comparar con posible nombre de usuario que se 
	    	#se encuentra registrado en la tabla: vip_user_activity.
	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity WHERE username='".@$_SESSION['usr']."' ORDER BY id_activity DESC LIMIT ".$Quantity.";");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de array multidimensional.
	    		$UsersData = [];

	    		#Se recorren los resultados y se almacenan en el array.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Agrega la información temporal de $row al array, dejando los índices como nombres de atributos.
	    			$UsersData[] = [
	    				'id_activity' 	=> $row['id_activity'], 
	    				'username' 		=> $row['username'], 
	    				'code' 			=> $row['code'], 
	    				'description' 	=> $row['description'], 
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix'],
	    				'favorite' 		=> $row['favorite']
	    			];
	    		}

	    		#Se retorna el array con la información almacenada.
	    		return $UsersData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene las actividades de los demás usuarios, evitando el usuario de sesión actual.
			*@param: $Quantity (Límite de resultados).
		*/
	    public function getActivityWithOutMe($Quantity){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta directa no preparada. 
	    	#Tabla: vip_user_activity.
	    	#Atributos: username y cláusula LIMIT afectada.
	    	#Valores devueltos: todos los posibles (*).

	    	$privilege = @$_SESSION['privilege'];

	    	#Se utiliza la variable de sesión $_SESSION['usr'] para operar en diferencia a él y mostrar los demás usuarios.
	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity WHERE username!='".@$_SESSION['usr']."' ORDER BY date_log_unix DESC LIMIT ".$Quantity.";");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de array multidimensional.
	    		$UsersData = [];

	    		#Agrega la información temporal de $row al array, dejando los índices como nombres de atributos.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			if ($privilege == "Limitado"){
	    				$getPrivilegeUser = $this->getUserPrivilege($row['username']);
		    			
		    			if (!is_bool($getPrivilegeUser)){
		    				if ($getPrivilegeUser == "Limitado"){
				    			$UsersData[] = [
				    				'id_activity' 	=> $row['id_activity'], 
				    				'username' 		=> $row['username'], 
				    				'code' 			=> $row['code'], 
				    				'description' 	=> $row['description'], 
				    				'date_log' 		=> $row['date_log'], 
				    				'date_log_unix' => $row['date_log_unix'], 
				    				'favorite' 		=> $row['favorite'] 
				    			];
		    				}
		    			}
	    			} else if ($privilege == "Administrador"){
	    				$UsersData[] = [
		    				'id_activity' 	=> $row['id_activity'], 
		    				'username' 		=> $row['username'], 
		    				'code' 			=> $row['code'], 
		    				'description' 	=> $row['description'], 
		    				'date_log' 		=> $row['date_log'], 
		    				'date_log_unix' => $row['date_log_unix'], 
		    				'favorite' 		=> $row['favorite'] 
		    			];
	    			}
	    		}

	    		#Se retorna el array con la información almacenada.
	    		return $UsersData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene los mensajes que se han escrito en las actividades con identificador en específico.
			*@param: $id_activity (Identificador que apunta a una actividad).
		*/
	    public function getActivityMessage($id_activity){
	    	#Statement: Consulta directa no preparada. 
	    	#Tabla: vip_user_activity_message.
	    	#Atributos: id_activity.
	    	#Valores devueltos: todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity_message WHERE id_activity='".$id_activity."' ORDER BY id DESC;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de array multidimensional.
	    		$UsersData = [];

	    		#Agrega la información temporal de $row al array, dejando los índices como nombres de atributos.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			$UsersData[] = [
	    				'id' 			=> $row['id'], 
	    				'id_activity' 	=> $row['id_activity'], 
	    				'username' 		=> $row['username'], 
	    				'message' 		=> $row['message'], 
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix'], 
	    			];
	    		}

				#Se retorna el array con la información almacenada.
	    		return $UsersData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega un nuevo usuario.
			*@param: $usr (Nombre de usuario a agregar), $pwd (Password), $email (Dirección de correo), $usr_author (¿Quién lo registra?).
		*/
	    public function addNewUser($usr, $pwd, $email, $usr_author, $privilege){
	    	#Variable que almacena las instrucciones de la consulta.    	
	    	$q = "INSERT INTO vip_user (username, password) VALUES (:username,:password);";

	    	#Se limpia el nombre de usuario.
	    	$usr = $this->CleanString($usr);

	    	#Se crea la consulta preparada pasándole por parámetro las instrucciones.
	    	$stmt = $this->db->prepare($q);

	    	#Vincula un valor a un parámetro.
	    	#bindValue: http://php.net/manual/es/pdostatement.bindvalue.php

	    	$stmt->bindValue(":username", $usr);

	    	#Se cifra la contraseña con password_hash().
	    	#password_hash: http://php.net/manual/es/function.password-hash.php
	    	$stmt->bindValue(":password", password_hash($pwd, PASSWORD_DEFAULT));

	    	#Se ejecuta la consulta preparada.
	    	if ($stmt->execute())
	    		if ($this->addNewUserInfo($usr, $email, $privilege))#Agrega la información al nuevo usuario (usr, email).
	    			if ($this->DirUser($usr))				#Crea el árbol de directorios del nuevo usuario.
	    				if ($this->addActivity($usr_author, 7, "Agregando nuevo usuario: ".$usr)) #Agrega una actividad.
	    					return true;	#Si todo marcha bien hasta acá, se retorna un valor booleano exitoso.

	    	#Se algo falla, re retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega un mensaje a una actividad.
			*@param: $usr (Nombre de usuario que agrega), $id_activity (Identificador de la actividad), $message (Mensaje).
		*/
	    public function addActivityMessage($usr, $id_activity, $message){
	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_user_activity_message.
	    	#Atributos: id_activity, username, message, date_log, date_log_unix.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_user_activity_message (id_activity, username, message, date_log, date_log_unix) VALUES (:id_activity,:username,:message,:date_log,:date_log_unix);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":id_activity", 	$id_activity);
	    	$stmt->bindValue(":username", 		$usr);
	    	$stmt->bindValue(":message", 		$message);
	    	$stmt->bindValue(":date_log", 		date('Y-n-j'));
	    	$stmt->bindValue(":date_log_unix", 	time());

	    	#Se obtiene la actividad con el identificador, extrayendo sólo 1 resultado.
	    	$activity = $this->getActivity($id_activity, 1);

	    	#Definición de una variable a cadena vacía.
	    	$activity_username = "";

	    	#Se recorre el array multidimensional que devuelve el método getActivity y se asigna el valor del índice a $value.
	    	foreach ($activity as $value) {
	    		#Se asigna el nombre de usuario devuelto a la variable vacía.
	    		$activity_username = $value['username'];
	    	}

	    	#Se ejecuta la consulta preparada.
	    	#Seguidamente se agrega una actividad.
	    	if ($stmt->execute())
	    		if ($this->addActivity($usr, 10, "Respondiendo a la actividad ".$id_activity." del usuario ".$activity_username))
	    			return true; #Si ha llegado hasta acá, todo ha salido excelente.

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega la información del nuevo usuario.
			*@param: $usr (Nombre de usuario), $email (Dirección de correo).
		*/
	    public function addNewUserInfo($usr, $email, $privilege){
	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_user_info.
	    	#Atributos: username, email, date_log, date_log_unix.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_user_info (username, email, date_log, date_log_unix, privilege) VALUES (:username,:email,:date_log,:date_log_unix,:privilege);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":username", 		$usr);
	    	$stmt->bindValue(":email", 			$email);
	    	$stmt->bindValue(":date_log", 		date('Y-n-j'));
	    	$stmt->bindValue(":date_log_unix", 	time());
	    	$stmt->bindValue(":privilege", 		$privilege);

	    	#Se ejecuta la consulta preparada.
	    	if ($stmt->execute())
	    		return true; #Si se ha llegado hasta acá, es un resultado correcto.

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega una imagen de perfil a un usuario.
			*@param: $usr (Nombre de usuario), $folder (Ruta de almacenamiento), $src (Nombre del recurso).
		*/
	    public function addUserImgPerfil($usr, $folder, $src){
	    	#Se limpia el nombre del recurso.
	    	$src = $this->CleanString($src);

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_user_img_perfil.
	    	#Atributos: username, folder, src, date_log, date_log_unix.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	$QueryImgPerfil = $this->db->prepare("INSERT INTO vip_user_img_perfil (username, folder, src, date_log, date_log_unix) VALUES (:username,:folder,:src,:date_log,:date_log_unix)");

	    	#Se vinculan los valores con los parámetros.
	    	$QueryImgPerfil->bindValue(":username", $usr);
	    	$QueryImgPerfil->bindValue(":folder", $folder);
	    	$QueryImgPerfil->bindValue(":src", $src);
	    	$QueryImgPerfil->bindValue(":date_log", date('Y-n-j'));
	    	$QueryImgPerfil->bindValue(":date_log_unix", time());

	    	#Se agrega una nueva actividad sobre la acción.
	    	#Seguidamente se ejecuta la consulta preparada para agregar la información.
	    	if ($this->addActivity($usr, 5, "Agregando nueva imagen de perfil:  ".$src))
		    	if ($QueryImgPerfil->execute())
		    		return true; #Se retorna un valor booleano verdadero cuando ha salido todo bien.

		    #Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que elimina un usuario.
			*@param: $usr (Nombre de usuario).
		*/
	    public function deleteUser($usr){
	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_user.
	    	#Atributos: username.
	    	#Valores devueltos: Ninguno ya que se trata de eliminar datos.

	    	#Hay que tener en cuenta que también existen otras tablas relacionadas con esta, sin embargo
	    	#también son eliminadas ya que están escritas en cascada para actualizar y eliminar.
	    	$Reason = $this->db->prepare('DELETE FROM vip_user '
                . 'WHERE username = :usr');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':usr', $usr);

        	#Se habilitan las sesiones.
        	@session_start();

        	#Se añade una nueva actividad.
        	if ($this->addActivity(@$_SESSION['usr'], 6, "Eliminando al usuario: ".$usr))
	       		if ($Reason->execute())	#Se ejecuta la consulta preparada.
	       			return true;	#Retorno verdadero si todo ha marchado bien.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	  
	    /**
			* Método que actualiza el nombre de usuario de un usuario y el árbol de directorios.
			*@param: $new_usr (El nuevo nombre de usuario), $usr (Nombre de usuario al que hace referencia).
		*/
	    public function updateUser($new_usr, $usr){
	    	#Se limpia el contenido de la variable $new_user.
	    	$new_usr = $this->CleanString($new_usr);

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_user.
	    	#Atributos: username.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#La actualización se hace en cascada con respecto a las demás tablas relacionadas a esta.
	    	$Reason = $this->db->prepare('UPDATE vip_user '
                . 'SET username = :new_usr '
                . 'WHERE username = :current_usr');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':new_usr', $new_usr);
        	$Reason->bindValue(':current_usr', $usr);

        	#Ruta del directorio |users|.
        	$path = "../../../../private/desktop0/users/";

        	#Se renombra el directorio del usuario $usr al nuevo que se le ha pasado como $new_usr.
        	rename($path.$usr."/", $path.$new_usr."/");

        	#Se habilitan las sesiones.
        	@session_start();

        	#Se le asigna el nuevo valor a la sesión de inicio que guarda el nombre de usuario.
        	@$_SESSION['usr'] = $new_usr;

        	#Se agrega una nueva actividad.
        	if ($this->addActivity($usr, 2, "Nombre de usuario modificado de ".$usr." a ".$new_usr))
		    	if ($Reason->execute())	#Se ejecuta la consulta preparada.
		    		if ($this->updateUserPathImg($new_usr, $usr))	#Se actualiza la ruta del directorio de imágenes.
		    			return true;	#Todo el proceso ha sido correcto.

		    #Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	  /**
			* Método que actualiza los nombres y apellidos de un usuario
			*@param: $new_usr (Nombres y apellidos), $usr (Nombre de usuario al que hace referencia).
		*/
	    public function updateUserFirstname_Lastname($firstname_lastname, $usr){
	    	#Se limpia el contenido de la variable $new_user.
	    	$firstname_lastname = $this->CleanString($firstname_lastname);

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_user_info.
	    	#Atributos: username.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#La actualización se hace en cascada con respecto a las demás tablas relacionadas a esta.
	    	$Reason = $this->db->prepare('UPDATE vip_user_info '
                . 'SET firstname_lastname = :firstname_lastname '
                . 'WHERE username = :current_usr');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':firstname_lastname', $firstname_lastname);
        	$Reason->bindValue(':current_usr', $usr);

		    if ($Reason->execute())	#Se ejecuta la consulta preparada.
		    	return true;	#Todo el proceso ha sido correcto.

		    #Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que actualiza la dirección de correo de un usuario.
			*@param: $usr (Nombre de usuario al que hace referencia), $email (Dirección de correo).
		*/
	    public function updateUserEmail($usr, $email){
	    	#Se limpia la variable $email.
	    	$email = $this->CleanString($email);

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_user_info.
	    	#Atributos: email, username.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara la consulta.
	    	$Reason = $this->db->prepare('UPDATE vip_user_info '
                . 'SET email = :email '
                . 'WHERE username = :usr');

	    	#Se vincula el valor con el parámetro.
	    	$Reason->bindValue(':email', $email);
        	$Reason->bindValue(':usr', $usr);

        	#Se crea una nueva actividad.
        	if ($this->addActivity($usr, 4, "Actualización de E-Mail de ".$this->getUserEmail($usr)." a ".$email))
		    	if ($Reason->execute())	#Se ejecuta la consulta preparada.
		    		return true;		#Si llega hasta acá, todo se ha relizado correctamente.

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que actualiza el privilegio o estado.
			*@param: $usr (Nombre de usuario al que hace referencia), $privilege (Estado de cuenta).
		*/
	    public function UpdateUserPrivilege($usr, $privilege){
	    	#Se limpia la variable $privilege.
	    	$privilege = $this->CleanString($privilege);

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_user_info.
	    	#Atributos: privilege, username.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara la consulta.
	    	$Reason = $this->db->prepare('UPDATE vip_user_info '
                . 'SET privilege = :privilege '
                . 'WHERE username = :usr');

	    	#Se vincula el valor con el parámetro.
	    	$Reason->bindValue(':privilege', $privilege);
        	$Reason->bindValue(':usr', $usr);

        	@session_start();

        	#Se crea una nueva actividad.
        	if ($this->addActivity(@$_SESSION['usr'], 4, "Actualización del privilegio del usuario ".$usr." a ".$privilege))
		    	if ($Reason->execute())	#Se ejecuta la consulta preparada.
		    		return true;		#Si llega hasta acá, todo se ha relizado correctamente.

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que actualiza la acción de favorito a una actividad.
			*@param: $usr (Nombre de usuario al que hace referencia), $id_activity(ID de actividad) $favorite (Favorito 0,1).
		*/
	    public function updateActivityFavorite($usr, $id_activity, $favorite){
	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_user_activity.
	    	#Atributos: favorite, id_favorite.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Tenga en cuenta que hay varias tablas de actividades relacionadas, por lo tanto, se actualzarán en cascada.
	    	$Reason = $this->db->prepare('UPDATE vip_user_activity '
                . 'SET favorite = :favorite '
                . 'WHERE id_activity = :id_activity');

	    	#Se vincula el valor con el parámetro.
	    	$Reason->bindValue(':favorite', 	$favorite);
        	$Reason->bindValue(':id_activity', 	$id_activity);

        	#Si el valor a favorito es 1, significa que se marca como favorito. Si es 0, lo contrario.
        	if ($favorite == 1){
        		$Message = "La actividad ".$id_activity.", se ha marcado como favorito.";
        	} else if ($favorite == 0) {
        		$Message = "La actividad ".$id_activity.", se ha desmarcado de los favoritos.";
        	}

        	#La variable $Message almacena el string que se cargará en la descripción de la nueva actividad.
        	if ($this->addActivity($usr, 9, $Message))
		    	if ($Reason->execute())	#Se ejecuta la consulta preparada.
		    		return true;	#Todo ha salido correctamente.

		    #Si algo falla, se devuelve un valor booleano falso.
		    return false;
	    }

	    /**
			* Método que actualiza la contraseña de un usuario.
			*@param: $usr (Nombre de usuario al que hace referencia), $current_pwd (Clave por defecto), $new_pwd (Nueva clave).
		*/
	    public function updateUserPassword($usr, $current_pwd, $new_pwd){
	    	#Se verifica la clave por defecto llamando al método VerifyUserPassword, pasándole por parámetro el nombre de usuario
	    	#y la clave por defecto. Si es correcta, retorna true, sino, false.
	    	if ($this->VerifyUserPassword($usr, $current_pwd)){
	    		
	    		#Statement: Consulta preparada. 
		    	#Tabla: vip_user.
		    	#Atributos: password, username.
		    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    		#Se prepara al consulta.
	    		$Reason = $this->db->prepare('UPDATE vip_user '
                . 'SET password = :new_pwd '
                . 'WHERE username = :usr');

	    		#Se vincula el valor con el parámetro.
		    	$Reason->bindValue(':new_pwd', password_hash($new_pwd, PASSWORD_DEFAULT));
	        	$Reason->bindValue(':usr', $usr);

	        	#Se crea una nueva actividad.
	        	if ($this->addActivity($usr, 3, "Actualización de contraseña"))
			    	if ($Reason->execute())	#Se ejecuta la consulta preparada.
			    		return true;	#Si se llega hasta acá, significa que todo se ha realizado con éxito.

			    #Se retorna -2 pensándose como fallo que significa que no se ha podido hacer la actualización.
			    return -2;

	    	} else {
	    		#Se retorna -1 pensándose como fallo que significa que la contraseña por defecto es incorrecta.
	    		return -1;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que verifica la contraseña de un usuario.
			*@param: $usr (Nombre de usuario al que hace referencia), $current_pwd (Clave por defecto).
		*/
	    public function VerifyUserPassword($usr, $current_pwd){	   
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user.
		    #Atributos: password, username.
		    #Valores devueltos: password. 	
	    	
	    	#Se extrae la contraseña cifrada del usuario en comparación.
	    	$stmt = $this->db->query("SELECT password FROM vip_user WHERE username='".$usr."';");
	    
	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0)
	    		while ($r = $stmt->fetch(\PDO::FETCH_ASSOC))	#Se recorren los valores devueltos.
	    			if (password_verify($current_pwd, $r['password'])) 	#Comprueba que la contraseña coincida con un hash.
	    				return true;	#Satisfactorio.
	    	
	    	#password_verify: http://php.net/manual/es/function.password-verify.php

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que actualiza la ruta del directorio de Users/Usuario.
			*@param: $new_usr (Nuevo nombre de usuario), $usr (El nombre de usuario por defecto).
		*/
	    public function updateUserPathImg($new_usr, $usr){
	    	#Variable que almacena la ruta del directorio usuarios, seguidamente del directorio de nombre de usuarios, 
	    	#dentro de este directorio se encuentra también img_perfil, que es donde se almacenan las imágenes que se 
	    	#agrean de perfil. 

	    	#Se puede observar que el nuevo nombre de usuario ha sido limpiado.
	    	$Path = "users/".$this->CleanString($new_usr)."/img_perfil"."/";

	    	#Statement: Consulta preparada. 
		    #Tabla: vip_user_img_perfil.
		    #Atributos: folder, username.
		    #Valores devueltos: password. 	

	    	$Reason = $this->db->prepare('UPDATE vip_user_img_perfil '
                . 'SET folder = :path '
                . 'WHERE username = :usr');

	    	#Se vincula el valor con el parámetro.
	    	$Reason->bindValue(':path', $Path);
        	$Reason->bindValue(':usr', $new_usr);

        	#Se cambia la ruta de las imágenes que estén agregadas a un proyecto que haya creado este usuario.
	    	if ($this->ChangeUserProjectImg($new_usr, $usr)){
        		#Se ejecuta la consulta preparada.
		    	if ($Reason->execute()){
		    		return true;	#Satisfactorio.
		    	}
	    	}

	    	#Si algo falla, se retorna una valor booleano falso.
		    return false;
	    }

	    /**
			* Método que loguea a un usuario.
			*@param: $usr (Nombre de usuario), $pwd (Contraseña).
		*/
	    public function LoginUser($usr, $pwd){
	    	#Se limpia el nombre de usuario.
	    	$usr = $this->CleanString($usr);

	    	#Se limpian los espacios de inicio y fin de la cadena password.
	    	$pwd = trim($pwd);

	    	#Se verifica si existe el sistema de escape de strings get_magic_quotes_gpc.
	    	#get_magic_quotes_gpc: http://php.net/manual/es/function.get-magic-quotes-gpc.php
			if (!get_magic_quotes_gpc())
				$usr = addslashes($usr); #Escapa un string con barras invertidas

			#addslashes: http://php.net/manual/es/function.addslashes.php

			#Escape a string para una consulta.
			#pg_escape_string: http://php.net/manual/es/function.pg-escape-string.php
			$usr = pg_escape_string($usr);

			#Statement: Consulta no preparada. 
		    #Tabla: vip_user.
		    #Atributos: username, password.
		    #Valores devueltos: password.

	    	$stmt = $this->db->query("SELECT password FROM vip_user WHERE username='".$usr."';");

	    	#Existen registros.
	    	if ($stmt->rowCount() > 0)
	    		while ($r = $stmt->fetch(\PDO::FETCH_ASSOC))					#Recorrer datos.
	    			if (password_verify($pwd, $r['password']))					#Verificar contraseñas.
	    				if ($this->addActivity($usr, 1, "Inicio de sesión"))	#Crear nueva actividad.
	    					if ($this->DirUser($usr))							#Árbol de directorio del usuario.
	    						return true;									#Todo correcto.

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que crea un árbol de directorios sobre un usuario.
			*@param: $usr (Nombre de usuario).
		*/
	    public function DirUser($usr){
	    	#Ruta del directorio |Users|
	    	$path = "../../private/desktop0/users/";

	    	#Se verifica la existencia del directorio |Users|.
			if (!file_exists($path))
				@mkdir($path, 0777); 					#En caso que no exista, se crea el directorio.

			#Se limpia el nombre de usuario y se concatena a la variable $path que contiene la ruta de |Users|.
			$path .= $this->CleanString($usr)."/";

			#Se verifica la existencia del directorio |Users|nombre_de_usuario|.
			if (!file_exists($path))
				@mkdir($path, 0777);					#En caso que no exista, se crea el directorio.

			#Se hace una copia de la ruta actual del usuario |Users|nombre_de_usuario|.
			$path_project 		= $path;
			$path_team 			= $path;
			$path_team_member 	= $path;

			#Se concatena img_perfil, este será otro directorio dentro del directorio usuario.
			$path .= "img_perfil/";

			#Se verifica la existencia del directorio |Users|nombre_de_usuario|img_perfil|.
			if (!file_exists($path))
				@mkdir($path, 0777);					#En caso que no exista, se crea el directorio.

			#$path_project conserva una copia de |Users|nombre_de_usuario|, se concatena |project_img|.
			$path_project .= "project_img/";

			#Se verifica la existencia del directorio |Users|nombre_de_usuario|project_img|
			if (!file_exists($path_project))
				@mkdir($path_project, 0777);			#En caso que no exista, se crea el directorio.

			$path_team .= "img_team/";
			#Se verifica la existencia del directorio |Users|nombre_de_usuario|img_team|
			if (!file_exists($path_team))
				@mkdir($path_team, 0777);			#En caso que no exista, se crea el directorio.

			$path_team_member .= "img_team_member/";
			#Se verifica la existencia del directorio |Users|nombre_de_usuario|img_team_member|
			if (!file_exists($path_team_member))
				@mkdir($path_team_member, 0777);			#En caso que no exista, se crea el directorio.

			#Retornamos verdadero, que todo ha salido correctamente.
			return true;
	    }

	    /**
			* Método que obtiene el número de actividades que se han agregado a favoritos.
			*@param: $usr (Nombre de usuario).
		*/
	    public function getActivityNotificationFavoritiesCount($usr){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_activity.
		    #Atributos: username, favorite.
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity WHERE username='".$usr."' AND favorite=1;");
	    	
	    	#Se retorna la cantidad de filas devueltas por la consulta.
	    	return $stmt->rowCount();
	    }

	    /**
			* Método que obtiene el número de actividades a las que se les ha agregado un mensaje en notificación a mi usuario.
			*@param: $usr (Nombre de usuario).
		*/
	    public function getActivityNotificationMessageCount($usr){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_activity_message.
		    #Atributos: username.
		    #Valores devueltos: id_activity, date_log_unix (evitando redundancia).

	    	$stmt = $this->db->query("SELECT distinct(id_activity), date_log_unix FROM vip_user_activity_message WHERE username!='".$usr."';");
	    	
	    	#Se retorna la cantidad de filas devueltas por la consulta.
	    	return $stmt->rowCount();
	    }

	    /**
			* Método que obtiene el número de inicios de sesión que han realizado los usuarios.
			*@param: No hay.
		*/
	    public function getUserSession(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_activity.
		    #Atributos: code.
		    #Valores devueltos: Todos los posibles (*).

	    	#El código que se le pasa significa Inicio de sesión y puedes encontrar más en la línea: 45 de este script.
	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity WHERE code=1");
	    	
	    	#Se retorna la cantidad de filas devueltas por la consulta.
	    	return $stmt->rowCount();
	    }

	    /**
			* Método que obtiene el número de usuarios que existen.
			*@param: No hay.
		*/
	    public function getUserCount(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user.
		    #Atributos: -
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user");
	    	
	    	#Se retorna la cantidad de filas devueltas por la consulta.
	    	return $stmt->rowCount();
	    }

	    /**
			* Método que obtiene el número de usuarios que tienen el mismo nombre.
			*@param: $usr (Nombre de usuario).
		*/
	    public function getUserRowCount($usr){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user.
		    #Atributos: username.
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user WHERE username='".$usr."'");
	    	
	    	#Se retorna la cantidad de filas devueltas por la consulta.
	    	return $stmt->rowCount();
	    }

	    /**
			* Método que obtiene el argumento de una actividad, referida al mensaje según el código.
			*@param: $code (Código correspondiente a una actividad).
		*/
	    public function getActivityArgument($code){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_activity_argument.
		    #Atributos: code.
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity_argument WHERE code='".$code."';");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UsersData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UsersData[] = [
	    				'activity' 	=> $row['activity']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#En este caso se retorna solamente la actividad o el argumento de la misma.
	    		foreach ($UsersData as $value) {
	    			return $value['activity']; #Correcto.
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el valor favorite de una actividad.
			*@param: $id_activity (ID de una actividad).
		*/
	    public function getActivityFavorite($id_activity){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_activity.
		    #Atributos: id_activity.
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user_activity WHERE id_activity='".$id_activity."';");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UsersData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UsersData[] = [
	    				'favorite' 	=> $row['favorite']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#En este caso se retorna solamente el campo favorite.
	    		foreach ($UsersData as $value) {
	    			return $value['favorite']; #Correcto.
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene la contraseña de un usuario en específico.
			*@param: $usr (Nombre de usuario).
		*/
	    public function getUserPwd($usr){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user.
		    #Atributos: username.
		    #Valores devueltos: password.

	    	$stmt = $this->db->query("SELECT password FROM vip_user WHERE username='".$usr."';");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UsersData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UsersData[] = [
	    				'password' 	=> $row['password']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo password.
	    		foreach ($UsersData as $value) {
	    			return $value['password'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene la información de todos los usuarios.
			*@param: No hay.
		*/
	    public function getUsersAll(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_info.
		    #Atributos: -
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user_info;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UsersData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UsersData[] = [
	    				'username' 		=> $row['username'],
	    				'email' 		=> $row['email'],
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix'],
	    				'privilege' 	=> $row['privilege']
	    			];
	    		}

	    		#Se retorna el array de información.
	    		return $UsersData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene la cantidad de direcciones de correo igual al email que se le pasa por parámetros.
			*@param: $email (Dirección de correo).
		*/
	    public function getEmailRowCount($email){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_info.
		    #Atributos: email.
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user_info WHERE email='".$email."'");
	    	
	    	#Se retorna la cantidad.
	    	return $stmt->rowCount();
	    }

	    /**
			* Método que obtiene la dirección de correo de un usuario.
			*@param: $usr (Nombre de usuario).
		*/
	    public function getUserEmail($usr){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_info.
		    #Atributos: username.
		    #Valores devueltos: email.

	    	$stmt = $this->db->query("SELECT email FROM vip_user_info WHERE username='".$usr."'");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UserEmail = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UserEmail[] = [
	    				'email' => $row['email']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo email.
	    		foreach ($UserEmail as $value) {

	    			#Se retorna el valor que contiene el índice: email.
	    			return $value['email'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el privilegio de un usuario.
			*@param: $usr (Nombre de usuario).
		*/
	    public function getUserPrivilege($usr){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_info.
		    #Atributos: username.
		    #Valores devueltos: privilege.

	    	$stmt = $this->db->query("SELECT privilege FROM vip_user_info WHERE username='".$usr."'");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UserPrivilege = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UserPrivilege[] = [
	    				'privilege' => $row['privilege']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo privilege.
	    		foreach ($UserPrivilege as $value) {

	    			#Se retorna el valor que contiene el índice: privilege.
	    			return $value['privilege'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene los nombres y apellidos de un usuario.
			*@param: $usr (Nombre de usuario).
		*/
	    public function getUserFirstname_Lastname($usr){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_info.
		    #Atributos: username.
		    #Valores devueltos: firstname_lastname.

	    	$stmt = $this->db->query("SELECT firstname_lastname FROM vip_user_info WHERE username='".$usr."'");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$Userfirstname_lastname = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$Userfirstname_lastname[] = [
	    				'firstname_lastname' => $row['firstname_lastname']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo firstname_lastname.
	    		foreach ($Userfirstname_lastname as $value) {

	    			#Se retorna el valor que contiene el índice: firstname_lastname.
	    			return $value['firstname_lastname'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene información sobre la imagen de perfil de un usuario.
			*@param: $usr (Nombre de usuario), $Order (La forma de ordenar la info.), $Quantity (Límite de registros).
		*/
	    public function getUserImgPerfil($usr, $Order, $Quantity){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_user_img_perfil.
		    #Atributos: usr, cláusula LIMIT.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_user_img_perfil WHERE username='".$usr."' ORDER BY id ".$Order." LIMIT ".$Quantity);

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UserImgPerfil = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UserImgPerfil[] = [
	    				'id' 			=> $row['id'],
	    				'username' 		=> $row['username'],
	    				'folder'		=> $row['folder'],
	    				'src'			=> $row['src'],
	    				'date_log' 		=> $row['date_log'],
	    				'date_log_unix' => $row['date_log_unix'] 
	    			];
	    		}

	    		#Se retorna la información capturada en el array.
	    		return $UserImgPerfil;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que limpia o escapa strings.
			*@param: $str (String = Cadena de caracteres).
		*/
	    public function CleanString($str) {
 			
 			#Se limpian los espacios de inicio y de fin.
		    $str = trim($str);
		 	
		 	#Reemplaza todas las apariciones del string buscado con el string de reemplazo.
		 	#str_replace: http://php.net/manual/es/function.str-replace.php
		    #--------------------------------------------------------------------------------

		    $str = str_replace(
		        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
		        $str
		    );
		 	
		 	#--------------------------------------------------------------------------------

		    $str = str_replace(
		        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
		        $str
		    );
		 
		    #--------------------------------------------------------------------------------

		    $str = str_replace(
		        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
		        $str
		    );
		 
		    #--------------------------------------------------------------------------------

		    $str = str_replace(
		        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
		        $str
		    );
		 
		    #--------------------------------------------------------------------------------

		    $str = str_replace(
		        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
		        $str
		    );
		 
		    #--------------------------------------------------------------------------------

		    $str = str_replace(
		        array('ñ', 'Ñ', 'ç', 'Ç'),
		        array('n', 'N', 'c', 'C',),
		        $str
		    );

		    #--------------------------------------------------------------------------------
		 
		    #Se retorna el nuevo string.
		    return $str;
		}

		/**
			* Método que obtiene información de sesión del usuario.
			*@param: $Limit (Límite de registros), $Order (Orden en el retorno de los datos).
		*/
	    public function getSessionUser($Limit, $Order){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_info_user.
		    #Atributos: cláusula LIMIT.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_info_user ORDER BY date_log_unix ".$Order." LIMIT ".$Limit);

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de array multidimensional.
	    		$dataProject = [];

	    		#Recorrer todos los registros que existan.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Almacenamiento de la información.
	    			$dataProject[] = [
	    				'username' 		=> $row['username'],
	    				'activity' 		=> $row['activity'],
	    				'date_log' 		=> $row['date_log'],
	    				'date_log_unix' => $row['date_log_unix'], 
	    				'email'			=> $row['email']
	    			];
	    		}

	    		#Retorno del array cargado de datos.
	    		return $dataProject;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
	    	*------------------------------NO UTILIZADO---------------------------------------
			* Método que obtiene todos los proyectos, sin embargo, este método no es utilizado.
			*@param: No hay.
			*------------------------------NO UTILIZADO---------------------------------------
		*/
	    public function getAllProject() {
	        $stmt = $this->db->query("SELECT * FROM vip_proyecto");

	        if ($stmt->rowCount() > 0){
		        $dataProject = [];
		        
		        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
		            $dataProject[] = [
		                'id_project' 					=> $row['id_project'],
		                'nombre' 						=> $row['nombre'],
		                'facultad_cur_escuela' 			=> $row['facultad_cur_escuela'],
		                'objetivo_general' 				=> $row['objetivo_general'],
		                'objetivo_especifico'			=> $row['objetivo_especifico'],
		                'resultados_esperados' 			=> $row['resultados_esperados'],
		                'fecha_aprobacion' 				=> $row['fecha_aprobacion'],
		                'cod_dictamen_economico' 		=> $row['cod_dictamen_economico'],
		                'nombre_instancia_aprobacion' 	=> $row['nombre_instancia_aprobacion']
		            ];
		        }

		        return $dataProject;
	        }
	        return false;
	    }

	    /**
	    	*------------------------------NO UTILIZADO---------------------------------------
			* Método que agrega proyectos, sin embargo, este método no es utilizado.
			*@param: No hay.
			*------------------------------NO UTILIZADO---------------------------------------
		*/
	    public function addProject($dataProject){
	        $sql = "INSERT INTO vip_proyecto(nombre, facultad_cur_escuela, objetivo_general, objetivo_especifico, resultados_esperados, fecha_aprobacion, cod_dictamen_economico, nombre_instancia_aprobacion) VALUES(:nombre,:facultad_cur_escuela,:objetivo_general,:objetivo_especifico,:resultados_esperados,:fecha_aprobacion,:cod_dictamen_economico,:nombre_instancia_aprobacion)";

	        $stmt = $this->db->prepare($sql);
	        
	        $stmt->bindValue(':nombre', 					$dataProject['nombre']);
	        $stmt->bindValue(':facultad_cur_escuela', 		$dataProject['facultad_cur_escuela']);
	        $stmt->bindValue(':objetivo_general', 			$dataProject['objetivo_general']);
	        $stmt->bindValue(':objetivo_especifico', 		$dataProject['objetivo_especifico']);
	        $stmt->bindValue(':resultados_esperados', 		$dataProject['resultados_esperados']);
	        $stmt->bindValue(':fecha_aprobacion', 			$dataProject['fecha_aprobacion']);
	        $stmt->bindValue(':cod_dictamen_economico', 	$dataProject['cod_dictamen_economico']);
	        $stmt->bindValue(':nombre_instancia_aprobacion',$dataProject['nombre_instancia_aprobacion']);
	        
	        if ($stmt->execute())
	        	return true;
	        
	        return false;
	    }

	    /**
	    	*------------------------------NO UTILIZADO---------------------------------------
			* Método que verifica una sesión, sin embargo, este método no es utilizado.
			*@param: No hay.
			*------------------------------NO UTILIZADO---------------------------------------
		*/
	    public function is_session_started(){
		    if ( php_sapi_name() !== 'cli' ) {
		        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
		            return session_status() === PHP_SESSION_ACTIVE ? true : false;
		        } else {
		            return session_id() === '' ? false : true;
		        }
		    }
		    return false;
		}

		/**
			* Método que destruye sesiones y agrega una actividad.
			*@param: No hay.
		*/
	    public function sessionDestroy(){
	    	#Se verifica si no están establecidas las sesiones.
	    	if (!isset($_SESSION))
	    		@session_start(); #Habilitar uso de sesiones.

	    	#Agrega una nueva actividad, pasándole por parámetros el nombre de usuario, el código y la descripción.
	    	if ($this->addActivity($_SESSION['usr'], 0, "Cierre de sesión"))
				@session_destroy(); #Finalmente se destruyen las sesiones.
	    }


	    #####################################################################################
	    #										INICIO 										#
	    #####################################################################################
	    #					Métodos utilizados para gestionar Proyectos.					#
	    #####################################################################################

	    /**
			* Método que agrega un nuevo proyecto.
			*@param: $name (Nombre), $content (Objetivos y resultados), $IDFacCurEsc (Identificador).
			*@param: $FechaAprobacion (Fecha de aprobación), $CodigoDictamen (Dictamen económico), $IDInstanciaAprobacion (Identificador).
		*/
	    public function addProyecto($name, $content, $IDFacCurEsc, $FechaAprobacion, $CodigoDictamen, $IDInstanciaAprobacion){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_proyecto.
	    	#Atributos: nombre, id_facultad_cur_escuela, contenido, fecha_aprobacion, cod_dictamen_economico, id_instancia_aprobacion.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_proyecto (nombre, id_facultad_cur_escuela, contenido, fecha_aprobacion, cod_dictamen_economico, id_instancia_aprobacion) VALUES (:nombre,:id_facultad_cur_escuela,:contenido,:fecha_aprobacion,:cod_dictamen_economico,:id_instancia_aprobacion);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":nombre", 					$name);
	    	$stmt->bindValue(":id_facultad_cur_escuela", 	$IDFacCurEsc);
	    	$stmt->bindValue(":contenido", 					$content);
	    	$stmt->bindValue(":fecha_aprobacion", 			$FechaAprobacion);
	    	$stmt->bindValue(":cod_dictamen_economico", 	$CodigoDictamen);
	    	$stmt->bindValue(":id_instancia_aprobacion", 	$IDInstanciaAprobacion);

	    	#Agregando la descripción completa de la nueva actividad.
	    	$description = "Agregando un nuevo Proyecto titulado: ".$name;

		    if ($stmt->execute()) { #Se ejecuta la consulta preparada.
        		if ($this->addActivity(@$_SESSION['usr'], 17, $description)) #Agrega una actividad.
		    		return true; #Si se ha llegado hasta acá, es un resultado correcto.
		    }
	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que actualiza la información de un proyecto.
			*@param: $id_project (Identificador del proyecto), $name (Nombre), $content (Objetivos y resultados), $IDFacCurEsc (Identificador).
			*@param: $FechaAprobacion (Fecha de aprobación), $CodigoDictamen (Dictamen económico), $IDInstanciaAprobacion (Identificador).
		*/
	    public function updateProject($id_project, $name, $content, $IDFacCurEsc, $FechaAprobacion, $CodigoDictamen, $IDInstanciaAprobacion){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada. 
	    	#Tabla: vip_proyecto.
	    	#Atributos: id_project, nombre, id_facultad_cur_escuela, contenido, fecha_aprobacion, cod_dictamen_economico, id_instancia_aprobacion.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara la consulta.
	    	$Reason = "UPDATE vip_proyecto SET nombre='".$name."', id_facultad_cur_escuela='".$IDFacCurEsc."', contenido='".$content."', fecha_aprobacion='".$FechaAprobacion."', cod_dictamen_economico='".$CodigoDictamen."', id_instancia_aprobacion='".$IDInstanciaAprobacion."' WHERE id_project='".$id_project."'";
	    	
	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
	        	if ($this->addActivity($usr, 24, "Actualización de un proyecto llamado: ".$name." con ID: ".$id_project))
	    			return true;
			    
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que elimina un proyecto.
			*@param: $project_id (Identificador de la población).
		*/
	    public function deleteProject($id_project){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
		    #Tabla: vip_proyecto.
		    #Atributos: id_project.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_proyecto '
                . 'WHERE id_project = :id_project');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':id_project', $id_project);

		    #Se hace uso de esta nueva y temporal conexión.
        	if ($this->addActivity(@$_SESSION['usr'], 18, "Eliminando un Proyecto con ID: ".$id_project)) #Agrega una actividad.
	        	if ($Reason->execute()) #Se ejecuta la consulta.
		       		return true; #Buen resultado.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    /**
			* Método que obtiene todos los proyectos.
			*@param: No hay.
		*/
	    public function getProjects(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_proyecto.
		    #Atributos: -
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_proyecto;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_project' 				=> $row['id_project'], 
	    				'nombre' 					=> $row['nombre'],
	    				'id_facultad_cur_escuela' 	=> $row['id_facultad_cur_escuela'],
	    				'contenido' 				=> $row['contenido'],
	    				'fecha_aprobacion' 			=> $row['fecha_aprobacion'],
	    				'cod_dictamen_economico' 	=> $row['cod_dictamen_economico'],
	    				'id_instancia_aprobacion' 	=> $row['id_instancia_aprobacion']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el número de proyectos que existen.
			*@param: No hay.
		*/
	    public function getProjectsCount(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_proyecto.
		    #Atributos: -
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_proyecto");
	    	
	    	#Se retorna la cantidad de filas devueltas por la consulta.
	    	return $stmt->rowCount();
	    }

	    public function getProjectsAllOnly(){
            $stmt = $this->db->query("SELECT * FROM vip_proyecto");

            if ($stmt->rowCount() > 0){
                $dataUsers = [];
                
                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $dataUsers[] = [
                        'nombre'  => $row['nombre']
                    ];
                }

                $texto = '';
                foreach($dataUsers as $equipo) {
                    $texto .= '"' . $equipo['nombre'] . '",';
                }
                
                return $texto;
            } else {
                return false;
            }
        }

	    /**
			* Método que obtiene un proyecto en específico por ID.
			*@param: id_project (Identificador del proyecto).
		*/
	    public function getProjectsOnlyById($id_project){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_proyecto.
		    #Atributos: id_project
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_proyecto WHERE id_project=".$id_project." LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_project' 				=> $row['id_project'], 
	    				'nombre' 					=> $row['nombre'],
	    				'id_facultad_cur_escuela' 	=> $row['id_facultad_cur_escuela'],
	    				'contenido' 				=> $row['contenido'],
	    				'fecha_aprobacion' 			=> $row['fecha_aprobacion'],
	    				'cod_dictamen_economico' 	=> $row['cod_dictamen_economico'],
	    				'id_instancia_aprobacion' 	=> $row['id_instancia_aprobacion']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el reporte final de un proyecto en específico por ID.
			*@param: id_project (Identificador del proyecto).
		*/
	    public function getProjectsResultById($id_project){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_informe_final.
		    #Atributos: id_project
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_informe_final WHERE id_project='".$id_project."' LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_project' 				=> $row['id_project'], 
	    				'otros' 					=> $row['otros']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega datos vacíos sobre el informe final del proyecto.
			*@param: $id_project (Identificador del proyecto), $content (Contenido, redacción, informe).
		*/
	    public function addNowProjectResult($id_project){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada.
	    	#Tabla: vip_informe_final.
	    	#Atributos: id_project,  otros.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se prepara la consulta.
	    	$Reason = "INSERT INTO vip_informe_final (id_project, otros) VALUES ('".$id_project."','-')";
	    	
	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
        		if ($this->addActivity($usr, 29, "Agregando el campo de informe final del proyecto con ID: ".$id_project))
	    			return true;
			    
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	     /**
			* Método que agrega un nuevo equipo para el proyecto.
			*@param: $id_project (Identificador del proyecto), $name (Nombre del equipo).
		*/
	    public function addTeamProject($id_project, $name){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada.
	    	#Tabla: vip_team.
	    	#Atributos: Ninguno
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se prepara la consulta.
	    	$Reason = "INSERT INTO vip_team (nombre, id_project, date_log, date_log_unix) VALUES ('".$name."','".$id_project."','".date('Y-n-j')."','".time()."')";
	    	
	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
        		if ($this->addActivity($usr, 30, "Creando un equipo llamado: ".$name.", con ID de proyecto: ".$id_project))
	    			return true;
			    
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que obtiene todos los equipos que se han creado.
			*@param: No hay.
		*/
	    public function getTeamProject(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team.
		    #Atributos: id_project
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_team;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_team' 			=> $row['id_team'], 
	    				'nombre' 			=> $row['nombre'], 
	    				'id_project' 		=> $row['id_project'], 
	    				'date_log' 			=> $row['date_log'],
	    				'date_log_unix' 	=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene un equipo en específico por ID.
			*@param: $id_team.
		*/
	    public function getTeamProjectById($id_team){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team.
		    #Atributos: id_team
		    #Valores devueltos: Todos los datos posibles (*).

	    	@session_start();

	    	if ($id_team == "" && !isset($_SESSION['id_team'])) 
		    	$id_team = 1;

	    	$stmt = $this->db->query("SELECT * FROM vip_team WHERE id_team=".$id_team." LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_team' 			=> $row['id_team'], 
	    				'nombre' 			=> $row['nombre'], 
	    				'id_project' 		=> $row['id_project'], 
	    				'date_log' 			=> $row['date_log'],
	    				'date_log_unix' 	=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega una imagen a un equipo.
			*@param: $id_team (ID del equipo), $folder (Ruta de almacenamiento), $src (Nombre del recurso).
		*/
	    public function addTeamImgPerfil($id_team, $folder, $src){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Se limpia el nombre del recurso.
	    	$src = $this->CleanString($src);

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_team_img.
	    	#Atributos: id_team, folder, src, date_log, date_log_unix.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	$QImgTeam = $this->db->prepare("INSERT INTO vip_team_img (id_team, folder, src, date_log, date_log_unix) VALUES (:id_team,:folder,:src,:date_log,:date_log_unix)");

	    	#Se vinculan los valores con los parámetros.
	    	$QImgTeam->bindValue(":id_team", $id_team);
	    	$QImgTeam->bindValue(":folder", $folder);
	    	$QImgTeam->bindValue(":src", $src);
	    	$QImgTeam->bindValue(":date_log", date('Y-n-j'));
	    	$QImgTeam->bindValue(":date_log_unix", time());

	    	#Se agrega una nueva actividad sobre la acción.
	    	#Seguidamente se ejecuta la consulta preparada para agregar la información.
	    	if ($this->addActivity($usr, 31, "Actualizando la imagen del equipo con ID: ".$id_team))
		    	if ($QImgTeam->execute())
		    		return true; #Se retorna un valor booleano verdadero cuando ha salido todo bien.

		    #Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el número de equipos que se han realizado.
			*@param: No hay.
		*/
	    public function getTeamCount(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team.
		    #Atributos: code.
		    #Valores devueltos: Todos los posibles (*).

	    	#El código que se le pasa significa Inicio de sesión y puedes encontrar más en la línea: 45 de este script.
	    	$stmt = $this->db->query("SELECT * FROM vip_team");
	    	
	    	#Se retorna la cantidad de filas devueltas por la consulta.
	    	return $stmt->rowCount();
	    }

	    /**
			* Método que agrega un miembro a un equipo.
			*@param: $id_team (ID del equipo).
		*/
	    public function addTeamMember($id_team, $firstname, $lastnames, $grado_academico, $dependencia_academica, $tipo_contratacion, $hrs_semanales_dedicacion){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_team_members.
	    	#Atributos: id_team, id_img, firts_name, last_name, grado_academico, dependencia_academica, tipo_contratacion, hrs_semanales_dedicacion, date_log, date_log_unix.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	$TeamMember = $this->db->prepare("INSERT INTO vip_team_members (id_team, id_img, firts_name, last_name, grado_academico, dependencia_academica, tipo_contratacion, hrs_semanales_dedicacion, date_log, date_log_unix) VALUES (:id_team,:id_img,:firts_name,:last_name,:grado_academico,:dependencia_academica,:tipo_contratacion,:hrs_semanales_dedicacion,:date_log,:date_log_unix)");

	    	#Se vinculan los valores con los parámetros.
	    	$TeamMember->bindValue(":id_team", 					$id_team);
	    	$TeamMember->bindValue(":id_img", 					1);

	    	$TeamMember->bindValue(":firts_name", 				$firstname);
	    	$TeamMember->bindValue(":last_name", 				$lastnames);
	    	$TeamMember->bindValue(":grado_academico", 			$grado_academico);
	    	$TeamMember->bindValue(":dependencia_academica", 	$dependencia_academica);
	    	$TeamMember->bindValue(":tipo_contratacion", 		$tipo_contratacion);
	    	$TeamMember->bindValue(":hrs_semanales_dedicacion", $hrs_semanales_dedicacion);

	    	$TeamMember->bindValue(":date_log", 				date('Y-n-j'));
	    	$TeamMember->bindValue(":date_log_unix", 			time());

	    	#Se agrega una nueva actividad sobre la acción.
	    	#Seguidamente se ejecuta la consulta preparada para agregar la información.
	    	if ($this->addActivity($usr, 33, "Creación de un miembro llamado: ".$firstname.", con ID de equipo: ".$id_team))
		    	if ($TeamMember->execute())
		    		return true; #Se retorna un valor booleano verdadero cuando ha salido todo bien.

		    #Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que elimina un miembro de equipo.
			*@param: $project_id (Identificador de la población).
		*/
	    public function delMemberTeamById($id_team, $id_member){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	$id_img = $id_member;

	    	#Statement: Consulta preparada. 
		    #Tabla: vip_team_members.
		    #Atributos: id_project.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_team_members '
                . 'WHERE id_member = :id_member');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':id_member', $id_member);

		    #Se hace uso de esta nueva y temporal conexión.
        	if ($this->addActivity(@$_SESSION['usr'], 35, "Eliminación de un miembro con ID: ".$id_member." del grupo con ID: ".$id_team)){
	        	if ($Reason->execute()){

	        		$ReasonTwo = $this->db->prepare('DELETE FROM vip_team_members_img '
                		. 'WHERE id = :id');

	        		#Se vincula el valor con el parámetro.
        			$ReasonTwo->bindValue(':id', $id_img);

	        		if ($ReasonTwo->execute()){
		       			return true;
	        		}
	        	}
        	}

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    /**
			* Método que agrega un miembro a un equipo de forma temporal, hasta que el usuario agregue toda la información.
			*@param: $id_team (ID del equipo), $folder (Ruta de almacenamiento), $src (Nombre del recurso).
		*/
	    public function addTeamMemberDataDefault($date_log, $date_log_unix){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_team_members.
	    	#Atributos: id_team, id_img, firts_name, last_name, grado_academico, dependencia_academica, tipo_contratacion, hrs_semanales_dedicacion, date_log, date_log_unix.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	$QImgTeamMember = $this->db->prepare("INSERT INTO vip_team_members (id_team, id_img, firts_name, last_name, grado_academico, dependencia_academica, tipo_contratacion, hrs_semanales_dedicacion, date_log, date_log_unix) VALUES (:id_team,:id_img,:firts_name,:last_name,:grado_academico,:dependencia_academica,:tipo_contratacion,:hrs_semanales_dedicacion,:date_log,:date_log_unix)");

	    	#Se vinculan los valores con los parámetros.
	    	$QImgTeamMember->bindValue(":id_team", 					1);
	    	$QImgTeamMember->bindValue(":id_img", 					0);

	    	$QImgTeamMember->bindValue(":firts_name", 				"");
	    	$QImgTeamMember->bindValue(":last_name", 				"");
	    	$QImgTeamMember->bindValue(":grado_academico", 			"");
	    	$QImgTeamMember->bindValue(":dependencia_academica", 	"");
	    	$QImgTeamMember->bindValue(":tipo_contratacion", 		"");
	    	$QImgTeamMember->bindValue(":hrs_semanales_dedicacion", "");

	    	$QImgTeamMember->bindValue(":date_log", 				$date_log);
	    	$QImgTeamMember->bindValue(":date_log_unix", 			$date_log_unix);

	    	#Se agrega una nueva actividad sobre la acción.
	    	#Seguidamente se ejecuta la consulta preparada para agregar la información.
	    	if ($this->addActivity($usr, 33, "Creación de un miembro con fecha: ".$date_log.", con valor decimal: ".$date_log_unix))
		    	if ($QImgTeamMember->execute())
		    		return true; #Se retorna un valor booleano verdadero cuando ha salido todo bien.

		    #Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que actualiza la información de un miembro de equipo.
			*@param: $id_team (ID del equipo), 
			*@param: $firstname, $lastnames, $grado_academico, $dependencia_academica, $tipo_contratacion, $hrs_semanales_dedicacion.
		*/
	    public function updateTeamMemberDataById($id_team, $firstname, $lastnames, $grado_academico, $dependencia_academica, $tipo_contratacion, $hrs_semanales_dedicacion){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada. 
	    	#Tabla: vip_team_members.
	    	#Atributos: id_team, firstname, lastnames, grado_academico, dependencia_academica, tipo_contratacion, hrs_semanales_dedicacion.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara una nueva consulta para obtener por medio de id_team, id_img, id_member.
	        if (is_array($this->getTeamMembers($id_team))){
	            #Se recorren los miembros registrados en un equipo en específico.
	            foreach ($this->getTeamMembers($id_team) as $ValueTeamMembers) {
	            	#Se verifica que nombres y apellidos se encuentren vacíos.
	                if ($ValueTeamMembers['firts_name'] == "" && $ValueTeamMembers['last_name'] == ""){
	                    $id_member  = $ValueTeamMembers['id_member'];	#Recuperando id_member;
	                    $id_img     = $ValueTeamMembers['id_img'];		#Recuperando id_img;

	                    #Query Img.
	                    $QImg = $this->getTeamMemberImgPerfilById($id_team, $id_img, "DESC", 1);
	                    
	                    #Se reconoce como Array asociativo.
	                    if (is_array($QImg)){
	                    	#Se recorre el array.
	                        foreach ($QImg as $value) {
	                        	#Se recuperan los datos, entre ellos el más importante, date_log_unix que es la marca de tiempo.
	                            $TeamDateLog        = $value['date_log'];
	                            $TeamDateLogUNIX    = $value['date_log_unix'];
	                        }
	                    } else if (is_bool($QImg)){
	                    	echo "Not found.";
	                    }
	                }
	            }
	        }

	        #Si está establecida la variable.
	        if (isset($TeamDateLogUNIX)){
	        	#Se agrega la instrucción SQL en la variable $Reason.
	    		$Reason = "UPDATE vip_team_members SET firts_name='".$firstname."', last_name='".$lastnames."', grado_academico='".$grado_academico."', dependencia_academica='".$dependencia_academica."', tipo_contratacion='".$tipo_contratacion."', hrs_semanales_dedicacion='".$hrs_semanales_dedicacion."' WHERE id_team=".$id_team." AND date_log_unix='".$TeamDateLogUNIX."'";
	        } else {
	        	#Si devuelve un valor true, todo bien y se retorna true.
	    		if ($this->addTeamMember($id_team, $firstname, $lastnames, $grado_academico, $dependencia_academica, $tipo_contratacion, $hrs_semanales_dedicacion)){
	    			return true;
	    		}
	        }

	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
	        	if ($this->addActivity($usr, 34, "Actualización de un miembro del equipo llamado: ".$firstname." ".$lastnames))
	    			return true;
			    
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que obtiene un miembro en específico de un equipo.
			*@param: $date_log_unix.
		*/
	    public function getTeamMemberByDateLogUNIX($date_log_unix){
	    	#Statement: Consulta no preparada.
		    #Tabla: vip_team_members.
		    #Atributos: date_log_unix.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_team_members WHERE date_log_unix='".$date_log_unix."' LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_member' 				=> $row['id_member'], 
	    				'id_team' 					=> $row['id_team'], 
	    				'id_img' 					=> $row['id_img'], 
	    				'firts_name' 				=> $row['firts_name'], 
	    				'last_name' 				=> $row['last_name'], 
	    				'grado_academico' 			=> $row['grado_academico'], 
	    				'dependencia_academica' 	=> $row['dependencia_academica'], 
	    				'tipo_contratacion' 		=> $row['tipo_contratacion'], 
	    				'hrs_semanales_dedicacion' 	=> $row['hrs_semanales_dedicacion'], 
	    				'date_log' 					=> $row['date_log'],
	    				'date_log_unix' 			=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene todos los miembros registrados.
			*@param: No hay.
		*/
	    public function getTeamMembers($id_team){
	    	@session_start();

	    	#Comprobación de la variable id_team y si está establecida la sesión id_team.
	    	if ($id_team == "" && !isset($_SESSION['id_team'])){

	    		#Se verifica que el método getTeamMembersLastOnly() devuelva información.
	    		if (is_array($this->getTeamMembersLastOnly())){

	    			#Se recorre la información.
	    			foreach ($this->getTeamMembersLastOnly() as $value) {
	    				#Valor del índice id_team capturado en la variable id_team.
	    				$id_team = $value['id_team'];
	    				@$_SESSION['id_team'] = $id_team;
	    			}

	    		} else if (is_bool($this->getTeamMembersLastOnly())){
	    			#Si no ha devuelto datos, entonces nuestro valor final es 1.
		    		return false;
	    		}
		    }

	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team_members.
		    #Atributos: No hay.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_team_members WHERE id_team=".$id_team." ORDER BY id_member DESC LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_member' 				=> $row['id_member'], 
	    				'id_team' 					=> $row['id_team'], 
	    				'id_img' 					=> $row['id_img'], 
	    				'firts_name' 				=> $row['firts_name'], 
	    				'last_name' 				=> $row['last_name'], 
	    				'grado_academico' 			=> $row['grado_academico'], 
	    				'dependencia_academica' 	=> $row['dependencia_academica'], 
	    				'tipo_contratacion' 		=> $row['tipo_contratacion'], 
	    				'hrs_semanales_dedicacion' 	=> $row['hrs_semanales_dedicacion'], 
	    				'date_log' 					=> $row['date_log'],
	    				'date_log_unix' 			=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene los miembros de todos los equipos.
			*@param: No hay.
		*/
	    public function getTeamMembersToAll(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team_members.
		    #Atributos: No hay.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_team_members;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_member' 				=> $row['id_member'], 
	    				'id_team' 					=> $row['id_team'], 
	    				'id_img' 					=> $row['id_img'], 
	    				'firts_name' 				=> $row['firts_name'], 
	    				'last_name' 				=> $row['last_name'], 
	    				'grado_academico' 			=> $row['grado_academico'], 
	    				'dependencia_academica' 	=> $row['dependencia_academica'], 
	    				'tipo_contratacion' 		=> $row['tipo_contratacion'], 
	    				'hrs_semanales_dedicacion' 	=> $row['hrs_semanales_dedicacion'], 
	    				'date_log' 					=> $row['date_log'],
	    				'date_log_unix' 			=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene los miembros de un equipo.
			*@param: No hay.
		*/
	    public function getTeamMembersAll($id_team){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team_members.
		    #Atributos: No hay.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_team_members WHERE id_team=".$id_team." ORDER BY id_member DESC;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_member' 				=> $row['id_member'], 
	    				'id_team' 					=> $row['id_team'], 
	    				'id_img' 					=> $row['id_img'], 
	    				'firts_name' 				=> $row['firts_name'], 
	    				'last_name' 				=> $row['last_name'], 
	    				'grado_academico' 			=> $row['grado_academico'], 
	    				'dependencia_academica' 	=> $row['dependencia_academica'], 
	    				'tipo_contratacion' 		=> $row['tipo_contratacion'], 
	    				'hrs_semanales_dedicacion' 	=> $row['hrs_semanales_dedicacion'], 
	    				'date_log' 					=> $row['date_log'],
	    				'date_log_unix' 			=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el último miembro registrado.
			*@param: No hay.
		*/
	    public function getTeamMembersLastOnly(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team_members.
		    #Atributos: No hay.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_team_members ORDER BY id_member DESC LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_member' 				=> $row['id_member'], 
	    				'id_team' 					=> $row['id_team'], 
	    				'id_img' 					=> $row['id_img'], 
	    				'firts_name' 				=> $row['firts_name'], 
	    				'last_name' 				=> $row['last_name'], 
	    				'grado_academico' 			=> $row['grado_academico'], 
	    				'dependencia_academica' 	=> $row['dependencia_academica'], 
	    				'tipo_contratacion' 		=> $row['tipo_contratacion'], 
	    				'hrs_semanales_dedicacion' 	=> $row['hrs_semanales_dedicacion'], 
	    				'date_log' 					=> $row['date_log'],
	    				'date_log_unix' 			=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que actualiza la información de un miembro de equipo.
			*@param: $id_member (Identificador del miembro de equipo), $id_team (ID del equipo), $id_img (ID de imagen de perfil).
		*/
	    public function updateTeamMemberById($id_member, $id_team, $id_img){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada. 
	    	#Tabla: vip_team_members.
	    	#Atributos: id_member, id_team, id_img.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara la consulta.
	    	$Reason = "UPDATE vip_team_members SET id_team='".$id_team."', id_img='".$id_img."' WHERE id_member='".$id_member."'";
	    	
	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
	        	if ($this->addActivity($usr, 34, "Actualización de un miembro de equipo con ID: ".$id_member))
	    			return true;
			    
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que obtiene la imagen de perfil de un miembro de equipo identificado.
			*@param: $id_img.
		*/
	    public function getTeamMemberImgPerfilById($id_team, $id_img, $Order, $Limit){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team_members_img.
		    #Atributos: id_img.
		    #Valores devueltos: Todos los datos posibles (*).

		    if ($id_img == "" && !isset($_SESSION['id_img_member'])){
		    	$id_img = 1;
		    }

	    	$stmt = $this->db->query("SELECT * FROM vip_team_members_img WHERE id_team=".$id_team." AND id=".$id_img." ORDER BY date_log_unix ".$Order." LIMIT ".$Limit.";");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id' 				=> $row['id'], 
	    				'id_team' 			=> $row['id_team'], 
	    				'id_member' 		=> $row['id_member'], 
	    				'folder' 			=> $row['folder'], 
	    				'src' 				=> $row['src'], 
	    				'date_log' 			=> $row['date_log'],
	    				'date_log_unix' 	=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene la imagen de perfil de un miembro de equipo.
			*@param: $date_log_unix.
		*/
	    public function getTeamMemberImgPerfilByDateLogUNIX($date_log_unix){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team_members_img.
		    #Atributos: date_log_unix.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_team_members_img WHERE date_log_unix='".$date_log_unix."' LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id' 				=> $row['id'], 
	    				'id_team' 			=> $row['id_team'], 
	    				'id_member' 		=> $row['id_member'], 
	    				'folder' 			=> $row['folder'], 
	    				'src' 				=> $row['src'], 
	    				'date_log' 			=> $row['date_log'],
	    				'date_log_unix' 	=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega una imagen a un miembro de un equipo.
			*@param: $id_team (ID del equipo), $folder (Ruta de almacenamiento), $src (Nombre del recurso).
		*/
	    public function addTeamMemberImgPerfil($id_team, $folder, $src){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Se limpia el nombre del recurso.
	    	$src = $this->CleanString($src);

	    	$date_log 		= date('Y-n-j');
	    	$date_log_unix 	= time();

	    	#Aperturando el integrante o miembro de equipo, para luego obtener el ID asignado.
	    	#La orientación se estará ejecutando con el valor decimal date_log_unix.
	    	if ($this->addTeamMemberDataDefault($date_log, $date_log_unix)){

	    		#Obtener la información anteriormente almacenada en este registro del miembro. 
	    		#Extrae la información por el date_log_unix que fue agregado para identificar.
	    		if (is_array($this->getTeamMemberByDateLogUNIX($date_log_unix))){

	    			#Recorriendo los valores que devuelve el array.
	    			foreach ($this->getTeamMemberByDateLogUNIX($date_log_unix) as $value) {
	    				#Obteniendo el valor id_member;
	    				$id_member = $value['id_member'];

				    	#Statement: Consulta preparada. 
				    	#Tabla: vip_team_members_img.
				    	#Atributos: id_team, id_member, folder, src, date_log, date_log_unix.
				    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

				    	$QImgTeamMember = $this->db->prepare("INSERT INTO vip_team_members_img (id_team, id_member, folder, src, date_log, date_log_unix) VALUES (:id_team,:id_member,:folder,:src,:date_log,:date_log_unix)");

				    	#Se vinculan los valores con los parámetros.
				    	$QImgTeamMember->bindValue(":id_team", 			$id_team);
				    	$QImgTeamMember->bindValue(":id_member", 		$id_member);
				    	$QImgTeamMember->bindValue(":folder", 			$folder);
				    	$QImgTeamMember->bindValue(":src", 				$src);
				    	$QImgTeamMember->bindValue(":date_log", 		$date_log);
				    	$QImgTeamMember->bindValue(":date_log_unix", 	$date_log_unix);

				    	#Se agrega una nueva actividad sobre la acción.
				    	#Seguidamente se ejecuta la consulta preparada para agregar la información.
				    	if ($this->addActivity($usr, 32, "Actualizando la imagen de un integrante de equipo con ID: ".$id_member." con ID de equipo: ".$id_team)){
					    	
				    		#Ejecutando la consulta.
					    	if ($QImgTeamMember->execute()){

					    		#Comprobando la información devuelta por el método.
					    		if (is_array($this->getTeamMemberImgPerfilByDateLogUNIX($date_log_unix))){

					    			#Recorriendo la información.
					    			foreach ($this->getTeamMemberImgPerfilByDateLogUNIX($date_log_unix) as $TMIP) {
					    				#Asignando el ID de la imagen de perfil de un miembro de equipo a id_img.
					    				$id_img = $TMIP['id'];

					    				#Agregando una variable de global.
					    				@$_SESSION['id_img_member'] = $id_img;

							    		#Actualizando un miembro de equipo con id_member, agregando id_team y id_img.
							    		if ($this->updateTeamMemberById($id_member, $id_team, $id_img)){
							    			return true; #Se retorna un valor booleano verdadero cuando ha salido todo bien.
							    		}

					    			}

					    		} else if ($this->getTeamMemberImgPerfilByDateLogUNIX($date_log_unix)){
					    			return false;
					    		}
					    	}
				    	}
	    			}
	    		} else if (is_bool($this->getTeamMemberByDateLogUNIX($date_log_unix))){
	    			return false;
	    		}
	    	}

		    #Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	     /**
			* Método que recupera la información del último registro en team_img.
			*@param: $id_team (ID del equipo), $Order (La forma de ordenar la info.), $Quantity (Límite de registros).
		*/
	    public function getTeamImgPerfil($id_team, $Order, $Quantity){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_team_img.
		    #Atributos: id_team, cláusula LIMIT.
		    #Valores devueltos: Todos los datos posibles (*).

		   	@session_start();

	    	if ($id_team == "" && !isset($_SESSION['id_team'])) 
		    	$id_team = 1;

	    	@$stmt = $this->db->query("SELECT * FROM vip_team_img WHERE id_team=".$id_team." ORDER BY id ".$Order." LIMIT ".$Quantity);

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UserImgPerfil = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UserImgPerfil[] = [
	    				'id' 			=> $row['id'],
	    				'id_team' 		=> $row['id_team'],
	    				'folder'		=> $row['folder'],
	    				'src'			=> $row['src'],
	    				'date_log' 		=> $row['date_log'],
	    				'date_log_unix' => $row['date_log_unix'] 
	    			];
	    		}

	    		#Se retorna la información capturada en el array.
	    		return $UserImgPerfil;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }


	    /**
			* Método que agrega el informe final del proyecto.
			*@param: $id_project (Identificador del proyecto), $content (Contenido, redacción, informe).
		*/
		public function addProjectResult($id_project, $content){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada.
	    	#Tabla: vip_informe_final.
	    	#Atributos: id_project,  otros.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara la consulta.
	    	$Reason = "UPDATE vip_informe_final SET otros='".$content."' WHERE id_project='".$id_project."'";
	    	
	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
        		if ($this->addActivity($usr, 29, "Modificando el informe final del proyecto con ID: ".$id_project))
	    			return true;
			    
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que obtiene un ID de Proyecto con respecto a un título y último en haberse agregado.
			*@param: $name (Nombre del proyecto).
		*/
	    public function getProyectoOnlyLastID($name){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_proyecto.
		    #Atributos: nombre.
		    #Valores devueltos: id_project.

	    	$stmt = $this->db->query("SELECT * FROM vip_proyecto WHERE nombre='".$name."' ORDER BY id_project DESC LIMIT 1");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$getData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$getData[] = [
	    				'id_project' => $row['id_project']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo id_project.
	    		foreach ($getData as $value) {

	    			#Se retorna el valor que contiene el índice: id_project.
	    			return $value['id_project'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega la Zona Geográfica de los beneficiarios del Proyecto.
			*@param: $id_project (Identificador del proyecto), $IDComunidadPoblacion (Identificador), $PersonasAtendidas (Cantidad), $ZonaGeografica (Lugar).
		*/
	    public function addProyectoZonaGeograficaBeneficiarios($id_project, $IDComunidadPoblacion, $PersonasAtendidas, $ZonaGeografica){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_zona_geografica_beneficiarios.
	    	#Atributos: id_project, id_comunidad_poblacion, cantidad_personas_atendidas, nombre_zona_geografica.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_zona_geografica_beneficiarios (id_project, id_comunidad_poblacion, cantidad_personas_atendidas, nombre_zona_geografica) VALUES (:id_project,:id_comunidad_poblacion,:cantidad_personas_atendidas,:nombre_zona_geografica);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":id_project", 					$id_project);
	    	$stmt->bindValue(":id_comunidad_poblacion", 		$IDComunidadPoblacion);
	    	$stmt->bindValue(":cantidad_personas_atendidas", 	$PersonasAtendidas);
	    	$stmt->bindValue(":nombre_zona_geografica", 		$ZonaGeografica);

	    	#Agregando la descripción completa de la nueva actividad.
	    	$description = "Agregando Zonas geográficas de los beneficiarios del proyecto con ID: ".$id_project;

		    if ($stmt->execute()) { #Se ejecuta la consulta preparada.
        		if ($this->addActivity(@$_SESSION['usr'], 19, $description)) #Agrega una actividad.
		    		return true; #Si se ha llegado hasta acá, es un resultado correcto.
		    }
	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que actualiza la información de la Zona Geográfica de los beneficiarios de un proyecto.
			*@param: $id_project (Identificador del proyecto), $IDComunidadPoblacion (Identificador), $PersonasAtendidas (Cantidad), $ZonaGeografica (Lugar).
		*/
	    public function updateProyectoZonaGeograficaBeneficiarios($id_project, $IDComunidadPoblacion, $PersonasAtendidas, $ZonaGeografica){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada.
	    	#Tabla: vip_zona_geografica_beneficiarios.
	    	#Atributos: id_project,  id_comunidad_poblacion, cantidad_personas_atendidas, nombre_zona_geografica.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara la consulta.
	    	$Reason = "UPDATE vip_zona_geografica_beneficiarios SET id_comunidad_poblacion='".$IDComunidadPoblacion."', cantidad_personas_atendidas='".$PersonasAtendidas."', nombre_zona_geografica='".$ZonaGeografica."' WHERE id_project='".$id_project."'";
	    	
	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
        		if ($this->addActivity($usr, 25, "Actualización de Zona Geográfica de beneficiarios sobre un Proyecto con ID: ".$id_project))
	    			return true;
			    
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que obtiene la información de Zonas geográficas de beneficiarios de un proyecto en específico por ID.
			*@param: id_project (Identificador del proyecto).
		*/
	    public function getProyectoZonaGeoBeneficiariosOnlyById($id_project){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_zona_geografica_beneficiarios.
		    #Atributos: id_project
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_zona_geografica_beneficiarios WHERE id_project='".$id_project."' LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_project' 					=> $row['id_project'], 
	    				'id_comunidad_poblacion' 		=> $row['id_comunidad_poblacion'],
	    				'cantidad_personas_atendidas' 	=> $row['cantidad_personas_atendidas'],
	    				'nombre_zona_geografica'		=> $row['nombre_zona_geografica']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega la Temporalidad del Proyecto.
			*@param: $id_project (Identificador del proyecto), $DuracionMeses.
			*@param: $FechaInicio, $FechaFinalizacion, $FechaMonitoreo.
		*/
	    public function addProyectoTemporalidad($id_project, $DuracionMeses, $FechaInicio, $FechaFinalizacion, $FechaMonitoreo){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_temporalidad_proyecto.
	    	#Atributos: id_project, duracion_meses, fecha_inicio, fecha_finalizacion, fecha_monitoreo.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_temporalidad_proyecto (id_project, duracion_meses, fecha_inicio, fecha_finalizacion, fecha_monitoreo) VALUES (:id_project,:duracion_meses,:fecha_inicio,:fecha_finalizacion,:fecha_monitoreo);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":id_project", 					$id_project);
	    	$stmt->bindValue(":duracion_meses", 				$DuracionMeses);
	    	$stmt->bindValue(":fecha_inicio", 					$FechaInicio);
	    	$stmt->bindValue(":fecha_finalizacion", 			$FechaFinalizacion);
	    	$stmt->bindValue(":fecha_monitoreo", 				$FechaMonitoreo);

	    	#Agregando la descripción completa de la nueva actividad.
	    	$description = "Agregando la Temporalidad del proyecto con ID: ".$id_project;

		    if ($stmt->execute()) { #Se ejecuta la consulta preparada.
        		if ($this->addActivity(@$_SESSION['usr'], 20, $description)) #Agrega una actividad.
		    		return true; #Si se ha llegado hasta acá, es un resultado correcto.
		    }
	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que actualiza la Temporalidad del Proyecto.
			*@param: $id_project (Identificador del proyecto), $DuracionMeses.
			*@param: $FechaInicio, $FechaFinalizacion, $FechaMonitoreo.
		*/
	    public function updateProyectoTemporalidad($id_project, $DuracionMeses, $FechaInicio, $FechaFinalizacion, $FechaMonitoreo){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada.
	    	#Tabla: vip_temporalidad_proyecto.
	    	#Atributos: id_project,  duracion_meses, fecha_inicio, fecha_finalizacion, fecha_monitoreo.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara la consulta.
	    	$Reason = "UPDATE vip_temporalidad_proyecto SET duracion_meses='".$DuracionMeses."', fecha_inicio='".$FechaInicio."', fecha_finalizacion='".$FechaFinalizacion."', fecha_monitoreo='".$FechaMonitoreo."' WHERE id_project='".$id_project."'";
	    	
	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
        		if ($this->addActivity($usr, 26, "Actualización de temporalidad sobre un Proyecto con ID: ".$id_project))
	    			return true;
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que obtiene la información de temporalidad de un proyecto en específico por ID.
			*@param: id_project (Identificador del proyecto).
		*/
	    public function getProyectoTemporalidadOnlyById($id_project){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_temporalidad_proyecto.
		    #Atributos: id_project
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_temporalidad_proyecto WHERE id_project='".$id_project."' LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_project' 			=> $row['id_project'], 
	    				'duracion_meses' 		=> $row['duracion_meses'],
	    				'fecha_inicio' 			=> $row['fecha_inicio'],
	    				'fecha_finalizacion'	=> $row['fecha_finalizacion'],
	    				'fecha_monitoreo' 		=> $row['fecha_monitoreo']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene la información financiera de un proyecto en específico por ID.
			*@param: id_project (Identificador del proyecto).
		*/
	    public function getProyectoFinancieraOnlyById($id_project){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_informacion_financiera.
		    #Atributos: id_project
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_informacion_financiera WHERE id_project='".$id_project."' LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_project' 		=> $row['id_project'], 
	    				'nombre_organismo' 	=> $row['nombre_organismo'],
	    				'monto_financiado' 	=> $row['monto_financiado'],
	    				'aporte_unan'		=> $row['aporte_unan'],
	    				'moneda'			=> $row['moneda']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene los resultados de un proyecto en específico por ID.
			*@param: id_project (Identificador del proyecto).
		*/
	    public function getProyectoResultadosOnlyById($id_project){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_info_resultados_proyecto.
		    #Atributos: id_project
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_info_resultados_proyecto WHERE id_project='".$id_project."' LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_project' 		=> $row['id_project'], 
	    				'tipo_publicacion' 	=> $row['tipo_publicacion'],
	    				'datos_publicacion' => $row['datos_publicacion'],
	    				'otros_resultados'	=> $row['otros_resultados']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega la Información financiera del Proyecto.
			*@param: $id_project (Identificador del proyecto), $NombreOrganismo.
			*@param: $MontoFinanciado, $AporteUNAN (Aporte de la universidad).
		*/
	    public function addProyectoInformacionFinanciera($id_project, $NombreOrganismo, $MontoFinanciado, $AporteUNAN, $ProMoneda){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_informacion_financiera.
	    	#Atributos: id_project, nombre_organismo, monto_financiado, aporte_unan.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_informacion_financiera (id_project, nombre_organismo, monto_financiado, aporte_unan, moneda) VALUES (:id_project,:nombre_organismo,:monto_financiado,:aporte_unan,:moneda);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":id_project", 			$id_project);
	    	$stmt->bindValue(":nombre_organismo", 		$NombreOrganismo);
	    	$stmt->bindValue(":monto_financiado", 		$MontoFinanciado);
	    	$stmt->bindValue(":aporte_unan", 			$AporteUNAN);
	    	$stmt->bindValue(":moneda", 				$ProMoneda);

	    	#Agregando la descripción completa de la nueva actividad.
	    	$description = "Agregando la información financiera del proyecto con ID: ".$id_project;

		    if ($stmt->execute()) { #Se ejecuta la consulta preparada.
        		if ($this->addActivity(@$_SESSION['usr'], 21, $description)) #Agrega una actividad.
		    		return true; #Si se ha llegado hasta acá, es un resultado correcto.
		    }
	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que actualiza la información financiera del Proyecto.
			*@param: $id_project (Identificador del proyecto), $NombreOrganismo.
			*@param: $MontoFinanciado, $AporteUNAN (Aporte de la universidad).
		*/
	    public function updateProyectoInformacionFinanciera($id_project, $NombreOrganismo, $MontoFinanciado, $AporteUNAN, $ProMoneda){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada.
	    	#Tabla: vip_informacion_financiera.
	    	#Atributos: id_project,  nombre_organismo, monto_financiado, aporte_unan.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara la consulta.
	    	$Reason = "UPDATE vip_informacion_financiera SET nombre_organismo='".$NombreOrganismo."', monto_financiado='".$MontoFinanciado."', aporte_unan='".$AporteUNAN."', moneda='".$ProMoneda."' WHERE id_project='".$id_project."'";
	    	
	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
        		if ($this->addActivity($usr, 27, "Actualización de la información financiera sobre un Proyecto con ID: ".$id_project))
	    			return true;
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    /**
			* Método que agrega la información de resultados del Proyecto.
			*@param: $id_project (Identificador del proyecto), $TipoPublicacion.
			*@param: $DatosPublicacion, $OtrosDatos.
		*/
	    public function addProyectoResultados($id_project, $TipoPublicacion, $DatosPublicacion, $OtrosDatos){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_info_resultados_proyecto.
	    	#Atributos: id_project, tipo_publicacion, datos_publicacion, otros_resultados.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_info_resultados_proyecto (id_project, tipo_publicacion, datos_publicacion, otros_resultados) VALUES (:id_project,:tipo_publicacion,:datos_publicacion,:otros_resultados);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":id_project", 			$id_project);
	    	$stmt->bindValue(":tipo_publicacion", 		$TipoPublicacion);
	    	$stmt->bindValue(":datos_publicacion", 		$DatosPublicacion);
	    	$stmt->bindValue(":otros_resultados", 		$OtrosDatos);

	    	#Agregando la descripción completa de la nueva actividad.
	    	$description = "Agregando información de resultados del proyecto con ID: ".$id_project;

		    if ($stmt->execute()) { #Se ejecuta la consulta preparada.
        		if ($this->addActivity(@$_SESSION['usr'], 22, $description)) #Agrega una actividad.
		    		return true; #Si se ha llegado hasta acá, es un resultado correcto.
		    }
	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega la información de resultados del Proyecto.
			*@param: $id_project (Identificador del proyecto), $TipoPublicacion.
			*@param: $DatosPublicacion, $OtrosDatos.
		*/
	    public function updateProyectoResultados($id_project, $TipoPublicacion, $DatosPublicacion, $OtrosDatos){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	$usr = @$_SESSION['usr'];

	    	#Statement: Consulta no preparada.
	    	#Tabla: vip_info_resultados_proyecto.
	    	#Atributos: id_project, tipo_publicacion, datos_publicacion, otros_resultados.
	    	#Valores devueltos: Ninguno ya que se trata de actualizar datos.

	    	#Se prepara la consulta.
	    	$Reason = "UPDATE vip_info_resultados_proyecto SET tipo_publicacion='".$TipoPublicacion."', datos_publicacion='".$DatosPublicacion."', otros_resultados='".$OtrosDatos."' WHERE id_project='".$id_project."'";
	    	
	    	#Se ejecuta.
	    	$Execution = $this->db->query($Reason);

	    	#Se observa el dato devuelto, si es 1 o true, todo ha salido correctamente.
	    	if ($Execution){
	        	#Se crea una nueva actividad.
        		if ($this->addActivity($usr, 28, "Actualización de los resultados sobre un Proyecto con ID: ".$id_project))
	    			return true;
	    	}

		    #Se devuelve un valor booleano falso cuando algo ha fallado.
		    return false;
	    }

	    #####################################################################################
	    #										FIN 										#
	    #####################################################################################


	    #####################################################################################
	    #										INICIO 										#
	    #####################################################################################
	    #			Métodos utilizados para gestionar Comunidades o Población.				#
	    #####################################################################################
	    /**
			* Método que obtiene las Comunidades o Población.
			*@param: No hay.
		*/
	    public function getProjectComunidadPoblacion(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_import_municipios.
		    #Atributos: -
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_import_municipios ORDER BY cod_muni DESC;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'cod_muni' 		=> $row['cod_muni'], 
	    				'nombre_muni' 	=> $row['nombre_muni'],
	    				'cod_dpto' 		=> $row['cod_dpto']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el campo cod_muni del último registro de la tabla vip_import_municipios.
			*@param: No hay.
		*/
	    public function getOnlyLastCodeComunidadPoblacion(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_import_municipios.
		    #Atributos: cod_muni.
		    #Valores devueltos: Todo los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_import_municipios ORDER BY cod_muni DESC LIMIT 1");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$getData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$getData[] = [
	    				'cod_muni' => $row['cod_muni']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo cod_muni.
	    		foreach ($getData as $value) {

	    			#Se retorna el valor que contiene el índice: cod_muni.
	    			return $value['cod_muni'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el nombre del municipio correspondiente a un identificador.
			*@param: $id (Identificador de la comunidad).
		*/
	    public function getOnlyComunidadPoblacion($id){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_import_municipios.
		    #Atributos: cod_muni.
		    #Valores devueltos: Todo los posibles (*).

	    	$stmt = $this->db->query("SELECT nombre_muni FROM vip_import_municipios WHERE cod_muni='".$id."'");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$getData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$getData[] = [
	    				'nombre_muni' => $row['nombre_muni']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo nombre_muni.
	    		foreach ($getData as $value) {

	    			#Se retorna el valor que contiene el índice: nombre_muni.
	    			return $value['nombre_muni'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega una Comunidad o Población.
			*@param: $name (Nombre).
		*/
	    public function addComunidadPoblacion($name){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_import_municipios.
	    	#Atributos: cod_muni, nombre_muni, cod_dpto.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_import_municipios (cod_muni, nombre_muni, cod_dpto) VALUES (:cod_muni,:nombre_muni,:cod_dpto);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":cod_muni", 		$this->getOnlyLastCodeComunidadPoblacion() + 1);
	    	$stmt->bindValue(":nombre_muni", 	$name);
	    	$stmt->bindValue(":cod_dpto", 		2);

	    	#Agregando la descripción completa de la nueva actividad.
	    	$description = "Agregando una nueva Comunidad | Población: ".$name." con ID: ".($this->getOnlyLastCodeComunidadPoblacion() + 1);

		    if ($stmt->execute()) { #Se ejecuta la consulta preparada.
		    	#Creando una nueva conexión, distinta base de datos.
		    	$Connection = CDB("vip");

		    	#Se hace uso de esta nueva y temporal conexión.
        		if ($Connection->addActivity(@$_SESSION['usr'], 15, $description)) #Agrega una actividad.
		    		return true; #Si se ha llegado hasta acá, es un resultado correcto.
		    }
	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que elimina una Comunidad | Población.
			*@param: $id (Identificador de la población).
		*/
	    public function deleteComunidadPoblacion($id){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
		    #Tabla: vip_import_municipios.
		    #Atributos: id.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_import_municipios '
                . 'WHERE cod_muni = :cod_muni');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':cod_muni', $id);

        	#Creando una nueva conexión, distinta base de datos.
		    $Connection = CDB("vip");

		    #Se hace uso de esta nueva y temporal conexión.
        	if ($Connection->addActivity(@$_SESSION['usr'], 16, "Eliminando la Comunidad | Población con ID: ".$id." y nombre: ".$this->getOnlyComunidadPoblacion($id))) #Agrega una actividad.
	        	if ($Reason->execute()) #Se ejecuta la consulta.
		       		return true; #Buen resultado.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    #####################################################################################
	    #										FIN 										#
	    #####################################################################################
	    

	    #####################################################################################
	    #										INICIO 										#
	    #####################################################################################
	    #			Métodos utilizados para gestionar Facultad | CUR | Escuela.				#
	    #####################################################################################
	    /**
			* Método que obtiene las vip_import_facultades, Curs o Escuelas.
			*@param: No hay.
		*/
	    public function getProjectFacCurEsc(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_import_facultades.
		    #Atributos: -
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_import_facultades ORDER BY codigo_facultad DESC;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'codigo_facultad' 	=> $row['codigo_facultad'], 
	    				'nombrefac' 		=> $row['nombrefac']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el campo codigo_facultad del último registro de la tabla vip_import_facultades.
			*@param: No hay.
		*/
	    public function getOnlyLastCodeFacCurEsc(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_import_facultades.
		    #Atributos: username.
		    #Valores devueltos: Todo los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_import_facultades ORDER BY codigo_facultad DESC LIMIT 1");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$getData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$getData[] = [
	    				'codigo_facultad' => $row['codigo_facultad']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo codigo_facultad.
	    		foreach ($getData as $value) {

	    			#Se retorna el valor que contiene el índice: codigo_facultad.
	    			return $value['codigo_facultad'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el nombre de la facultad correspondiente a un identificador.
			*@param: $id (Identificador de la facultad).
		*/
	    public function getOnlyFacCurEsc($id){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_import_facultades.
		    #Atributos: username.
		    #Valores devueltos: Todo los posibles (*).

	    	$stmt = $this->db->query("SELECT nombrefac FROM vip_import_facultades WHERE codigo_facultad='".$id."'");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$getData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$getData[] = [
	    				'nombrefac' => $row['nombrefac']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo nombrefac.
	    		foreach ($getData as $value) {

	    			#Se retorna el valor que contiene el índice: nombrefac.
	    			return $value['nombrefac'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega una Facultad | Cur | Escuela.
			*@param: $name (Nombre).
		*/
	    public function addFacCurEsc($name){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_import_facultades.
	    	#Atributos: codigo_facultad, nombrefac.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_import_facultades (codigo_facultad, nombrefac) VALUES (:codigo_facultad,:nombrefac);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":codigo_facultad", 	$this->getOnlyLastCodeFacCurEsc() + 1);
	    	$stmt->bindValue(":nombrefac", 			$name);

	    	#Agregando la descripción completa de la nueva actividad.
	    	$description = "Agregando una nueva Facultad | Cur | Escuela: ".$name." con ID: ".($this->getOnlyLastCodeFacCurEsc() + 1);

		    if ($stmt->execute()) { #Se ejecuta la consulta preparada.
		    	#Creando una nueva conexión, distinta base de datos.
		    	$Connection = CDB("vip");

		    	#Se hace uso de esta nueva y temporal conexión.
        		if ($Connection->addActivity(@$_SESSION['usr'], 13, $description)) #Agrega una actividad.
		    		return true; #Si se ha llegado hasta acá, es un resultado correcto.
		    }
	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que elimina una Facultad | Cur | Escuela.
			*@param: $id (Identificador de la facultad).
		*/
	    public function deleteFacCurEsc($id){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
		    #Tabla: vip_tmp_img.
		    #Atributos: id.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_import_facultades '
                . 'WHERE codigo_facultad = :codigo_facultad');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':codigo_facultad', $id);

        	#Creando una nueva conexión, distinta base de datos.
		    $Connection = CDB("vip");

		    #Se hace uso de esta nueva y temporal conexión.
        	if ($Connection->addActivity(@$_SESSION['usr'], 14, "Eliminando la Facultad | Cur | Escuela con ID: ".$id." y nombre: ".$this->getOnlyFacCurEsc($id))) #Agrega una actividad.
	        	if ($Reason->execute()) #Se ejecuta la consulta.
		       		return true; #Buen resultado.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    #####################################################################################
	    #										FIN 										#
	    #####################################################################################
	    

	    #####################################################################################
	    #										INICIO 										#
	    #####################################################################################
	    #			Métodos utilizados para gestionar Instancias de aprobación.				#
	    #####################################################################################

	    /**
			* Método que obtiene las instancias de aprobación del proyecto.
			*@param: No hay.
		*/
	    public function getProjectInstanciaAprobacion(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_proyecto_instancia_aprob.
		    #Atributos: -
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_proyecto_instancia_aprob;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id' 							=> $row['id'], 
	    				'nombre_instancia_aprobacion' 	=> $row['nombre_instancia_aprobacion']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene el nombre de la instancia de aprobación especificando el ID.
			*@param: $id (Identificador de la instancia de aprobación).
		*/
	    public function getOnlyInstanciaAprobacion($id){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_proyecto_instancia_aprob.
		    #Atributos: username.
		    #Valores devueltos: nombre_instancia_aprobacion.

	    	$stmt = $this->db->query("SELECT nombre_instancia_aprobacion FROM vip_proyecto_instancia_aprob WHERE id='".$id."'");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$getData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$getData[] = [
	    				'nombre_instancia_aprobacion' => $row['nombre_instancia_aprobacion']
	    			];
	    		}

	    		#Se recorre el Array multidimensional para obtener la información y retornarla.
	    		#Se obtiene precisamente el campo nombre_instancia_aprobacion.
	    		foreach ($getData as $value) {

	    			#Se retorna el valor que contiene el índice: nombre_instancia_aprobacion.
	    			return $value['nombre_instancia_aprobacion'];
	    		}
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega una instancia de aprobación del proyecto.
			*@param: $instancia (Nombre de la instancia de aprobación).
		*/
	    public function addInstanciaAprobacion($instancia){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
	    	#Tabla: vip_proyecto_instancia_aprob.
	    	#Atributos: nombre_instancia_aprobacion, date_log, date_log_unix.
	    	#Valores devueltos: Ninguno ya que se trata de insertar datos.

	    	#Se alamacenan las instrucciones en esta variable.
	    	$q = "INSERT INTO vip_proyecto_instancia_aprob (nombre_instancia_aprobacion, date_log, date_log_unix) VALUES (:nombre_instancia_aprobacion,:date_log,:date_log_unix);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vincula un valor a un parámetro.
	    	$stmt->bindValue(":nombre_instancia_aprobacion", 	$instancia);
	    	$stmt->bindValue(":date_log", 						date('Y-n-j'));
	    	$stmt->bindValue(":date_log_unix", 					time());

	    	#Agregando una nueva actividad.
        	if ($this->addActivity(@$_SESSION['usr'], 11, "Agregando una nueva instancia de aprobación llamada: ".$instancia)) #Agrega una actividad.
		    	if ($stmt->execute()) #Se ejecuta la consulta preparada.
		    		return true; #Si se ha llegado hasta acá, es un resultado correcto.

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que elimina una instancia.
			*@param: $id (Identificador de la instancia).
		*/
	    public function deleteInstanciaAprobacion($id){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
		    #Tabla: vip_proyecto_instancia_aprob.
		    #Atributos: id.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_proyecto_instancia_aprob '
                . 'WHERE id = :id');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':id', $id);

        	#Agregando una nueva actividad.
        	if ($this->addActivity(@$_SESSION['usr'], 12, "Eliminando la instancia de aprobación con ID: ".$id." y nombre: ".$this->getOnlyInstanciaAprobacion($id))) #Agrega una actividad.
	        	if ($Reason->execute()) #Se ejecuta la consulta.
		       		return true; #Buen resultado.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    #####################################################################################
	    #										FIN 										#
	    #####################################################################################


	    #####################################################################################
	    #										INICIO 										#
	    #####################################################################################
	    #			Métodos utilizados para gestionar las imágenes almacenadas.				#
	    #####################################################################################
	    /**
			* Método que obtiene las imágenes temporales con respecto al usuario logueado.
			*@param: $usr (Nombre de usuario).
		*/
	    public function getTmpImg($usr){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_tmp_img.
		    #Atributos: username.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_tmp_img WHERE username='".$usr."';");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id' 			=> $row['id'], 
	    				'username' 		=> $row['username'], 
	    				'folder' 		=> $row['folder'], 
	    				'src' 			=> $row['src'],
	    				'date_log' 		=> $row['date_log'],
	    				'date_log_unix' => $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que elimina la imagen temporal apuntada.
			*@param: $src (Recurso de la imagen: nombre).
		*/
	    public function deleteTmpImg($src){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_tmp_img.
		    #Atributos: src.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_tmp_img '
                . 'WHERE src = :src');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':src', $src);

        	#Se ejecuta la consulta.
        	if ($Reason->execute())
	       		return true; #Buen resultado.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    /**
			* Método que obtiene la imagen temporal con respecto a un usuario.
			*@param: $usr (Nombre de usuario), $src (Recurso de la imagen: nombre).
		*/
	    public function getTmpImgUnique($usr, $src){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_tmp_img.
		    #Atributos: src, username.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_tmp_img WHERE src='".$src."' AND username='".$usr."' LIMIT 1;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id' 			=> $row['id'], 
	    				'folder' 		=> $row['folder'], 
	    				'src' 			=> $row['src'],
	    				'date_log' 		=> $row['date_log'],
	    				'date_log_unix' => $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega una imagen temporal con respecto al usuario.
			*@param: $usr (Nombre de usuario), $folder (Directorio donde se almacenan los recursos), $src (Recurso de la imagen: nombre).
		*/
		public function addTmpImg($usr, $folder, $src){
			#Statement: Consulta preparada. 
		    #Tabla: vip_tmp_img.
		    #Atributos: username, folder, src, date_log, date_log_unix.
		    #Valores devueltos: No devuelve ya que se intenta INSERTAR.

			#Variable que almacena las instrucciones de la consulta.
	    	$q = "INSERT INTO vip_tmp_img (username, folder, src, date_log, date_log_unix) VALUES (:username,:folder,:src,:date_log,:date_log_unix);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vinculan los valores con los parámetros.
	    	$stmt->bindValue(":username", 		$usr);
	    	$stmt->bindValue(":folder", 		$folder);
	    	$stmt->bindValue(":src", 			$src);
	    	$stmt->bindValue(":date_log", 		date('Y-n-j'));
	    	$stmt->bindValue(":date_log_unix", 	time());

	    	#Se ejecuta la consulta preparada.
	    	if ($stmt->execute())
	    		return true;	#Todo bien.

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene los coordinadores de equipos.
			*@param: No hay.
		*/
	    public function getCoordinators(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_coordinate.
		    #Atributos: No hay.
		    #Valores devueltos: Todos los datos posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_coordinate;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Definición de un array multidimensional.
	    		$getData = [];

	    		#Se recorren todos los registros.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se asocian los resultados.
	    			$getData[] = [
	    				'id_coord' 			=> $row['id_coord'], 
	    				'id_member' 		=> $row['id_member'], 
	    				'date_log' 			=> $row['date_log'],
	    				'date_log_unix' 	=> $row['date_log_unix']
	    			];
	    		}

	    		#Retorno del array cargado de información.
	    		return $getData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que agrega un coordinador.
			*@param: $id_member (Identificador del integrante seleccionado).
		*/
		public function addCoordinator($id_member){
			#Statement: Consulta preparada. 
		    #Tabla: vip_coordinate.
		    #Atributos: id_member.
		    #Valores devueltos: No devuelve ya que se intenta INSERTAR.

			#Variable que almacena las instrucciones de la consulta.
	    	$q = "INSERT INTO vip_coordinate (id_member, date_log, date_log_unix) VALUES (:id_member,:date_log,:date_log_unix);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vinculan los valores con los parámetros.
	    	$stmt->bindValue(":id_member", 		$id_member);
	    	$stmt->bindValue(":date_log", 		date('Y-n-j'));
	    	$stmt->bindValue(":date_log_unix", 	time());

	    	#Se ejecuta la consulta preparada.
	    	if ($stmt->execute())
	    		return true;	#Todo bien.

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que elimina un coordinador de equipo.
			*@param: $id_member (Identificador del integrante).
		*/
	    public function delCoordinator($id_member){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_coordinate.
		    #Atributos: src.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_coordinate '
                . 'WHERE id_member = :id_member');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':id_member', $id_member);

        	#Se ejecuta la consulta.
        	if ($Reason->execute())
	       		return true; #Buen resultado.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    /**
			* Método que agrega imágenes al proyecto.
			*@param: $id_project (Identificador del proyecto), $folder (Directorio donde se almacenan los recursos), $src (Recurso de la imagen: nombre).
		*/
		public function addProjectImg($id_project, $folder, $src){
			#Statement: Consulta preparada. 
		    #Tabla: vip_project_img.
		    #Atributos: id_project, folder, src, date_log, date_log_unix.
		    #Valores devueltos: No devuelve ya que se intenta INSERTAR.

			#Variable que almacena las instrucciones de la consulta.
	    	$q = "INSERT INTO vip_project_img (id_project, folder, src, date_log, date_log_unix) VALUES (:id_project,:folder,:src,:date_log,:date_log_unix);";
	    
	    	#Se prepara la consulta.
	    	$stmt = $this->db->prepare($q);

	    	#Se vinculan los valores con los parámetros.
	    	$stmt->bindValue(":id_project", 	$id_project);
	    	$stmt->bindValue(":folder", 		$folder);
	    	$stmt->bindValue(":src", 			$src);
	    	$stmt->bindValue(":date_log", 		date('Y-n-j'));
	    	$stmt->bindValue(":date_log_unix", 	time());

	    	#Se ejecuta la consulta preparada.
	    	if ($stmt->execute())
	    		return true;	#Todo bien.

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que elimina la imagen temporal apuntada.
			*@param: $src (Recurso de la imagen: nombre).
		*/
	    public function deleteTmpImgById($id){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_tmp_img.
		    #Atributos: src.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_tmp_img '
                . 'WHERE id = :id');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':id', $id);

        	#Se ejecuta la consulta.
        	if ($Reason->execute())
	       		return true; #Buen resultado.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    /**
			* Método que vuelca la información de la tabla vip_tmp_img a vip_project_img.
			*@param: $id_project (Identificador del proyecto).
		*/
	    public function dumpProjectImg($id_project){
	    	#Se habilita el uso de sesiones.
	    	@session_start();
	    	
	    	#Variable de sesión que contiene el nombre de usuario actualmente logueado.
	    	$usr = @$_SESSION['usr'];

	    	#Se verifica que haya información que volcar.
	    	if (is_array($this->getTmpImg($usr))){

	    		#Se procede al volcado de la información.
	    		foreach ($this->getTmpImg($usr) as $value) {
	    			#Se agrega a la nueva tabla con respecto al proyecto.
	    			if ($this->addProjectImg($id_project, $value['folder'], $value['src'])){
	    				#Eliminando el registro de la imagen que se acaba de volcar de la tabla temporal.
	    				$this->deleteTmpImgById($value['id']);
	    			}
	    		}

	    		#Si todo ha salido bien, se retorna un valor booleano verdadero. Agregando una actividad.
	    		if ($this->addActivity(@$usr, 23, "Volcado de las imágenes almacenadas temporalmente al proyecto con ID: ".$id_project))
	    			return 1;

	    	} else if (is_bool($this->getTmpImg($usr))){
	    		#No hay imágenes temporales.
	    		return -5;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return -1;
	    }

	    /**
			* Método que obtiene todos los recursos de vip_project_img.
			*@param: No hay.
		*/
	    public function getProjectImg(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_project_img.
		    #Atributos: -
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_project_img;");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UsersData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UsersData[] = [
	    				'id_project' 	=> $row['id_project'],
	    				'id_img' 		=> $row['id_img'],
	    				'folder' 		=> $row['folder'],
	    				'src' 			=> $row['src'],
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix']
	    			];
	    		}

	    		#Se retorna el array de información.
	    		return $UsersData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que obtiene las imágenes de un proyecto en específico por ID.
			*@param: $id_project (Identificador del proyecto).
		*/
	    public function getProjectImgOnlyById($id_project){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_project_img.
		    #Atributos: -
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_project_img WHERE id_project='".$id_project."';");

	    	#Si existen registros.
	    	if ($stmt->rowCount() > 0){
	    		#Se define un array multidimensional.
	    		$UsersData = [];

	    		#Se recorren las filas devueltas.
	    		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
	    			#Se agrega la información en forma de atributo sobre los índices del array.
	    			$UsersData[] = [
	    				'id_project' 	=> $row['id_project'],
	    				'id_img' 		=> $row['id_img'],
	    				'folder' 		=> $row['folder'],
	    				'src' 			=> $row['src'],
	    				'date_log' 		=> $row['date_log'], 
	    				'date_log_unix' => $row['date_log_unix']
	    			];
	    		}

	    		#Se retorna el array de información.
	    		return $UsersData;
	    	}

	    	#Si algo falla, se retorna un valor booleano falso.
	    	return false;
	    }

	    /**
			* Método que actualiza la ruta del directorio de Users/Usuario al registro de imágenes de un proyecto.
			*@param: $new_usr (Nuevo nombre de usuario), $usr (Nombre de usuario anterior).
		*/
	    public function ChangeUserProjectImg($new_usr, $usr){
	    	#Se verifica que el método devuelva un array con la información necesaria.
	    	if (is_array($this->getProjectImg())){

	    		#Se recorre el array que devuelve y se muestra por medio de la variable $value.
		    	foreach ($this->getProjectImg() as $value) {

		    		#Se hace un split con la función explode.
		    		#explode(): http://php.net/manual/en/function.explode.php

	    			$SplitFolder = explode("/", $value['folder']);

	    			#Se compara el índice 1 con el nombre de usuario anterior.
	    			#Si es correcto, se procede a actualizar la información.
	    			if ($SplitFolder[1] == $usr){

	    				#Actualiza la ruta de las imágenes registradas en un proyecto con respecto al usuario.
	    				$this->updateUserProjectPathImg($new_usr, $value['id_project']);
	    			}
	    		}
	    		
	    		return true;

	    	}

	    	return false;
	    }

	    /**
			* Método que actualiza la ruta del directorio de Users/Usuario.
			*@param: $new_usr (Nuevo nombre de usuario).
		*/
	    public function updateUserProjectPathImg($new_usr, $id_project){
	    	#Se puede observar que el nuevo nombre de usuario ha sido limpiado.
	    	$Path = "users/".$this->CleanString($new_usr)."/project_img"."/";

	    	#Statement: Consulta preparada. 
		    #Tabla: vip_project_img.
		    #Atributos: folder, id_project.
		    #Valores devueltos: - 	

	    	$Reason = $this->db->prepare('UPDATE vip_project_img '
                . 'SET folder = :path '
                . 'WHERE id_project = :id_project');

	    	#Se vincula el valor con el parámetro.
	    	$Reason->bindValue(':path', 		$Path);
        	$Reason->bindValue(':id_project', 	$id_project);

        	#Se ejecuta la consulta preparada.
	    	if ($Reason->execute())
	    		return true;	#Satisfactorio.

	    	#Si algo falla, se retorna una valor booleano falso.
		    return false;
	    }

	    /**
			* Método que elimina una imagen por el nombre del recurso agregado en un proyecto.
			*@param: $id_project (Identificador del proyecto), $src (Recurso de la imagen: nombre).
		*/
	    public function deleteProjectImgBySrc($id_project, $src){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_project_img.
		    #Atributos: src, id_project.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_project_img '
                . 'WHERE id_project = :id_project AND src = :src');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':id_project', 	$id_project);
        	$Reason->bindValue(':src', 			$src);

        	#Se ejecuta la consulta.
        	if ($Reason->execute())
	       		return true; #Buen resultado.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    #####################################################################################
	    #										FIN 										#
	    #####################################################################################
		
		/**
			* Método que elimina un equipo.
			*@param: $id_team (Identificador del equipo).
		*/
	    public function DelTeamComplete($id_team){
	    	#Se habilita el uso de sesiones.
	    	@session_start();

	    	#Statement: Consulta preparada. 
		    #Tabla: vip_team.
		    #Atributos: id_team.
		    #Valores devueltos: No hay, ya que es un DELETE.

	    	$Reason = $this->db->prepare('DELETE FROM vip_team '
                . 'WHERE id_team = :id_team');

	    	#Se vincula el valor con el parámetro.
        	$Reason->bindValue(':id_team', $id_team);

        	#Agregando una nueva actividad.
        	if ($this->addActivity(@$_SESSION['usr'], 36, "Eliminando el equipo con ID: ".$id_team)) #Agrega una actividad.
	        	if ($Reason->execute()) #Se ejecuta la consulta.
		       		return true; #Buen resultado.

	       	#Si algo falla, se retorna un valor booleano falso.
        	return false;
	    }

	    /**
			* Método que obtiene el número de miembros coordinadores que están registrados.
			*@param: No hay.
		*/
	    public function getMemberCoordinateCount(){
	    	#Statement: Consulta no preparada. 
		    #Tabla: vip_coordinate.
		    #Atributos: No hay.
		    #Valores devueltos: Todos los posibles (*).

	    	$stmt = $this->db->query("SELECT * FROM vip_coordinate;");
	    	
	    	#Se retorna la cantidad de filas devueltas por la consulta.
	    	return $stmt->rowCount();
	    }

	}

	/**
		* Función que verifica las sesión, si está logueado o no.
		*@param: No hay.
	*/
	function SessionVerify(){
		#Se verifica si está establecido el uso de sesiones.
		if (!isset($_SESSION))
    		@session_start(); #En caso de que no, se habilitan.

    	#Se verifica si la sesión tiene un valor NO.
    	if (!isset($_SESSION['session']) || $_SESSION['session'] == "No")
    		return false; #En caso de que si haya entrado, se retorna false.

    	#Si existe una sesión de usuario, entonces se retorna true.
    	return true;
	}

	/**
		* Función que conecta con el servidor de base de datos.
		*@param: $db (Nombre de la base de datos).
	*/
	function CDB($db){
		#Retorno de la conexión.
		return new PostgreSQL("localhost", "5432", $db, "postgres", "Windows10");
	}
?>