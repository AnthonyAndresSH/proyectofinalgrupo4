<!-- StartAdmin.php -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Panel de Control - Administrador</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>

    .container {
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      padding: 20px;
      margin-top: 50px;
    }
    .btn-container {
      text-align: center;
      margin-top: 20px;
    }
    .btn-container button {
      margin: 10px;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h2 class="text-center">Panel de Control - Administrador</h2>
      <div class="btn-container">
        <!-- Botones que redirigen a diferentes secciones -->
        <a href="admin_jugadores.php" class="btn btn-primary">Gestionar Jugadores</a>
        <a href="admin_tee_times.php" class="btn btn-primary">Gestionar Tee Times</a>
        <a href="admin_horarios.php" class="btn btn-primary">Gestionar Horarios</a>
        <a href="admin_precios.php" class="btn btn-primary">Gestionar Precios</a>
      </div>
      <div class="btn-container">
                <a href="index.php" class="btn btn-primary">Salir</a>
            </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
