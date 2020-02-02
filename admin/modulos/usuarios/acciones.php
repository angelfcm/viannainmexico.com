<?php 
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// Nuevo Administrador
if(isset($_REQUEST['new-user'])){
	if(isset($_REQUEST['user'])){ $user=strtolower($_REQUEST['user']); }else{ $user=false; $legendFail.="<br><br>Proporcione nombre de usuario";}
	if(isset($_REQUEST['pass'])){ $pass=$_REQUEST['pass']; }else{ $pass=false; $legendFail.="<br><br>Proporcione contraseña";}
	if(isset($_REQUEST['pass1'])){ $pass1=$_REQUEST['pass1']; }else{ $pass1=false; $legendFail.="<br><br>Confirme su contraseña";}
	if(strlen($pass)>5){
		if($pass==$pass1 and $user!=false){
			$pass_encripted = md5($pass);

			$USER = $CONEXION -> query("SELECT * FROM user WHERE user = '$user'");
			$numRows = $USER ->num_rows;
			if ($numRows==0) {

				$sql = "INSERT INTO user (pass,user,nivel)".
					"VALUES ('$pass_encripted','$user',1)";
				if($insertar = $CONEXION->query($sql))
				{
					$exito='success';
					$legendSuccess.="<br>Administrador agregado";
				}else{
					$fallo='danger';  
					$legendFail.="<br>No se pudo agregar el Administrador";
				}
			}else{
				$fallo='danger';  
				$legendFail.="<br>El usuario ya existe";
			}
		}else{
			$fallo='danger';  
			$legendFail.="<br>Las contraseñas no coinciden ";
		}
	}else{
		$fallo='danger';  
		$legendFail.="<br>La contraseña es demasiado débil ";
	}
}

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// Editar Administrador
if(isset($_REQUEST['edit-user'])){
	if(isset($_REQUEST['user'])){ $user=strtolower($_REQUEST['user']); }else{ $user=false; $legendFail.="<br><br>Proporcione nombre de usuario";}
	if(isset($_REQUEST['pass'])){ $pass=$_REQUEST['pass']; }else{ $pass=false; $legendFail.="<br><br>Proporcione contraseña";}
	if(isset($_REQUEST['pass1'])){ $pass1=$_REQUEST['pass1']; }else{ $pass1=false; $legendFail.="<br><br>Confirme su contraseña";}
	if(strlen($pass)>5){
		if($pass==$pass1){
			$pass_encripted = md5($pass);

			if(
				$actualizar = $CONEXION->query("UPDATE user SET user = '$user' WHERE id = $id")
			and	$actualizar = $CONEXION->query("UPDATE user SET pass = '$pass_encripted' WHERE id = $id")
				)
			{
				$exito='success';
				$legendSuccess.="<br>Administrador editado";
			}else{
				$fallo='danger';  
				$legendFail.="<br>No se pudo modificar el Administrador";
			}
		}else{
			$fallo='danger';  
			$legendFail.="<br>Contraseñas no coinciden";
		}
	}else{
		$fallo='danger';  
		$legendFail.="<br>Contraseña demasiado débil";
	}
}

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// Borrar Administrador
if(isset($_REQUEST['borrarUser'])){
	if($borrar = $CONEXION->query("DELETE FROM user WHERE id = $id"))
	{
		$exito='success';
		$legendSuccess.="<br>Administrador eliminado";
	}else{
		$fallo='danger';  
		$legendFail.="<br>No se pudo eliminar el Administrador";
	}
} 

//%%%%%%%%%%%%%%%%%%%%%%%%%%    Editar nivel     %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%			
if (isset($_POST['editanivel'])) {
	include '../../../includes/connection.php';
	
	$id = $_POST['id'];
	$nivel = $_POST['nivel'];

	$actualizar = $CONEXION->query("UPDATE user SET nivel = $nivel WHERE id = $id");
}
