<!DOCTYPE html>
<html>
<head>
	<title>Crud PHP/Ajax/Jquery/MySQL</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>

	<!-- menu -->
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #660066;">

    <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        </ul>
    </div>
  </nav>

  	<!-- paginas -->
  	<div class="main" id="pagina">
  		<div class="container" style="margin-top: 30px;">
  			<div class="row">
  				<div class="col-md-6 offset-md-3">
  					<form>
  						<div class="form-group">
					    	<input type="text" class="form-control" name="nome" placeholder="Nome">
					  	</div>
						<div class="form-group">
					    	<input type="email" class="form-control" name="email" placeholder="E-mail">
					  	</div>
					  	<div class="form-group">
					    	<input type="password" class="form-control" name="password" placeholder="Senha">
					  	</div>
					  	<div class="form-group">
					    	<input type="text" class="form-control" name="address" placeholder="Endereco">
					  	</div>
              <div class="form-group">
                <input type="hidden" name="acao" value="addNew">
              </div>
					 
					  	<button type="submit" class="btn btn-primary">Submit</button>
					</form>
  				</div>
  			</div>
  		</div>
  	</div>

    <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
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
              if (response.indexOf('sucesso') >= 0) {
                window.location = 'menu.php';

              }
              else {
                alert('Esse E-mail já existe no banco')
              }
            },
            error: erro => { console.log(erro) }
          })
        })
      })

    </script>

</body>
</html>