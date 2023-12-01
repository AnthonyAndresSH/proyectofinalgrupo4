<?php
// Aquí debes incluir la conexión a la base de datos y cualquier función necesaria

// Verificar la conexión a la base de datos
$servername = "localhost";
$username = "id21473610_andres";
$password = "Andres123**";
$dbname = "id21473610_golf";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para reservar Tee Time
function reservarTeeTime($conn, $jugador_id, $fecha_reserva, $hora_reserva) {
    $sql = "INSERT INTO reservas_tee_times (jugador_id, fecha_reserva, hora_reserva) VALUES ('$jugador_id', '$fecha_reserva', '$hora_reserva')";
    return $conn->query($sql);
}

// Manejar acciones de formulario (Reservar Tee Time)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["reservarTeeTime"])) {
        reservarTeeTime($conn, $_POST["jugador_id"], $_POST["fecha_reserva"], $_POST["hora_reserva"]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Reservar Tee Time</title>
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
      <h2 class="text-center">Reservar Tee Time</h2>

      <!-- Formulario para reservar Tee Time -->
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
          <div class="form-group col-md-4">
            <input type="text" class="form-control" placeholder="ID del Jugador" name="jugador_id" required>
          </div>
          <div class="form-group col-md-4">
            <input type="date" class="form-control" name="fecha_reserva" required>
          </div>
          <div class="form-group col-md-4">
            <input type="time" class="form-control" name="hora_reserva" required>
          </div>
        </div>
        <div class="btn-container">
          <button type="submit" class="btn btn-success" name="reservarTeeTime">Reservar Tee Time</button>
        </div>
      </form>

      <!-- Lista de Tee Times reservados -->
      <!-- Puedes agregar aquí la lógica para mostrar las reservas si lo deseas -->

      <!-- Botón para regresar a StartPlayer.php -->
      <div class="btn-container">
        <a href="startplayer.php" class="btn btn-secondary">Volver a StartPlayer</a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
