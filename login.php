<!DOCTYPE html>
<html>
<head>
	<title>Login</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
</head>
<body>

	<!-- menu -->
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #660066;">
    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
      	<ul class="navbar-nav mr-auto">
       		<li class="nav-item">
          		<a class="nav-link" href="index.php">Cadastro</a>
        		</li>
       	</ul>
    </div>
  </nav>


  	<!-- paginas -->
  	<div class="main" id="paginaLogin">
  		<div class="container" style="margin-top: 30px;">

        <div id="formEmail" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Digite seu E-mail</h2>
              </div>

              <div class="modal-body">
                <input type="text" class="form-control" placeholder="Email" id="userEmail"><br>
              </div>

              <div class="modal-footer">
                <input type="button" onclick="recuperarEmail('forgot')"  value="Enviar" class="btn btn-success">
              </div>
            </div>
          </div>
        </div>

  			<div class="row justify-content-center">
  				<div class="col-md-6 col-md-offset-3">
  					<form>
						<div class="form-group">
					    	<input type="email" class="form-control" name="email" placeholder="E-mail">
					  	</div>
					  	<div class="form-group">
					    	<input type="password" class="form-control" name="password" placeholder="Senha">
					  	</div>
              			<div class="form-group">
               				 <input type="hidden" name="acao" value="login">
             			 </div>
					  	<button type="submit" id="btnLogin" class="btn btn-primary" style="margin-left: 220px;">Logar</button>
					</form>
  				</div>
  			</div>
        <div class="row justify-content-center" style="margin-top: 50px;">
          <div class="col-md-6 col-md-offset-3">
            <h5 style="margin-left: 170px;">Esqueceu a senha ??</h5>
            <button type="submit" id="btnForgot" class="btn btn-primary" style="margin-left: 207px;">Recuperar</button>
          </div>
        </div>
  		</div>
  	</div>

    <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  	<script type="text/javascript">
  		$(document).ready(() => {
  			$('#btnLogin').on('click', e =>{
  				e.preventDefault()
  				let dados = $('form').serialize()

  				$.ajax({
		            type: 'post',
		            url: 'controller.php',
		            data: dados,
		            success: function (response) {
		            	if (response.indexOf('sucesso') >= 0) {
		                	window.location = 'menu.php';
                      alert("Login success");
		              	}
		              	else {
		                	alert('E-mail ou Senha inválidos')
		              	}
		            },
		            error: erro => { console.log(erro) }
		        })
  			})

        $("#btnForgot").on('click', e => {
          $('#formEmail').modal('show')
        })

  		})

      function recuperarEmail(acao) {
        var email = $("#userEmail")

        if (email.val() != "") {
          
          $.ajax({
            type: 'post',
            url: 'controller.php',
            data: {
              acao: acao,
              email: email.val()
            },
            success: function (response) {
              $('#formEmail').modal('hide')
              alert(response)
            }
          })
        }else {
          alert('Campo vazio')
        }

      }

  	</script>
</body>
</html>