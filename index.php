<?php
//conexão(traz todos os codigosa do arquivo especificado)
require_once 'db_connect.php';
//Sessão
session_start();

if(isset($_POST['bnt-entrar'])):
	$erros= array();
	$login = mysqli_escape_string($connect, $_POST['login']);
	$senha = mysqli_escape_string($connect, $_POST['senha']);

	if(empty($login) or empty($senha)):
		$erros[]="<li> O campo login/senha presisa ser preenchido</li>";
else:
	//codigo que verfica se o login esta no banco de dados
	$sql = "SELECT login FROM usuarios WHERE login = '$login' ";
	//codigo que recolhe o resultado do codigo acima
	$resultado = mysqli_query($connect, $sql);
	//codição para resultado maior que 0
	if(mysqli_num_rows($resultado)> 0):
		//resolve criptrogafia da senha
		$senha = md5($senha);
		// codigo que verifica se existem tanto senha quanto usuario no banco de dados
		$sql = "SELECT * FROM usuarios WHERE login ='$login' AND senha ='$senha'";
		// codigo que recolhe o resulado do codigo acima
		$resultado = mysqli_query($connect, $sql);
		//codigo que verifica se resultado é igual a 1 "é 1 quando é verdadeiro"
		if(mysqli_num_rows($resultado)==1):
			// codigo que iguala dados ao dados ao id do usuario "!!!VERIFICAR DEPOIS SE É ISSO MSM!!!"
			$dados= mysqli_fetch_array($resultado);
			mysqli_close($connect);
			$_SESSION['logado'] = true;
			$_SESSION['id_usuario']=$dados['id'];
			//codigo para redirecionar para outra pagina
			header('Location: home.php');
		else:
			$erros[]="<li>Usuario e senha não existentes</li>";
		endif;
	else:
		$erros[]="<li>Usuario inexistente</li>";
	endif;
endif;
	
endif;
?>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
</head>
<body>
	<h1>Login</h1>
	<?php
	if(!empty($erros)):
		foreach($erros as $erro):
			echo $erro;
		endforeach;
	endif;
	?>
	<hr>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
		Login:<input type="text" name="login"><br>
		Senha:<input type="password" name="senha"><br>
		<button type="submit"name="bnt-entrar"> Entrar </button>

	</form>
	</body>
	</html>