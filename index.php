<?php session_start();
include 'client.php';

//Agreagr
if( isset($_POST['ADD_ARTICULO']) ){
	$name = $_POST['name'];
	$precio = $_POST['precio'];
	if( $client->__soapCall("insert", array($name, $precio)) ){
		$msg = array('1', "El artículo se ha agregado");
	}else{
		$msg = array('0', "Lo sentimos, el artículo no se pudo guardar");
	}
	$_SESSION['msg'] = $msg;
}

//Traer datos actualizadooooos
if( isset($_REQUEST['edit']) ){
	$id = $_GET['id'];
	$data = $client->__soapCall("getById", array($id));
}

//Actualizar datosss
if( isset($_POST['UPDATE_ARTICULO']) ){
	$id = $_POST['id'];
	$name = $_POST['name'];
	$precio = $_POST['precio'];
	if( $client->__soapCall("update", array($id, $name, $precio)) ){
		$msg = array('1', "Los datos se han actualizado.");
	}else{
		$msg = array('0', "Lo sentimos, el artículo no se pudo actualizar.");
	}
	$_SESSION['msg'] = $msg;
	
}

//deleting data
if( isset($_REQUEST['delete']) ){
	$id = $_GET['id'];
	if( $client->__soapCall("delete", array($id)) ){
		$msg = array('1', "El artículo se ha eliminado.");
	}else{
		$msg = array('0', "Lo sentimos, el artículo no se pudo eliminar.");
	}
	$_SESSION['msg'] = $msg;

	
}


// to show updating form
$isEdit = isset($_REQUEST['edit']) ? true : false;

?>

<!DOCTYPE html>
<html>
<head>
	<title>CRUD SOAP</title>
	<style type="text/css">
		.red { color: red; }
		.green { color: green; }
	</style>
</head>
<body>
	<div style="margin: 0 auto; width: 800px;">
		<div>
			<form style="display:<?php echo $isEdit ? 'none':'block'; ?>" action="" method="post">
				<input type="text" name='name' placeholder="Enter name">
				<input type="number" name='precio' placeholder="precio" required="">
				<input type="submit" name="ADD_ARTICULO" value="Add">
			</form>

			<form style="display:<?php echo $isEdit ? 'block':'none'; ?>" action="" method="post">
				<input type="hidden" name="id" value="<?php echo isset($data) ? $data['rowid'] : ''; ?>">
				<input type="text" name='name' value="<?php echo isset($data) ? $data['name'] : ''; ?>" placeholder="Enter name">
				<input type="number" name='precio' value="<?php echo isset($data) ? $data['precio'] : ''; ?>" placeholder="Enter email" required="">
				<input type="submit" href="index.php" name="UPDATE_ARTICULO" value="Save">
			</form>

			<?php if( isset($_SESSION['msg']) && !empty($_SESSION['msg']) ){ ?>
			<p class="<?php echo $_SESSION['msg'][0]==0 ? 'red' : 'green';?>"><?php echo $_SESSION['msg'][1];?></p>
			<?php } ?>
		</div>
		<table cellpadding="5" border="1" width="100%">
			<tr>
				<td>ID</td>
				<td>Nombre</td>
				<td>precio</td>
				<td>Acción</td>
			</tr>
			<?php 
			$result = $client->__soapCall("getAll", array());
			foreach($result as $row) {?>
				
			<tr>
				<td><?php echo $row['rowid'];?></td>
				<td><?php echo $row['name'];?></td>
				<td><?php echo $row['precio'];?></td>
				<td>
					<a href="?edit=true&id=<?php echo $row['rowid']; ?>">Editar</a> | 
					<a href="?delete=true&id=<?php echo $row['rowid']; ?>" onclick="return confirm('¿Está Seguro de Elimar este dato?');">Eliminar</a>
				</td>
			</tr>
			<?php } ?>

		</table>
	</div>
<?php $_SESSION['msg'] = array(); ?>
</body>	
</html>