<?php include 'settings.php'; //include settings 
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Musa Abbasov">
  <title>Iniciar sesion</title>
  <link href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>
  <div class="container">
    <div class="row rwcenter">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">

        <div class="card card-signin my-5">
          <div class="card-body">
            <div class="col-md-9 col-lg-6 col-xl-5">
              <img src="./assets/logo-clinica-lircay.png" class="img-fluid" alt="Sample image" style="margin-left: 120px;">
            </div>
            <h5 class="card-title text-center">Sistema estacionamiento</h5>

            <form class="form-signin" action="includes/login.php" method="POST">
              <div class="form-label-group">
                <input name="login" type="text" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputEmail">Correo</label>
              </div>

              <div class="form-label-group">
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Contraseña</label>
              </div>


              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="submit">Iniciar sesion</button>
            </form>
            <!-- Copyright -->
            <div class="text-center p-4" >
              © 2022
              <a class="text-reset fw-bold" href="#">Departamento de Informática | <br>
                 Sub Gerencia Mejora Continua y Experiencia de Pacientes</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</body>

</html>