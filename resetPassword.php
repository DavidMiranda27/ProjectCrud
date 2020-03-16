<?php 

	if (isset($_GET['email']) && isset($_GET['token'])) {

		$email = $_GET['email'];
		$token = $_GET['token'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

	<div class="container" style="margin-top: 100px;">
		<div class="row justify-content-center">
         	<div class="col-md-6 col-md-offset-3">
         		<h5 style="margin-left: 150px;">Digite sua nova senha</h5>
            	<form>
					<div class="form-group">
					    <input type="password" class="form-control" name="password" placeholder="Senha">
					</div>
              		<div class="form-group">
                		<input type="hidden" name="acao" value="resetPass">
                		<input type="hidden" name="email" value="<?= $email ?>">
                		<input type="hidden" name="token" value="<?= $token ?>">
              		</div>
					 
					<button type="submit" class="btn btn-primary" style="margin-left: 200px;">Submeter</button>
				</form>
          	</div>
        </div>
	</div>


	<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript">
    	$(document).ready(() => {
    		$('button').on('click', e => {
    			e.preventDefault()
          		let dados = $('form').serialize()

          		//ajax
	        $.ajax({
	            type: 'post',
	            url: 'controller.php',
	            data: dados,
	            success: function (response) {
	            	alert(response)
	            	window.location = 'login.php'
	            },
	          })
    		})
    	})
    </script>

</body>
</html>

<?php


	}

	else {
		header('Location: login.php');
	}

?>