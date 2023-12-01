<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sistema de Reservas - Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    body {
      background: url('https://www.toptal.com/designers/subtlepatterns/patterns/symphony.png');
    }
    .container {
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      padding: 20px;
      margin-top: 50px;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center">Iniciar Sesión</h3>
        </div>
        <div class="card-body">
          <!-- Se ha cambiado el valor de procesar_login.php -->
          <form action="procesar_login.php" method="POST">
            <div class="form-group">
              <label for="usuario">Usuario:</label>
              <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
              <label for="contrasena">Contraseña:</label>
              <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <div class="form-group">
              <label for="rol">Rol:</label>
              <select class="form-control" id="rol" name="rol" required>
                <option value="Administrador">Administrador</option>
                <option value="Jugador">Jugador</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
