<?php
	

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	session_start();
	

	if (isset($_POST['acao'])) {

		$connection = new mysqli('localhost', 'root', 'root', 'crud');

		
		
		if ($_POST['acao'] == 'addNew') { //adicionar no banco de dados

			$nome = $connection->real_escape_string($_POST['nome']);
			$email = $connection->real_escape_string($_POST['email']);
			$senha = md5($connection->real_escape_string($_POST['password']));
			$endereco = $connection->real_escape_string($_POST['address']);

			$sql = $connection->query("SELECT id FROM users WHERE email = '$email'");
			if ($sql->num_rows > 0) {
				exit('error: Já existe no banco');
			}else {

				$_SESSION['email'] = $_POST['email'];

				$connection->query("INSERT INTO users (nome, email, senha, endereco) VALUES ('$nome','$email','$senha','$endereco')");
				exit('Inserido com sucesso');
			}

			
		} else if ($_POST['acao'] == 'login') {
			$email = $connection->real_escape_string($_POST['email']);
			$senha = md5($connection->real_escape_string($_POST['password']));

			$sql = $connection->query("SELECT id FROM users WHERE email = '$email' 
				AND senha = '$senha'");

			if ($sql->num_rows > 0) {

				$_SESSION['email'] = $_POST['email'];
				exit('logado com sucesso');

			}else {

				exit('Erro ao realizar login');
			}
		} else if ($_POST['acao'] == 'getDados') {

			
			$email =  $connection->real_escape_string($_SESSION['email']);

			$sql = $connection->query("SELECT id, nome, email, endereco FROM users WHERE
				email = '$email'");

			if ($sql->num_rows > 0) {
				$response = "";
				while ($data = $sql->fetch_array()) {
					$response .= '
						<tr>
							<td>'.$data["id"].'</td>
							<td id="nome_'.$data["id"].'">'.$data["nome"].'</td>
							<td id="email_'.$data["id"].'">'.$data["email"].'</td>
							<td id="endereco_'.$data["id"].'">'.$data["endereco"].'</td>
							<td>
								<input type="button" onclick="edit('.$data["id"].')" value="Edit" class="btn btn-primary">
								<input type="button" onclick="deleteRow('.$data["id"].')" value="Delete" class="btn btn-danger">
							</td>
						</tr>
					';
				}
				exit($response);
			}

		} else if ($_POST['acao'] == 'getRowData') {
			$rowID = $connection->real_escape_string($_POST['rowID']);
			$sql = $connection->query("SELECT nome, email, endereco FROM users WHERE id='$rowID'");
			$data = $sql->fetch_array();
			$jsonArray = array(
				'nome' => $data['nome'],
				'email' => $data['email'],
				'endereco' => $data['endereco'],
			);

			exit(json_encode($jsonArray));

		} else if ($_POST['acao'] == 'delete') {
			$rowID = $connection->real_escape_string($_POST['rowID']);
			$connection->query("DELETE FROM users WHERE id='$rowID'");
			unset($_SESSION['email']);
			session_destroy();
			exit('Esse Registro foi removido do sistema');

		} else if ($_POST['acao'] == 'update') {

			$nome = $connection->real_escape_string($_POST['nome']);
			$email = $connection->real_escape_string($_POST['email']);
			$endereco = $connection->real_escape_string($_POST['endereco']);
			$id = $connection->real_escape_string($_POST['id']);

			$connection->query("UPDATE users SET nome='$nome', email='$email', endereco='$endereco' WHERE id='$id'");
			exit('success');
		} else if ($_POST['acao'] == 'forgot') {

			require_once "functions.php";
			$email = $connection->real_escape_string($_POST['email']);

			$query = $connection->query("SELECT id FROM users WHERE email = '$email'");
			if ($query->num_rows > 0) { // O usuario existe na base de dados

				$token = generateNewString();
				
				$connection->query("UPDATE users SET token='$token', 
                      tokenExpire=DATE_ADD(NOW(), INTERVAL 5 MINUTE)
                      WHERE email='$email'");

				require "./PHPMailer/Exception.php";
  				require "./PHPMailer/OAuth.php";
  				require "./PHPMailer/PHPMailer.php";
  				require "./PHPMailer/POP3.php";
  				require "./PHPMailer/SMTP.php";


  				$mail = new PHPMailer();

  				$mail->isSMTP();                                            // Send using SMTP
		      	$mail->Host       = 'smtp.gmail.com';
		      	$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		      	$mail->Username   = 'contasendemail@gmail.com';                     // SMTP username
		      	$mail->Password   = '!#@*4321';                               // SMTP password
		      	$mail->SMTPSecure = 'tls';
		      	$mail->port = 587;

		      	$mail->setFrom('contasendemail@gmail.com');
		      	$mail->addAddress($email);
		      	$mail->isHTML(true);                                  // Set email format to HTML
      			$mail->Subject = 'Reset Password';
		      	$mail->Body =  "
	            	Hi,<br><br>
	            
	            	Um pedido de recuperação de senha, por favor click no link abaixo:<br>
	            	<a href='http://localhost/Project/resetPassword.php?email=$email&token=$token
	            	'>http://localhost/Project/resetPassword.php?email=$email&token=$token</a><br><br>
	            
	            	Forgot Password,<br>
	            	My Name ";

	            if ($mail->send()) {
	            	exit('Por Favor verifique sua caixa de email');
	            }else {
	            	exit('Algo errado, por favor tente novamente');
	            }
			}
			else {
				exit('Algo errado');
			}
		}
		else if ($_POST['acao'] == 'resetPass') {

			$email = $connection->real_escape_string($_POST['email']);
			$novaSenha = md5($connection->real_escape_string($_POST['password']));
			$token = $connection->real_escape_string($_POST['token']);

			$sql = $connection->query("SELECT id FROM users WHERE email='$email'
				AND token='$token' AND token<>'' AND tokenExpire > NOW()");

			if ($sql->num_rows > 0) {
				$connection->query("UPDATE users SET token='', senha = '$novaSenha', tokenExpire=NULL
					WHERE email='$email'");

				exit('Senha alterada com sucesso');
			}
		}

	}

?>