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

// Obtener lista de reservas
function obtenerReservas($conn) {
    // Aquí debes ajustar la consulta según la estructura de tu base de datos
    $sql = "SELECT * FROM reservas_tee_times";
    return $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>StartPlayer</title>
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
      <h2 class="text-center">StartPlayer - Reservas</h2>

      <!-- Lista de Reservas -->
      <table class="table mt-3">
        <thead>
          <tr>
            <th>ID</th>
            <th>Jugador ID</th>
            <th>Fecha Reserva</th>
            <th>Hora Reserva</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Obtener lista de reservas
          $resultReservas = obtenerReservas($conn);

          // Mostrar registros en la tabla
          while ($row = $resultReservas->fetch_assoc()) {
              echo "<tr>";
              echo "<td>{$row['id']}</td>";
              echo "<td>{$row['jugador_id']}</td>";
              echo "<td>{$row['fecha_reserva']}</td>";
              echo "<td>{$row['hora_reserva']}</td>";
              echo "</tr>";
          }
          ?>
        </tbody>
      </table>

      <!-- Botones adicionales o cualquier otra interfaz específica del jugador -->
      <div class="btn-container">
      <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center">Bienvenido a StartPlayer</h2>

            <!-- Botones para StartPlayer.php -->
            <div class="btn-container">
                <a href="reservar_tee_times.php" class="btn btn-primary">Reservar Tee Times</a>
                <a href="consultar_horarios.php" class="btn btn-success">Consultar Horarios de Juego</a>
                <a href="consultar_tarifas.php" class="btn btn-info">Consultar Tarifas</a>
                <a href="index.php" class="btn btn-info">Salir</a>                
            </div>
        </div>
    </div>
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


