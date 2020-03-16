<?php 
	session_start();
	if (!isset($_SESSION['email'])) {
		header('Location: login.php');
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Menu</title>


  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  

</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #660066;">
      <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Sair</a>
        	</li>
        </ul>
         <span class="navbar-text; text-white">
      		 <?= 'Bem vindo ' . $_SESSION['email'] ?>
    	</span>
      </div>
  	</nav>

  	<div class="container" style="margin-top: 30px;">

      <div id="tableManager" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Editar Perfil</h2>
            </div>

            <div class="modal-body">
              <input type="text" class="form-control" placeholder="User Name..." id="userName"><br>
              <input class="form-control" id="userEmail" placeholder="Email..."><br>
              <textarea class="form-control" id="userAddress" placeholder="Address."></textarea><br>
              <input type="hidden" id="editRowID" value="0">
            </div>

            <div class="modal-footer">
              <input type="button" id="manageBtn"  value="Save Changes" class="btn btn-success">
            </div>
          </div>
        </div>
      </div>

  		<div class="container">
  			<div class="row">
  				<div class="col-md-8 col-md-offset-2">
  					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<td>Id</td>
								<td>Nome</td>
								<td>E-mail</td>
								<td>Endereço</td>
								<td>Opções</td>
							</tr>
						</thead>
						<tbody>	
						</tbody>
					</table>
  				</div>
  			</div>
  		</div>
  	</div>


    <script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  	<script type="text/javascript">
  		$(document).ready(function() {
        $("#manageBtn").on('click', e => {
          
          var nome = $("#userName")
          var email = $("#userEmail")
          var endereco = $("#userAddress")
          var id = $("#editRowID")

          $.ajax({
            url: 'controller',
            method: 'post',
            dataType: 'text',
            data: {
              acao: 'update',
              nome: nome.val(),
              email: email.val(),
              endereco: endereco.val(),
              id: id.val()
            },
            success: function ( response ) {
              if (response != 'success')
                alert(response)
              else {
                $("#nome_"+id.val()).html(nome.val())
                $("#email_"+id.val()).html(email.val())
                $("#endereco_"+id.val()).html(endereco.val())
                nome.val('')
                endereco.val('')
                email.val('')
                $("#tableManager").modal('hide')
              }
            }
          })
        })


			getDados()
  		})

  		function getDados() {
  			$.ajax({
  				url: 'controller.php',
  				method: 'post',
  				dataType: 'text',
					data: {
						acao: 'getDados',
					},
					success: function ( response ) {
						$('tbody').append(response)
					}
  			})
  		}

      function edit(rowID) {
        $.ajax({
          url: 'controller.php',
          method: 'POST',
          dataType: 'json',
          data: {
            acao: 'getRowData',
            rowID: rowID
          },success: function (response) {
            $("#editRowID").val(rowID);
            $("#userName").val(response.nome);
            $("#userEmail").val(response.email);
            $("#userAddress").val(response.endereco);
            $("#tableManager").modal('show');
          }


        })
      }

      function deleteRow(rowID) {
            if (confirm('Voce deseja isso mesmo??')) {
                $.ajax({
                    url: 'controller.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        acao: 'delete',
                        rowID: rowID
                    }, success: function (response) {
                        window.location = 'index.php';
                        alert(response);
                    }
                });
            }
        }

  	</script>

</body>
</html>